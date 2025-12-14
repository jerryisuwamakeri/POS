<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'clock_in_at',
        'clock_out_at',
        'duration_minutes',
        'geo_lat',
        'geo_lng',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
        'duration_minutes' => 'integer',
        'geo_lat' => 'decimal:8',
        'geo_lng' => 'decimal:8',
    ];

    /**
     * Get the user that owns the shift.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the branch that owns the shift.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Check if shift is active (not clocked out).
     */
    public function isActive(): bool
    {
        return $this->clock_out_at === null;
    }

    /**
     * Calculate duration in minutes.
     */
    public function calculateDuration(): ?int
    {
        if (!$this->clock_out_at) {
            return null;
        }

        return $this->clock_in_at->diffInMinutes($this->clock_out_at);
    }

    /**
     * Get duration in minutes (stored or calculated).
     * This accessor ensures we always have a duration if clock_out_at exists.
     */
    public function getEffectiveDurationAttribute(): ?int
    {
        // First check if we have a stored value
        $stored = $this->attributes['duration_minutes'] ?? null;
        if ($stored !== null) {
            return (int) $stored;
        }

        // Otherwise, calculate on the fly if clock_out_at exists
        if ($this->clock_out_at) {
            return $this->clock_in_at->diffInMinutes($this->clock_out_at);
        }

        return null;
    }

    /**
     * Get formatted duration string.
     */
    public function getFormattedDurationAttribute(): string
    {
        $minutes = $this->effective_duration;
        
        if (!$minutes) {
            return '-';
        }

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$mins}m";
        }

        return "{$mins}m";
    }
}

