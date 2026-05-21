<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Events\NotificationSent;
use Greeate\Greeate\Jobs\SendPushNotification;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\GreeateNotification;
use Illuminate\Support\Facades\Notification as LaravelNotification;

class NotificationService
{
    public function __construct(
        protected FirebaseService $firebase,
        protected FirebaseTopicService $topics
    ) {}

    public function notifyAdmin(Admin $admin, string $type, string $title, ?string $body = null, array $data = [], array $channels = ['database']): GreeateNotification
    {
        $record = GreeateNotification::create([
            'notifiable_type' => Admin::class,
            'notifiable_id' => $admin->id,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'channel' => implode(',', $channels),
            'sent_at' => now(),
        ]);

        if (in_array('push', $channels, true) && $this->firebase->isEnabled()) {
            SendPushNotification::dispatch($admin->id, $title, $body ?? '', $data);
        }

        event(new NotificationSent($record));

        return $record;
    }

    public function unreadCountFor(Admin $admin): int
    {
        return GreeateNotification::where('notifiable_type', Admin::class)
            ->where('notifiable_id', $admin->id)
            ->whereNull('read_at')
            ->count();
    }
}
