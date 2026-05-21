<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Jobs\SendBroadcastNotification;
use Greeate\Greeate\Models\Broadcast;

class BroadcastService
{
    public function send(Broadcast $broadcast): void
    {
        SendBroadcastNotification::dispatch($broadcast->id);
        $broadcast->update(['status' => 'sent', 'sent_at' => now()]);
    }

    public function processScheduled(): int
    {
        $count = 0;
        Broadcast::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->each(function (Broadcast $broadcast) use (&$count) {
                $this->send($broadcast);
                $count++;
            });

        return $count;
    }
}
