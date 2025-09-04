<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = [
        'user_id',
        'total_points',
        'max_points',
        'percentage',
        'status',
        'category_scores',
        'completed_at',
        'is_final'
    ];

    protected $casts = [
        'total_points' => 'integer',
        'max_points' => 'integer',
        'percentage' => 'decimal:2',
        'category_scores' => 'array',
        'completed_at' => 'datetime',
        'is_final' => 'boolean'
    ];

    /**
     * Get the user that owns this result.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate status based on total points.
     */
    public static function calculateStatus(int $points): string
    {
        if ($points >= 91) {
            return 'gold';
        } elseif ($points >= 71) {
            return 'silver';
        } else {
            return 'bronze';
        }
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'gold' => 'yellow',
            'silver' => 'gray',
            'bronze' => 'amber',
            default => 'gray'
        };
    }

    /**
     * Get status display name.
     */
    public function getStatusName(): string
    {
        return match($this->status) {
            'gold' => 'Gold',
            'silver' => 'Silber',
            'bronze' => 'Bronze',
            default => 'Unbekannt'
        };
    }

    /**
     * Scope for final results.
     */
    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }

    /**
     * Scope for results by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
