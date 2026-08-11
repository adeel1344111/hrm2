<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get user's notifications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);
        
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        // If this is not an AJAX request, redirect to dashboard
        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/home');
        }
        
        $user = Auth::user();
        return Notification::where('user_id', $user->id)
            ->unread()
            ->count();
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        Notification::where('user_id', $user->id)
            ->unread()
            ->update(['read_at' => now()]);
        
        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();
        
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }
}
