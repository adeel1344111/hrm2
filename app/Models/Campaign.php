<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'campaign', 'name');
    }

    // Accessor for status color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
            'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
        };
    }

    // Accessor for status label
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
