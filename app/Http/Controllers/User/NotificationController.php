<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        $notifications = Notification::where('user_id', Auth::id())->latest()->paginate(20);
        return view('user.notifications', compact('notifications'));
    }

    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
        $count = Notification::where('user_id', Auth::id())->where('is_read', false)->count();
        return response()->json(['notifications' => $notifications, 'count' => $count]);
    }

    public function markRead($id)
    {
        Notification::where('id', $id)->where('user_id', Auth::id())->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}