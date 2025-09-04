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

        // Prüfe ob der User den Fragebogen bereits abgeschlossen hat
        if ($user->hasCompletedQuestionnaire()) {
            return redirect()->route('results.show', $user->finalResult);
        }

        // Hole alle aktiven Fragen
        $questions = Question::active()->ordered()->get();

        // Finde die nächste unbeantwortete Frage
        $nextQuestion = $this->getNextUnansweredQuestion($user, $questions);

        if (!$nextQuestion) {
            // Alle Fragen beantwortet - leite zum Abschluss
            return $this->completeQuestionnaire($user);
        }

        // Berechne Fortschritt
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
            // Prüfe ob bereits eine Antwort existiert
            $existingAnswer = Answer::where('user_id', $user->id)
                ->where('question_id', $questionId)
                ->first();

            if ($existingAnswer) {
                // Aktualisiere bestehende Antwort
                $existingAnswer->update([
                    'answer' => $answer,
                    'points_awarded' => $answer ? 1 : 0,
                    'answered_at' => now()
                ]);
            } else {
                // Erstelle neue Antwort
                Answer::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'points_awarded' => $answer ? 1 : 0,
                    'answered_at' => now()
                ]);
            }
        });

        // Prüfe ob alle Fragen beantwortet wurden
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
            // Berechne Gesamtpunkte
            $totalPoints = $user->answers()->where('answer', true)->sum('points_awarded');
            $totalQuestions = Question::active()->count();
            if ($totalQuestions === 0) {
                $percentage = 0;
            } else {
                $percentage = round(($totalPoints / $totalQuestions) * 100, 2);
            }
            
            // Bestimme Status
            $status = Result::calculateStatus($percentage);

            // Berechne Punkte pro Kategorie
            $categoryScores = $this->calculateCategoryScores($user);

            // Erstelle oder aktualisiere finales Ergebnis
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
            // Alle Antworten des Users löschen
            $user->answers()->delete();

            // Alle Ergebnisse des Users löschen (nur nicht-final, um finale Ergebnisse zu behalten)
            $user->results()->where('is_final', false)->delete();

            // Das finale Ergebnis als nicht-final markieren, damit es überschrieben werden kann
            $user->results()->where('is_final', true)->update(['is_final' => false]);
        });

        return redirect()->route('questionnaire.show')->with('success', 'Fragebogen wurde zurückgesetzt. Sie können ihn nun erneut durchführen.');
    }
}
