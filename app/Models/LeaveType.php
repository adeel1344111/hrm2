<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_days',
        'requires_approval',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
        'max_days' => 'integer',
        'sort_order' => 'integer',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'leave_type', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
