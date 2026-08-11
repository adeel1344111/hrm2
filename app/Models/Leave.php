<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'admin_remarks',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type', 'name');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Pending' => 'text-yellow-600 bg-yellow-100 dark:text-yellow-400 dark:bg-yellow-500/20',
            'Approved' => 'text-green-600 bg-green-100 dark:text-green-400 dark:bg-green-500/20',
            'Rejected' => 'text-red-600 bg-red-100 dark:text-red-400 dark:bg-red-500/20',
            'Cancelled' => 'text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-slate-500/20',
            default => 'text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-slate-500/20'
        };
    }

    public function getLeaveTypeColorAttribute()
    {
        return match($this->leave_type) {
            'Sick' => 'text-red-600 bg-red-100 dark:text-red-400 dark:bg-red-500/20',
            'Vacation' => 'text-blue-600 bg-blue-100 dark:text-blue-400 dark:bg-blue-500/20',
            'Personal' => 'text-purple-600 bg-purple-100 dark:text-purple-400 dark:bg-purple-500/20',
            'Emergency' => 'text-orange-600 bg-orange-100 dark:text-orange-400 dark:bg-orange-500/20',
            'Maternity' => 'text-pink-600 bg-pink-100 dark:text-pink-400 dark:bg-pink-500/20',
            'Paternity' => 'text-indigo-600 bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-500/20',
            'Bereavement' => 'text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-slate-500/20',
            'Study' => 'text-teal-600 bg-teal-100 dark:text-teal-400 dark:bg-teal-500/20',
            'Compensatory' => 'text-cyan-600 bg-cyan-100 dark:text-cyan-400 dark:bg-cyan-500/20',
            'Sabbatical' => 'text-violet-600 bg-violet-100 dark:text-violet-400 dark:bg-violet-500/20',
            'Other' => 'text-slate-600 bg-slate-100 dark:text-slate-400 dark:bg-slate-500/20',
            default => 'text-gray-600 bg-gray-100 dark:text-gray-400 dark:bg-slate-500/20'
        };
    }

    public function calculateTotalDays()
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        return $start->diffInDays($end) + 1;
    }
}
