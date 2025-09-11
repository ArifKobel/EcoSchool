<?php

namespace App\Observers;

use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        Question::reorderAfterDeletion($question->category_id);
    }
}
