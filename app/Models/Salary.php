<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'temp_salary',
        'punctuality',
        'effective_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
        'basic_salary' => 'decimal:2',
        'temp_salary' => 'decimal:2',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    public function getFormattedBasicSalary()
    {
        return $this->basic_salary ? 'PKR ' . number_format($this->basic_salary, 2) : 'N/A';
    }

    public function getFormattedEffectiveDate()
    {
        return $this->effective_date ? $this->effective_date->format('M d, Y') : 'N/A';
    }

    public function getFormattedEndDate()
    {
        return $this->end_date ? $this->end_date->format('M d, Y') : 'N/A';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}