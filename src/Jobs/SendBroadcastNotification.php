<?php

namespace Greeate\Greeate\Jobs;

use Greeate\Greeate\Models\Broadcast;
use Greeate\Greeate\Services\FirebaseTopicService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBroadcastNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $broadcastId) {}

    public function handle(FirebaseTopicService $topics): void
    {
        $broadcast = Broadcast::find($this->broadcastId);
        if (! $broadcast) {
            return;
        }

        $title = is_array($broadcast->title)
            ? ($broadcast->title[app()->getLocale()] ?? reset($broadcast->title))
            : $broadcast->title;
        $body = is_array($broadcast->body)
            ? ($broadcast->body[app()->getLocale()] ?? reset($broadcast->body ?? []))
            : ($broadcast->body ?? '');

        $topic = match ($broadcast->target_type) {
            'role' => $topics->topicForRole($broadcast->target_value),
            'admin' => $topics->topicForAdmin((int) $broadcast->target_value),
            default => 'all',
        };

        $topics->sendToTopic($topic, $title, $body);
    }
}
