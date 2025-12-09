<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotificationAlert;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotificationAlert::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $n = UserNotificationAlert::where('id', $id)->where('user_id', Auth::id())->first();
        if ($n) {
            $n->is_read = 1;
            $n->save();
        }
        return back();
    }





    public function delete($id)
{
   $notification = UserNotificationAlert::where('id', $id)
    ->where('user_id', auth()->id())
    ->first();

    if (!$notification) {
        return response()->json(['message' => 'Notification not found'], 404);
    }

    $notification->delete();

    return response()->json(['message' => 'Notification deleted successfully']);
}




}



?>