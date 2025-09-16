<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    /** */
    public function show(Request $request)
    {
        $user = Auth::user();

        if ($user->hasCompletedQuestionnaire()) {
            return redirect()->route('results.show', $user->finalResult);
        }

        $categories = $this->getOrderedCategories();
        $nextCategory = $this->findNextIncompleteCategoryForUser($user, $categories);

        if (!$nextCategory) {
            return $this->completeQuestionnaire($user);
        }

        return redirect()->route('questionnaire.category.show', $nextCategory);
    }

    /** */
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

    /** */
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

    /** */
    public function showCategory(Category $category)
    {
        $user = Auth::user();

        if ($user->hasCompletedQuestionnaire()) {
            return redirect()->route('results.show', $user->finalResult);
        }

        $categories = $this->getOrderedCategories();
        [$previousCategory, $nextCategory] = $this->getPrevNextCategories($categories, $category);

        $questions = $category->activeQuestions;

        $existingAnswers = $user->answers()
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        $totalQuestions = Question::active()->count();
        $answeredQuestions = $user->answers()->count();
        $progress = $user->getProgressPercentage();

        return view('questionnaire.category', compact(
            'category',
            'categories',
            'questions',
            'existingAnswers',
            'previousCategory',
            'nextCategory',
            'totalQuestions',
            'answeredQuestions',
            'progress'
        ));
    }

    /** */
    public function storeCategory(Request $request, Category $category)
    {
        $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $user, $category) {
            $answers = $request->input('answers', []);
            $questions = $category->activeQuestions;

            foreach ($questions as $question) {
                if (!array_key_exists((string)$question->id, $answers) && !array_key_exists($question->id, $answers)) {
                    continue;
                }

                $value = $answers[$question->id] ?? $answers[(string)$question->id] ?? null;
                if ($value === null || $value === '') {
                    continue;
                }

                $answerBool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($answerBool === null) {
                    continue;
                }

                $existing = Answer::where('user_id', $user->id)
                    ->where('question_id', $question->id)
                    ->first();

                if ($existing) {
                    $existing->update([
                        'answer' => $answerBool,
                        'points_awarded' => $answerBool ? 1 : 0,
                        'answered_at' => now()
                    ]);
                } else {
                    Answer::create([
                        'user_id' => $user->id,
                        'question_id' => $question->id,
                        'answer' => $answerBool,
                        'points_awarded' => $answerBool ? 1 : 0,
                        'answered_at' => now()
                    ]);
                }
            }
        });

        $totalQuestions = Question::active()->count();
        $userAnswers = $user->answers()->count();

        if ($userAnswers >= $totalQuestions) {
            return $this->completeQuestionnaire($user);
        }

        $categories = $this->getOrderedCategories();
        [$previousCategory, $nextCategory] = $this->getPrevNextCategories($categories, $category);

        if ($nextCategory) {
            return redirect()->route('questionnaire.category.show', $nextCategory);
        }

        $nextIncomplete = $this->findNextIncompleteCategoryForUser($user, $categories);
        if ($nextIncomplete) {
            return redirect()->route('questionnaire.category.show', $nextIncomplete);
        }

        return redirect()->route('questionnaire.show');
    }

    /** */
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

    /** */
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

    /** */
    public function progress()
    {
        $user = Auth::user();
        $progress = $user->getProgressPercentage();

        return response()->json([
            'progress' => $progress,
            'completed' => $user->hasCompletedQuestionnaire()
        ]);
    }

    /** */
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

    /** */
    public function resetGuest(Request $request)
    {
        if ($request->has('debug')) {
            return response()->json([
                'message' => 'ResetGuest method reached',
                'session_id' => $request->session()->getId(),
                'method' => $request->method(),
                'has_guest_answers' => $request->session()->has('guest_answers'),
                'has_guest_result' => $request->session()->has('guest_result')
            ]);
        }

        $request->session()->forget(['guest_answers', 'guest_result']);

        $request->session()->save();

        return redirect()->route('guest.questionnaire.show')->with('success', 'Fragebogen wurde zurückgesetzt. Sie können ihn nun erneut durchführen.');
    }

    /** */
    public function showGuest(Request $request)
    {
        $guestAnswers = $request->session()->get('guest_answers', []);

        $categories = $this->getOrderedCategories();
        $nextCategory = $this->findNextIncompleteCategoryForGuest($guestAnswers, $categories);

        if (!$nextCategory) {
            return $this->completeGuestQuestionnaire($request);
        }

        return redirect()->route('guest.questionnaire.category.show', $nextCategory);
    }

    /** */
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

    /** */
    public function showGuestCategory(Request $request, Category $category)
    {
        $guestAnswers = $request->session()->get('guest_answers', []);

        $categories = $this->getOrderedCategories();
        [$previousCategory, $nextCategory] = $this->getPrevNextCategories($categories, $category);

        $questions = $category->activeQuestions;

        $totalQuestions = Question::active()->count();
        $answeredQuestions = count($guestAnswers);
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 1) : 0;

        return view('questionnaire.category', [
            'category' => $category,
            'categories' => $categories,
            'questions' => $questions,
            'existingAnswers' => collect($guestAnswers),
            'previousCategory' => $previousCategory,
            'nextCategory' => $nextCategory,
            'totalQuestions' => $totalQuestions,
            'answeredQuestions' => $answeredQuestions,
            'progress' => $progress,
            'is_guest' => true,
        ]);
    }

    /** */
    public function storeGuestCategory(Request $request, Category $category)
    {
        $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable',
        ]);

        $answers = $request->input('answers', []);
        $guestAnswers = $request->session()->get('guest_answers', []);
        $questions = $category->activeQuestions;

        foreach ($questions as $question) {
            if (!array_key_exists((string)$question->id, $answers) && !array_key_exists($question->id, $answers)) {
                continue;
            }

            $value = $answers[$question->id] ?? $answers[(string)$question->id] ?? null;
            if ($value === null || $value === '') {
                continue;
            }

            $answerBool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($answerBool === null) {
                continue;
            }

            $guestAnswers[$question->id] = [
                'answer' => $answerBool,
                'points_awarded' => $answerBool ? 1 : 0,
                'answered_at' => now()->toISOString()
            ];
        }

        $request->session()->put('guest_answers', $guestAnswers);

        $totalQuestions = Question::active()->count();
        $answeredQuestions = count($guestAnswers);

        if ($answeredQuestions >= $totalQuestions) {
            return $this->completeGuestQuestionnaire($request);
        }

        $categories = $this->getOrderedCategories();
        [$previousCategory, $nextCategory] = $this->getPrevNextCategories($categories, $category);

        if ($nextCategory) {
            return redirect()->route('guest.questionnaire.category.show', $nextCategory);
        }

        $nextIncomplete = $this->findNextIncompleteCategoryForGuest($guestAnswers, $categories);
        if ($nextIncomplete) {
            return redirect()->route('guest.questionnaire.category.show', $nextIncomplete);
        }

        return redirect()->route('guest.questionnaire.show');
    }

    /** */
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

    /** */
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

    /** */
    private function getNextUnansweredQuestionForGuest($guestAnswers, $questions)
    {
        foreach ($questions as $question) {
            if (!isset($guestAnswers[$question->id])) {
                return $question;
            }
        }

        return null;
    }

    /** */
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

    /** */
    private function getOrderedCategories()
    {
        return Category::orderBy('weight')->orderBy('id')->get();
    }

    /** */
    private function getPrevNextCategories($categories, Category $current)
    {
        $previous = null;
        $next = null;

        foreach ($categories as $index => $cat) {
            if ($cat->id === $current->id) {
                $previous = $index > 0 ? $categories[$index - 1] : null;
                $next = $index < ($categories->count() - 1) ? $categories[$index + 1] : null;
                break;
            }
        }

        return [$previous, $next];
    }

    /** */
    private function findNextIncompleteCategoryForUser($user, $categories)
    {
        foreach ($categories as $category) {
            $questionIds = $category->activeQuestions->pluck('id');
            $total = $questionIds->count();
            if ($total === 0) {
                continue;
            }
            $answered = $user->answers()->whereIn('question_id', $questionIds)->count();
            if ($answered < $total) {
                return $category;
            }
        }
        return null;
    }

    /** */
    private function findNextIncompleteCategoryForGuest($guestAnswers, $categories)
    {
        foreach ($categories as $category) {
            $questionIds = $category->activeQuestions->pluck('id');
            $total = $questionIds->count();
            if ($total === 0) {
                continue;
            }
            $answered = 0;
            foreach ($questionIds as $qid) {
                if (isset($guestAnswers[$qid])) {
                    $answered++;
                }
            }
            if ($answered < $total) {
                return $category;
            }
        }
        return null;
    }

}
