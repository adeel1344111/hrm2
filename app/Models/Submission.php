<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    // Default table - will be overridden by setTable() when needed
    protected $table = 'csr_submissions';

    protected $fillable = [
        'employee_id',
        'employee_name',
        'team_lead_name',
        'campaign',
        'phone',
        'comment',
        'submitted_by',
        // CSR specific
        'state',
        'zip_code',
        'age',
        // Verification specific
        'jornaya_id',
        'did',
    ];

    // Dynamic table name based on submission type
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    // Get submission from any table by ID
    public static function findInAnyTable($id)
    {
        // Try CSR submissions
        $submission = (new static)->setTable('csr_submissions')->find($id);
        if ($submission) {
            $submission->submission_type = 'csr';
            return $submission;
        }

        // Try Verification submissions
        $submission = (new static)->setTable('verification_submissions')->find($id);
        if ($submission) {
            $submission->submission_type = 'verification';
            return $submission;
        }

        return null;
    }

    // Create submission in appropriate table based on user designation
    public static function createByDesignation($data, $user)
    {
        $model = new static;
        
        if ($user->isCsr()) {
            $model->setTable('csr_submissions');
        } elseif ($user->isVerificationOfficer()) {
            $model->setTable('verification_submissions');
        } else {
            // Default to CSR table for users without designation
            $model->setTable('csr_submissions');
        }

        $submission = $model->create($data);
        
        // Set submission_type after creation for identification (not stored in DB)
        if ($user->isCsr() || (!$user->isCsr() && !$user->isVerificationOfficer())) {
            $submission->submission_type = 'csr';
        } elseif ($user->isVerificationOfficer()) {
            $submission->submission_type = 'verification';
        }
        
        return $submission;
    }

    // Relationships
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    // Accessor to check if this CSR submission has a matching verification submission (Sale)
    public function getIsSaleAttribute()
    {
        // Only valid for CSR submissions
        // We can check if 'state' attribute exists, or check the table if we could, but table is dynamic.
        // The controller sets submission_type = 'csr' manually on the object.
        if (isset($this->submission_type) && $this->submission_type !== 'csr') {
            return false;
        }
        
        // If not explicitly 'csr', but has CSR fields like 'state', assume CSR.
        // Or better: Just check verification table for matching phone/day.
        
        // Clean phone number to match both formatted and unformatted numbers
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        $date = $this->created_at->format('Y-m-d');
        
        // We use DB query to check verification_submissions
        // We can't reuse the model easily because of the dynamic table, so we use DB facade or a new instance
        $count = \DB::table('verification_submissions')
            ->whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, "(", ""), ")", ""), "-", ""), " ", ""), ".", "") = ?', [$cleanPhone])
            ->whereDate('created_at', $date)
            ->count();
            
        return $count > 0;
    }
}
