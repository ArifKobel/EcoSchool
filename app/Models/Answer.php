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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeYes($query)
    {
        return $query->where('answer', true);
    }

    public function scopeNo($query)
    {
        return $query->where('answer', false);
    }
}
