<?php

use Greeate\Greeate\Models\SiteSetting;
use Greeate\Greeate\Services\SiteSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores and retrieves site settings', function () {
    $service = app(SiteSettingsService::class);
    $service->set('site_name', 'Test Site', 'text', 'general');

    expect($service->get('site_name'))->toBe('Test Site');
});

it('caches site settings', function () {
    SiteSetting::create(['key' => 'test_key', 'value' => 'cached', 'type' => 'text', 'group' => 'general']);

    expect(SiteSetting::getValue('test_key'))->toBe('cached');
});
