<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends BaseController
{
    public function index(Request $request)
    {
        $logs = Activity::latest()->paginate(20);
        return view('greeate::admin.activity-logs.index', compact('logs'));
    }
}
