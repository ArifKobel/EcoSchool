<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'category_id',
        'question_text',
        'order',
        'is_active',
        'points',
        'help_text',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'points' => 'integer',
        'metadata' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function userAnswer(User $user): ?Answer
    {
        return $this->answers()->where('user_id', $user->id)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->join('categories', 'questions.category_id', '=', 'categories.id')
                    ->orderBy('categories.weight', 'asc')
                    ->orderBy('questions.order', 'asc')
                    ->select('questions.*');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            if ($question->order === null) {
                $question->order = static::where('category_id', $question->category_id)->max('order') + 1;
            }
        });

        static::updating(function ($question) {
            if ($question->isDirty('category_id')) {
                $question->order = static::where('category_id', $question->category_id)->max('order') + 1;
            }
        });
    }

    protected static function reorderAfterDeletion($categoryId)
    {
        $questions = static::where('category_id', $categoryId)
            ->orderBy('order')
            ->get();

        foreach ($questions as $index => $question) {
            $question->update(['order' => $index + 1]);
        }
    }

    public function moveOrderUp()
    {
        $previousQuestion = static::where('category_id', $this->category_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousQuestion) {
            $tempOrder = $this->order;
            $this->update(['order' => $previousQuestion->order]);
            $previousQuestion->update(['order' => $tempOrder]);
        }
    }

    public function moveOrderDown()
    {
        $nextQuestion = static::where('category_id', $this->category_id)
            ->where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextQuestion) {
            $tempOrder = $this->order;
            $this->update(['order' => $nextQuestion->order]);
            $nextQuestion->update(['order' => $tempOrder]);
        }
    }
}
