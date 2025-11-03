<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
        $request->user()->notifications()
            ->updateExistingPivot($id, ['read_at' => now()]);

        return redirect()->route('notifications.index');
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->notifications()
            ->wherePivotNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->route('notifications.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'user_ids' => 'required|array'
        ]);

        $notification = Notification::create([
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
        ]);

        $notification->users()->attach($data['user_ids']);

        return response()->json($notification, 201);
    }
}

