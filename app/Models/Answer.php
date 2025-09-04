<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'points_awarded',
        'answered_at'
    ];

    protected $casts = [
        'answer' => 'boolean',
        'points_awarded' => 'integer',
        'answered_at' => 'datetime'
    ];

    /**
     * Get the user that owns this answer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that this answer belongs to.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Scope for yes answers.
     */
    public function scopeYes($query)
    {
        return $query->where('answer', true);
    }

    /**
     * Scope for no answers.
     */
    public function scopeNo($query)
    {
        return $query->where('answer', false);
    }
}
