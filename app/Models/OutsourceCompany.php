<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutsourceCompany extends Model
{
    protected $table = 'outsource_companies';

    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'company_pass',
        'company_email',
        'admin_pass',
        'admin_name',
    ];

    public static function findByFormCredentials(string $company, string $pass): ?self
    {
        return static::query()
            ->whereRaw('LOWER(TRIM(company_name)) = ?', [strtolower(trim($company))])
            ->where('company_pass', $pass)
            ->first();
    }

    public static function findByPortalLogin(string $email, string $password): ?self
    {
        return static::query()
            ->where('company_email', $email)
            ->where('admin_pass', $password)
            ->first();
    }
}
