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

    /**
     * Get the category that owns this question.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the answers for this question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get answers from a specific user.
     */
    public function userAnswer(User $user): ?Answer
    {
        return $this->answers()->where('user_id', $user->id)->first();
    }

    /**
     * Scope for active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering questions.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
