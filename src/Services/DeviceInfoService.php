<?php

namespace Greeate\Greeate\Services;

use Illuminate\Http\Request;

class DeviceInfoService
{
    public function capture(?Request $request = null): array
    {
        $request = $request ?? request();

        return [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
        ];
    }
}
