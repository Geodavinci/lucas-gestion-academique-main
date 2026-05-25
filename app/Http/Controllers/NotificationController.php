<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function unreadCount()
    {
        $count = auth()->user()->notifications()->unread()->count();
        return response()->json(['count' => $count]);
    }

    public function recent()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('view', $notification);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->notifications()
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function delete(Notification $notification)
    {
        $this->authorize('delete', $notification);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function deleteAll()
    {
        auth()->user()->notifications()->delete();

        return response()->json(['success' => true]);
    }
}
