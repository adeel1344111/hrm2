<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attendance_date',
        'status',
        'check_in',
        'check_out',
        'remarks',
        'marked_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /** Format TIME for <input type="time"> (HH:MM). */
    public function timeInputValue(?string $field): string
    {
        $raw = $this->getAttributes()[$field] ?? null;
        if ($raw === null || $raw === '') {
            return '';
        }
        try {
            return \Carbon\Carbon::parse($raw)->format('H:i');
        } catch (\Throwable $e) {
            if (preg_match('/^(\d{1,2}:\d{2})/', (string) $raw, $m)) {
                return strlen($m[1]) === 4 ? '0'.$m[1] : $m[1];
            }
            return '';
        }
    }

    public function getCheckInInputAttribute(): string
    {
        return $this->timeInputValue('check_in');
    }

    public function getCheckOutInputAttribute(): string
    {
        return $this->timeInputValue('check_out');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'P' => 'Present',
            'A' => 'Absent',
            'H' => 'Half Day',
            'U' => 'Unpaid',
            'NCNS' => 'NCNS',
            'HOLIDAY' => 'Holiday',
            default => 'Unknown'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'P' => 'text-green-600 bg-green-100 dark:text-green-400 dark:bg-green-500/20',
            'A' => 'text-red-600 bg-red-100 dark:text-red-400 dark:bg-red-500/20',
            'H' => 'text-yellow-600 bg-yellow-100 dark:text-yellow-400 dark:bg-yellow-500/20',
            'U' => 'text-orange-600 bg-orange-100 dark:text-orange-400 dark:bg-orange-500/20',
            'NCNS' => 'text-purple-600 bg-purple-100 dark:text-purple-400 dark:bg-purple-500/20',
            'HOLIDAY' => 'text-blue-600 bg-blue-100 dark:text-blue-400 dark:bg-blue-500/20',
            default => 'text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-gray-500/20'
        };
    }
}
