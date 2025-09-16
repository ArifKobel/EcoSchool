<?php

namespace Tests\Unit;

use App\Models\Question;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function test_question_can_be_created(): void
    {
        $question = new Question([
            'category_id' => 1,
            'question_text' => 'Test question?',
            'order' => 1,
            'is_active' => true,
            'points' => 1
        ]);

        $this->assertEquals('Test question?', $question->question_text);
        $this->assertEquals(1, $question->order);
        $this->assertTrue($question->is_active);
        $this->assertEquals(1, $question->points);
    }
}
