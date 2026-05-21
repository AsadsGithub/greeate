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
            'activities' => Activity::latest()->limit(10)->get()->map(fn (Activity $a) => [
                'id' => $a->id,
                'description' => $a->description,
                'created_at' => $a->created_at?->diffForHumans() ?? '',
                'event' => $a->event,
                'log_name' => $a->log_name,
            ]),
            'recent_contacts' => ContactMessage::latest()->limit(5)->get()->map(fn (ContactMessage $c) => [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'created_at' => $c->created_at?->diffForHumans() ?? '',
            ]),
        ];

        return $this->greeatePage('greeate/admin/dashboard', compact('stats'));
    }
}
