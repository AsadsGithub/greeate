<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Models\GreeateNotification;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    public function index(Request $request)
    {
        $notifications = GreeateNotification::where('notifiable_id', auth()->id())
            ->where('notifiable_type', get_class(auth()->user()))
            ->latest()
            ->paginate(20);

        return view('greeate::admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(int $id)
    {
        GreeateNotification::findOrFail($id)->markAsRead();
        return back();
    }

    public function markAllRead()
    {
        GreeateNotification::where('notifiable_id', auth()->id())->update(['read_at' => now()]);
        return back()->with('success', __('greeate::messages.all_marked_read'));
    }
}
