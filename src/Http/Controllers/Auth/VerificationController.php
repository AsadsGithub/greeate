<?php

namespace Greeate\Greeate\Http\Controllers\Auth;

use Greeate\Greeate\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{
    public function index()
    {
        return view('greeate::auth.verification');
    }
}
