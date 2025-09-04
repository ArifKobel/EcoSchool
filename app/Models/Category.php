<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'weight',
        'question_count'
    ];

    protected $casts = [
        'weight' => 'integer',
        'question_count' => 'integer'
    ];

    /**
     * Get the questions for this category.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    /**
     * Get only active questions for this category.
     */
    public function activeQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->where('is_active', true)->orderBy('order');
    }
}
