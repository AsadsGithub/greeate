<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Models\ContactMessage;
use Greeate\Greeate\Models\GreeateNotification;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends BaseController
{
    public function index()
    {
        $stats = [
            'admins' => Admin::count(),
            'contacts' => ContactMessage::where('status', 'new')->count(),
            'notifications' => GreeateNotification::whereNull('read_at')->count(),
            'activities' => Activity::latest()->limit(10)->get(),
            'recent_contacts' => ContactMessage::latest()->limit(5)->get(),
        ];

        return $this->greeatePage('greeate/admin/dashboard', compact('stats'));
    }
}
