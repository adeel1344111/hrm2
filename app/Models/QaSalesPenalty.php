<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QaSalesPenalty extends Model
{
    protected $fillable = [
        'user_id',
        'qms_evaluation_id',
        'qms_answer_id',
        'phone_number',
        'violation_category',
        'penalty_decision',
        'sales_deduction',
        'penalty_outcome',
        'occurred_at',
    ];

    protected $casts = [
        'sales_deduction' => 'decimal:2',
        'occurred_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
