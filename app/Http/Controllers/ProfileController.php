<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // Delete old profile picture if exists
        if ($user->profile_picture && file_exists(public_path('assets/images/' . $user->profile_picture))) {
            @unlink(public_path('assets/images/' . $user->profile_picture));
        }

        if ($request->hasFile('profile_picture')) {
            // Store new profile picture directly in public_html/assets/images
            $image = $request->file('profile_picture');
            $filename = 'profile-pictures/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('assets/images/profile-pictures');
            if (!file_exists($destinationPath)) {
                @mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, basename($filename));
            
            $user->update(['profile_picture' => $filename]);
            
            return redirect()->route('profile.show')->with('success', 'Profile picture updated successfully.');
        }

        return redirect()->route('profile.show')->with('error', 'No image was uploaded.');
    }

    /**
     * Remove the user's profile picture.
     */
    public function removeProfilePicture()
    {
        $user = Auth::user();
        
        if ($user->profile_picture && file_exists(public_path('assets/images/' . $user->profile_picture))) {
            @unlink(public_path('assets/images/' . $user->profile_picture));
            $user->update(['profile_picture' => null]);
            
            return redirect()->route('profile.show')->with('success', 'Profile picture removed successfully.');
        }

        return redirect()->route('profile.show')->with('error', 'No profile picture to remove.');
    }
}
