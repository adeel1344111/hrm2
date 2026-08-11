<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutsourceFrontorSubmission extends Model
{
    protected $table = 'outsource_frontor_submissions';

    public $timestamps = false;

    protected $fillable = [
        'dialer_id',
        'name',
        'campaign',
        'phone',
        'state',
        'zip',
        'age',
        'comment',
        'company',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'age' => 'integer',
    ];
}
