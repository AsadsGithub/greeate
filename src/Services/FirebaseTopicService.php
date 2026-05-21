<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\DeviceToken;

class FirebaseTopicService
{
    public function __construct(protected FirebaseService $firebase) {}

    public function topicForRole(string $role): string
    {
        return 'role_'.str_replace('-', '_', $role);
    }

    public function topicForAdmin(int $adminId): string
    {
        return 'admin_'.$adminId;
    }

    public function subscribeAdmin(Admin $admin, string $token, string $platform = 'web'): DeviceToken
    {
        $topics = ['all', $this->topicForAdmin($admin->id)];
        foreach ($admin->getRoleNames() as $role) {
            $topics[] = $this->topicForRole($role);
        }

        return DeviceToken::updateOrCreate(
            ['admin_id' => $admin->id, 'token' => $token],
            ['platform' => $platform, 'topics' => array_unique($topics)]
        );
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        return $this->firebase->sendToTopic($topic, $title, $body, $data);
    }
}
