<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school_name',
        'school_type',
        'school_location',
        'role',
        'data_consent',
        'consent_given_at',
        'anonymous_mode',
        'preferences'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data_consent' => 'boolean',
            'consent_given_at' => 'datetime',
            'anonymous_mode' => 'boolean',
            'preferences' => 'array'
        ];
    }

    /**
     * Get the answers for this user.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the results for this user.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get the latest result for this user.
     */
    public function latestResult()
    {
        return $this->hasOne(Result::class)->latestOfMany();
    }

    /**
     * Get the final result for this user.
     */
    public function finalResult()
    {
        return $this->hasOne(Result::class)->where('is_final', true);
    }

    /**
     * Check if user has completed the questionnaire.
     */
    public function hasCompletedQuestionnaire(): bool
    {
        return $this->finalResult()->exists();
    }

    /**
     * Get progress percentage for this user.
     */
    public function getProgressPercentage(): float
    {
        $totalQuestions = Question::active()->count();
        $answeredQuestions = $this->answers()->count();

        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($answeredQuestions / $totalQuestions) * 100, 1);
    }
}
