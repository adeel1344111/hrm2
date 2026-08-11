<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    // Methods
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isUnread()
    {
        return is_null($this->read_at);
    }

    // Get icon based on notification type
    public function getIconAttribute()
    {
        return match($this->type) {
            'submission' => 'file-text',
            'leave_request' => 'calendar',
            'leave_approved' => 'check-circle',
            'leave_rejected' => 'x-circle',
            'attendance' => 'clock',
            default => 'bell',
        };
    }

    // Get color based on notification type
    public function getColorAttribute()
    {
        return match($this->type) {
            'submission' => 'blue',
            'leave_request' => 'yellow',
            'leave_approved' => 'green',
            'leave_rejected' => 'red',
            'attendance' => 'purple',
            default => 'gray',
        };
    }
}
