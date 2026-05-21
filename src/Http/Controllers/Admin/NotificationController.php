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

        return $this->greeatePage('greeate/admin/crud/index', [
            'module' => 'notifications',
            'moduleConfig' => [
                'permission' => 'notifications.view',
                'readonly' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'type', 'label' => 'Type'],
                    ['key' => 'read_at', 'label' => 'Read', 'type' => 'date'],
                    ['key' => 'created_at', 'label' => 'Created', 'type' => 'date'],
                ],
            ],
            'items' => $notifications,
            'filters' => [],
            'title' => __('greeate::nav.notifications'),
            'basePath' => '/'.trim(config('greeate.admin_prefix', 'dashboard'), '/').'/notifications',
            'routePrefix' => 'greeate.admin.notifications',
            'action' => 'index',
        ]);
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
