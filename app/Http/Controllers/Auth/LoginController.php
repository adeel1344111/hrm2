<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** Show the login page */
    public function login()
    {
        return view('auth.login');
    }

    /** Authenticate the user */
    public function authenticate(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|string',
            'password'    => 'required|string',
        ]);
        
        try {
            // Find user by employee_id
            $user = User::where('employee_id', $request->employee_id)->first();
            
            if ($user && $user->password === $request->password) {
                if ($user->status !== 'active') {
                    flash()->error('Error: Your account is inactive. Please contact the administrator. :)');
                    return redirect('login');
                }
                
                // Log the user in
                Auth::login($user);

                $todayDate = Carbon::now()->toDayDateTimeString();

                // Store user information in session
                Session::put([
                    'name'         => $user->name,
                    'user_id'      => $user->id, // Changed from user_id to id for consistency if id is the primary key
                    'join_date'    => $user->join_date,
                    'last_login'   => $todayDate,
                    'phone_number' => $user->contact_number, // Mapping contact_number
                    'location'     => '', // Location not in new schema, leaving empty or remove
                    'status'       => $user->status,
                    'role_name'    => $user->user_type, // Mapping user_type to role_name
                    'avatar'       => $user->profile_picture, // Mapping profile_picture to avatar
                    'position'     => $user->designation, // Mapping designation to position
                    'department'   => $user->department,
                ]);
                
                // Update last login
                $user->update(['last_login' => $todayDate]);

                flash()->success('Login successful :)');
                return redirect()->intended('home');
            } else {
                flash()->error('Error: Wrong employee ID or password :)');
                return redirect('login');
            }
        } catch (\Exception $e) {
            \Log::error($e);
            flash()->error('An error occurred during login :)');
            return redirect()->back();
        }
    }

    /** Show logout page */
    public function logoutPage()
    {
        return view('auth.logout');
    }

    /** Logout and forget session */
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        flash()->success('Logout successful :)');
        return redirect()->route('login');
    }
}