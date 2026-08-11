<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QaEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'qms_evaluation_id',
        'evaluation_uid',
        'agent_name',
        'team_leader',
        'phone_number',
        'did',
        'campaign_name',
        'final_score',
        'is_pass',
        'is_critical_failure',
        'sales_deduction_total',
        'mistakes_count',
        'call_outcome',
        'qa_comments',
        'call_date',
        'submitted_at',
    ];

    protected $casts = [
        'final_score' => 'decimal:2',
        'sales_deduction_total' => 'decimal:2',
        'is_pass' => 'boolean',
        'is_critical_failure' => 'boolean',
        'call_date' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Mask phone for agent view — last 4 digits only. */
    public function maskedPhone(): string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone_number);
        if ($digits === '') {
            return '—';
        }
        $last = substr($digits, -4);

        return '******' . $last;
    }
}
