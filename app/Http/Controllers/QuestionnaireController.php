<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    /**
     * Zeige die nächste Frage oder den Fragebogen-Start
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        if ($user->hasCompletedQuestionnaire()) {
            return redirect()->route('results.show', $user->finalResult);
        }

        $questions = Question::active()->ordered()->get();

        $nextQuestion = $this->getNextUnansweredQuestion($user, $questions);

        if (!$nextQuestion) {
            return $this->completeQuestionnaire($user);
        }

        $totalQuestions = $questions->count();
        $answeredQuestions = $user->answers()->count();
        $progress = $user->getProgressPercentage();

        return view('questionnaire.show', compact(
            'nextQuestion',
            'progress',
            'totalQuestions',
            'answeredQuestions'
        ));
    }

    /**
     * Speichere eine Antwort
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|boolean'
        ]);

        $user = Auth::user();
        $questionId = $request->question_id;
        $answer = $request->boolean('answer');

        DB::transaction(function () use ($user, $questionId, $answer) {
            $existingAnswer = Answer::where('user_id', $user->id)
                ->where('question_id', $questionId)
                ->first();

            if ($existingAnswer) {
                $existingAnswer->update([
                    'answer' => $answer,
                    'points_awarded' => $answer ? 1 : 0,
                    'answered_at' => now()
                ]);
            } else {
                Answer::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'points_awarded' => $answer ? 1 : 0,
                    'answered_at' => now()
                ]);
            }
        });

        $totalQuestions = Question::active()->count();
        $userAnswers = $user->answers()->count();

        if ($userAnswers >= $totalQuestions) {
            return $this->completeQuestionnaire($user);
        }

        return redirect()->route('questionnaire.show');
    }

    /**
     * Schließe den Fragebogen ab und berechne Ergebnis
     */
    private function completeQuestionnaire($user)
    {
        DB::transaction(function () use ($user) {
            $totalPoints = $user->answers()->where('answer', true)->sum('points_awarded');
            $totalQuestions = Question::active()->count();
            if ($totalQuestions === 0) {
                $percentage = 0;
            } else {
                $percentage = round(($totalPoints / $totalQuestions) * 100, 2);
            }
            
            $status = Result::calculateStatus($percentage);

            $categoryScores = $this->calculateCategoryScores($user);

            Result::updateOrCreate(
                ['user_id' => $user->id, 'is_final' => true],
                [
                    'total_points' => $totalPoints,
                    'max_points' => $totalQuestions,
                    'percentage' => $percentage,
                    'status' => $status,
                    'category_scores' => $categoryScores,
                    'completed_at' => now(),
                    'is_final' => true
                ]
            );
        });

        $result = $user->finalResult;
        return redirect()->route('results.show', $result);
    }

    /**
     * Berechne Punkte pro Kategorie
     */
    private function calculateCategoryScores($user)
    {
        $scores = [];
        $categories = \App\Models\Category::all();

        foreach ($categories as $category) {
            $categoryQuestions = $category->activeQuestions;
            $categoryAnswers = $user->answers()
                ->whereHas('question', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->where('answer', true)
                ->count();

            $scores[$category->slug] = [
                'points' => $categoryAnswers,
                'max_points' => $categoryQuestions->count(),
                'percentage' => $categoryQuestions->count() > 0
                    ? round(($categoryAnswers / $categoryQuestions->count()) * 100, 2)
                    : 0
            ];
        }

        return $scores;
    }

    /**
     * Finde die nächste unbeantwortete Frage
     */
    private function getNextUnansweredQuestion($user, $questions)
    {
        foreach ($questions as $question) {
            $answer = $user->answers()->where('question_id', $question->id)->first();
            if (!$answer) {
                return $question;
            }
        }

        return null;
    }

    /**
     * Zeige den Fortschritt
     */
    public function progress()
    {
        $user = Auth::user();
        $progress = $user->getProgressPercentage();

        return response()->json([
            'progress' => $progress,
            'completed' => $user->hasCompletedQuestionnaire()
        ]);
    }

    /**
     * Fragebogen zurücksetzen und neu starten
     */
    public function reset(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            $user->answers()->delete();

            $user->results()->where('is_final', false)->delete();

            $user->results()->where('is_final', true)->update(['is_final' => false]);
        });

        return redirect()->route('questionnaire.show')->with('success', 'Fragebogen wurde zurückgesetzt. Sie können ihn nun erneut durchführen.');
    }

    /**
     * Fragebogen für Gäste zurücksetzen und neu starten
     */
    public function resetGuest(Request $request)
    {
        // Debug-Ausgabe für Testing
        if ($request->has('debug')) {
            return response()->json([
                'message' => 'ResetGuest method reached',
                'session_id' => $request->session()->getId(),
                'method' => $request->method(),
                'has_guest_answers' => $request->session()->has('guest_answers'),
                'has_guest_result' => $request->session()->has('guest_result')
            ]);
        }

        // Session-Daten für Gäste zurücksetzen
        $request->session()->forget(['guest_answers', 'guest_result']);

        // Stelle sicher, dass die Session aktualisiert wird
        $request->session()->save();

        return redirect()->route('guest.questionnaire.show')->with('success', 'Fragebogen wurde zurückgesetzt. Sie können ihn nun erneut durchführen.');
    }

    /**
     * Zeige die nächste Frage für Gäste
     */
    public function showGuest(Request $request)
    {
        $questions = Question::active()->ordered()->get();

        $guestAnswers = $request->session()->get('guest_answers', []);
        $nextQuestion = $this->getNextUnansweredQuestionForGuest($guestAnswers, $questions);

        if (!$nextQuestion) {
            return $this->completeGuestQuestionnaire($request);
        }

        $totalQuestions = $questions->count();
        $answeredQuestions = count($guestAnswers);
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 1) : 0;

        return view('questionnaire.show', compact(
            'nextQuestion',
            'progress',
            'totalQuestions',
            'answeredQuestions'
        ))->with('is_guest', true);
    }

    /**
     * Speichere eine Gast-Antwort
     */
    public function storeGuest(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|boolean'
        ]);

        $questionId = $request->question_id;
        $answer = $request->boolean('answer');

        $guestAnswers = $request->session()->get('guest_answers', []);
        $guestAnswers[$questionId] = [
            'answer' => $answer,
            'points_awarded' => $answer ? 1 : 0,
            'answered_at' => now()->toISOString()
        ];

        $request->session()->put('guest_answers', $guestAnswers);

        $totalQuestions = Question::active()->count();
        $answeredQuestions = count($guestAnswers);

        if ($answeredQuestions >= $totalQuestions) {
            return $this->completeGuestQuestionnaire($request);
        }

        return redirect()->route('guest.questionnaire.show');
    }

    /**
     * Schließe den Gast-Fragebogen ab und berechne Ergebnis
     */
    private function completeGuestQuestionnaire(Request $request)
    {
        $guestAnswers = $request->session()->get('guest_answers', []);
        $totalPoints = collect($guestAnswers)->sum('points_awarded');
        $totalQuestions = Question::active()->count();

        if ($totalQuestions === 0) {
            $percentage = 0;
        } else {
            $percentage = round(($totalPoints / $totalQuestions) * 100, 2);
        }

        $status = Result::calculateStatus($percentage);
        $categoryScores = $this->calculateGuestCategoryScores($guestAnswers);

        $guestResult = [
            'total_points' => $totalPoints,
            'max_points' => $totalQuestions,
            'percentage' => $percentage,
            'status' => $status,
            'category_scores' => $categoryScores,
            'completed_at' => now()->toISOString(),
            'is_guest' => true
        ];

        $request->session()->put('guest_result', $guestResult);

        return redirect()->route('guest.results.show');
    }

    /**
     * Berechne Punkte pro Kategorie für Gäste
     */
    private function calculateGuestCategoryScores($guestAnswers)
    {
        $scores = [];
        $categories = \App\Models\Category::all();

        foreach ($categories as $category) {
            $categoryQuestions = $category->activeQuestions;
            $categoryAnswers = 0;

            foreach ($categoryQuestions as $question) {
                if (isset($guestAnswers[$question->id]) && $guestAnswers[$question->id]['answer']) {
                    $categoryAnswers++;
                }
            }

            $scores[$category->slug] = [
                'points' => $categoryAnswers,
                'max_points' => $categoryQuestions->count(),
                'percentage' => $categoryQuestions->count() > 0
                    ? round(($categoryAnswers / $categoryQuestions->count()) * 100, 2)
                    : 0
            ];
        }

        return $scores;
    }

    /**
     * Finde die nächste unbeantwortete Frage für Gäste
     */
    private function getNextUnansweredQuestionForGuest($guestAnswers, $questions)
    {
        foreach ($questions as $question) {
            if (!isset($guestAnswers[$question->id])) {
                return $question;
            }
        }

        return null;
    }

    /**
     * Zeige den Fortschritt für Gäste
     */
    public function progressGuest(Request $request)
    {
        $guestAnswers = $request->session()->get('guest_answers', []);
        $totalQuestions = Question::active()->count();
        $answeredQuestions = count($guestAnswers);
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 1) : 0;

        return response()->json([
            'progress' => $progress,
            'completed' => $answeredQuestions >= $totalQuestions
        ]);
    }

}
