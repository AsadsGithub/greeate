<?php

namespace Greeate\Greeate\Jobs;

use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\DeviceToken;
use Greeate\Greeate\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $adminId,
        public string $title,
        public string $body,
        public array $data = []
    ) {}

    public function handle(FirebaseService $firebase): void
    {
        if (! $firebase->isEnabled()) {
            return;
        }

        DeviceToken::where('admin_id', $this->adminId)->each(function (DeviceToken $device) use ($firebase) {
            $firebase->sendToDevice($device->token, $this->title, $this->body, $this->data);
        });
    }
}
