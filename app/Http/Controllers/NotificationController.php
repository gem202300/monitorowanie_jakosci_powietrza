<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = $request->user()->notifications()->latest();
        
        if ($type) {
            // filter by JSON payload field `type`
            $query->where('data->type', $type);
        }

        if ($dateFrom) {
            // filter from date (start of day)
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            // filter to date (end of day)
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $notifications = $query->get();

        $types = ['info', 'warning', 'critical', 'incident'];

        return view('notifications.index', compact('notifications', 'types', 'type', 'dateFrom', 'dateTo'));
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