<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
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
        'preferences'
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data_consent' => 'boolean',
            'consent_given_at' => 'datetime',
            'preferences' => 'array'
        ];
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function latestResult()
    {
        return $this->hasOne(Result::class)->latestOfMany();
    }

    public function finalResult()
    {
        return $this->hasOne(Result::class)->where('is_final', true);
    }

    public function hasCompletedQuestionnaire(): bool
    {
        return $this->finalResult()->exists();
    }

    public function getProgressPercentage(): float
    {
        $totalQuestions = Question::active()->count();
        $answeredQuestions = $this->answers()->distinct('question_id')->count();

        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($answeredQuestions / $totalQuestions) * 100, 1);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
