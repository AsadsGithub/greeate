<?php

namespace Greeate\Greeate\Http\Controllers\Auth;

use Greeate\Greeate\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    public function index()
    {
        return view('greeate::auth.resetpassword');
    }
}
