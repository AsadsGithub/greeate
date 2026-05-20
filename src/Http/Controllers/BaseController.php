<?php

namespace Greeate\Greeate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function withTransaction(callable $callback): mixed
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();

            return $result;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function successResponse(string $message, mixed $data = null, int $status = 200)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $status);
        }

        return back()->with('success', $message);
    }

    protected function errorResponse(string $message, int $status = 422)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $status);
        }

        return back()->with('error', $message);
    }
}
