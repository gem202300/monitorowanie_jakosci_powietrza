<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function unread(Request $request)
    {
        return $request->user()->unreadNotifications()->latest()->get();
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->route('notifications.index');
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index');
    }
    public function show($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);

    if(is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    return view('notifications.show', compact('notification'));
}

public function destroy(Request $request, $id)
{
    $notification = $request->user()->notifications()->findOrFail($id);
    $notification->delete();

    return redirect()->route('notifications.index')->with('success', 'Notification deleted.');
}


}