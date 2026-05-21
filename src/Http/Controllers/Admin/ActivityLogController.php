<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends BaseController
{
    public function index(Request $request)
    {
        $query = Activity::query()->latest();

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        $logs = $query->paginate($request->integer('per_page', 20));

        return view('greeate::admin.activity-logs.index', compact('logs'));
    }

    public function destroy(int $id)
    {
        Activity::findOrFail($id)->delete();

        return back()->with('success', __('greeate::messages.deleted_successfully'));
    }
}
