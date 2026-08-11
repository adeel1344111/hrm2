<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'dock_value',
        'bonus',
        'ref_bonus',
        'plan',
        'advance',
        'month',
    ];

    protected $casts = [
        'dock_value' => 'decimal:2',
        'bonus' => 'decimal:2',
        'ref_bonus' => 'decimal:2',
        'plan' => 'decimal:2',
        'advance' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
