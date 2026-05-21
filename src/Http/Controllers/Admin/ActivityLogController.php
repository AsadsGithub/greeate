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

        return $this->greeatePage('greeate/admin/crud/index', [
            'module' => 'activity-logs',
            'moduleConfig' => [
                'permission' => 'activity-logs.view',
                'readonly' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'description', 'label' => 'Description'],
                    ['key' => 'event', 'label' => 'Event'],
                    ['key' => 'created_at', 'label' => 'Date', 'type' => 'date'],
                ],
            ],
            'items' => $logs,
            'filters' => $request->only(['search']),
            'title' => __('greeate::nav.activity_logs'),
            'basePath' => '/'.trim(config('greeate.admin_prefix', 'dashboard'), '/').'/activity-logs',
            'routePrefix' => 'greeate.admin.activity-logs',
            'action' => 'index',
        ]);
    }

    public function destroy(int $id)
    {
        Activity::findOrFail($id)->delete();

        return back()->with('success', __('greeate::messages.deleted_successfully'));
    }
}
