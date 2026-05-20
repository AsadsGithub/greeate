<?php

return [
    'enabled' => env('GREEATE_FIREBASE_ENABLED', false),

    'credentials' => env('FIREBASE_CREDENTIALS'),

    'project_id' => env('FIREBASE_PROJECT_ID', ''),
    'server_key' => env('FIREBASE_SERVER_KEY', ''),
    'sender_id' => env('FIREBASE_SENDER_ID', ''),
    'api_key' => env('FIREBASE_API_KEY', ''),
    'vapid_key' => env('FIREBASE_VAPID_KEY', ''),

    'default_topic' => env('FIREBASE_DEFAULT_TOPIC', 'greeate'),

    'database_url' => env('FIREBASE_DATABASE_URL'),
];
