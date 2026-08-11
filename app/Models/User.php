<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'password',
        'profile_picture',
        'user_type',
        'employee_id',
        'contact_number',
        'emergency_contact',
        'cnic',
        'appointment_date',
        'left_date',
        'referred_by',
        'department',
        'join_date',
        'status',
        'floor_manager_id',
        'team_lead_id',
        'designation',
        'dob',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'join_date' => 'date',
            'appointment_date' => 'date',
            'left_date' => 'date',
            'dob' => 'date',
            'password' => 'string',
        ];
    }

    // Hierarchy relationships
    public function floorManager()
    {
        return $this->belongsTo(User::class, 'floor_manager_id');
    }

    public function teamLead()
    {
        return $this->belongsTo(User::class, 'team_lead_id');
    }

    public function teamLeads()
    {
        return $this->hasMany(User::class, 'floor_manager_id')
            ->where(function ($q) {
                $q->where('user_type', 'team_lead')
                    ->orWhere(function ($q2) {
                        $q2->where('user_type', 'management')->where('designation', 'Team Lead');
                    });
            });
    }

    public function agents()
    {
        return $this->hasMany(User::class, 'team_lead_id')->where('user_type', 'agent');
    }

    public function allAgents()
    {
        // Get all agents under this floor manager through team leads
        return User::whereIn('team_lead_id', $this->teamLeads()->pluck('id'))->where('user_type', 'agent');
    }

    public function submissions()
    {
        // This will return submissions from the default 'submissions' table
        // For all submissions across tables, use a custom query
        return $this->hasMany(Submission::class, 'submitted_by');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'employee_id');
    }

    public function currentSalary()
    {
        return $this->hasOne(Salary::class, 'employee_id')->where('status', 'active')->latest('effective_date');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isFloorManager()
    {
        // Access role only — management staff use isManagement() (self-service)
        return $this->user_type === 'floor_manager';
    }

    public function isTeamLead()
    {
        // Access role only — management staff use isManagement() (self-service)
        return $this->user_type === 'team_lead';
    }

    public function isAgent()
    {
        return $this->user_type === 'agent';
    }

    public function isManagement()
    {
        return $this->user_type === 'management';
    }

    /** Admin org-wide views (not management self-service) */
    public function hasOrgWideAccess()
    {
        return $this->isAdmin();
    }

    /** Who may approve leave requests */
    public function canApproveLeaves()
    {
        return $this->isAdmin() || $this->isFloorManager();
    }

    /** Floor managers by type or management + Floor Manager designation */
    public function scopeFloorManagerRole($query)
    {
        return $query->where(function ($q) {
            $q->where('user_type', 'floor_manager')
                ->orWhere(function ($q2) {
                    $q2->where('user_type', 'management')->where('designation', 'Floor Manager');
                });
        });
    }

    /** Team leads by type or management + Team Lead designation */
    public function scopeTeamLeadRole($query)
    {
        return $query->where(function ($q) {
            $q->where('user_type', 'team_lead')
                ->orWhere(function ($q2) {
                    $q2->where('user_type', 'management')->where('designation', 'Team Lead');
                });
        });
    }

    public function isCsr()
    {
        return $this->designation === 'CSR';
    }

    public function isVerificationOfficer()
    {
        return $this->designation === 'Verification Officer';
    }

    public function getHierarchyLevel()
    {
        return match($this->user_type) {
            'admin' => 1,
            'floor_manager' => 2,
            'management' => 2,
            'team_lead' => 3,
            'agent' => 4,
            default => 4
        };
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function markedAttendances()
    {
        return $this->hasMany(Attendance::class, 'marked_by');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function approvedLeaves()
    {
        return $this->hasMany(Leave::class, 'approved_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->whereNull('read_at')->orderBy('created_at', 'desc');
    }
}
