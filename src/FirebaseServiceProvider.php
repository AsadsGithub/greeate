<?php

namespace Greeate\Greeate;

use Greeate\Greeate\Services\SiteSettingsService;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Messaging::class, function ($app) {
            $credentials = config('firebase.credentials');

            if (empty($credentials) && $app->bound(SiteSettingsService::class)) {
                $json = $app->make(SiteSettingsService::class)->get('firebase_credentials_json');
                if (is_string($json) && $json !== '') {
                    $credentials = json_decode($json, true) ?: $json;
                }
            }

            if (empty($credentials)) {
                return null;
            }

            $factory = is_array($credentials)
                ? (new Factory)->withServiceAccount($credentials)
                : (new Factory)->withServiceAccount($credentials);

            return $factory->createMessaging();
        });
    }
}
