<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\SiteSettingsService;
use Illuminate\Http\Request;

class SiteSettingsController extends BaseController
{
    public function __construct(protected SiteSettingsService $settings) {}

    public function index(string $group = 'general')
    {
        return $this->greeatePage('greeate/admin/settings/index', [
            'group' => $group,
            'settings' => $this->settings->getByGroup($group),
        ]);
    }

    public function update(Request $request, string $group)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $this->settings->set($key, $value, is_array($value) ? 'json' : 'text', $group);
        }
        $this->settings->flush();

        return back()->with('success', __('greeate::messages.settings_saved'));
    }
}
