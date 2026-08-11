<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = User::teamLeadRole()->where('status', 'active');

        if ($user->isFloorManager()) {
            $query->where('floor_manager_id', $user->id);
        } elseif ($user->isTeamLead()) {
            $query->where('id', $user->id);
        }

        $teamLeads = $query->with(['agents' => function($query) {
                $query->where('users.status', 'active')
                      ->leftJoin('salaries', function($join) {
                          $join->on('users.id', '=', 'salaries.employee_id')
                               ->where('salaries.status', 'active');
                      })
                      ->select('users.*', 'salaries.basic_salary');
            }])
            ->get();

        return view('teams.index', compact('teamLeads'));
    }
}
