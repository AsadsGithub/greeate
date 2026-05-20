<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\GreeateNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    public function isEnabled(): bool
    {
        return (bool) config('firebase.enabled', false)
            && ! empty(config('firebase.server_key'));
    }

    public function sendToDevice(string $token, string $title, string $body, array $data = []): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key='.config('firebase.server_key'),
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Firebase push failed', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key='.config('firebase.server_key'),
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => '/topics/'.$topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Firebase topic push failed', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public function storeNotification(Admin $admin, string $type, string $title, ?string $body = null, array $data = []): GreeateNotification
    {
        return GreeateNotification::create([
            'notifiable_type' => Admin::class,
            'notifiable_id' => $admin->id,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'channel' => 'firebase',
            'sent_at' => now(),
        ]);
    }
}
