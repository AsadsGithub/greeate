<?php

namespace Greeate\Greeate\Http\Controllers\Api\V1;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Http\Resources\NotificationResource;
use Greeate\Greeate\Models\GreeateNotification;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    public function index(Request $request)
    {
        $notifications = GreeateNotification::where('notifiable_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return NotificationResource::collection($notifications);
    }

    public function markAsRead(int $id)
    {
        GreeateNotification::findOrFail($id)->markAsRead();

        return response()->json(['success' => true]);
    }
}
