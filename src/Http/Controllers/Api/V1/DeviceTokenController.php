<?php

namespace Greeate\Greeate\Http\Controllers\Api\V1;

use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\FirebaseTopicService;
use Illuminate\Http\Request;

class DeviceTokenController extends BaseController
{
    public function __construct(protected FirebaseTopicService $topics) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'platform' => 'nullable|in:web,android,ios',
        ]);

        $device = $this->topics->subscribeAdmin(
            $request->user(),
            $validated['token'],
            $validated['platform'] ?? 'web'
        );

        return response()->json(['success' => true, 'id' => $device->id]);
    }
}
