<?php

namespace Greeate\Greeate\Http\Controllers\Frontend;

use Greeate\Greeate\Http\Controllers\BaseController;

class ComingSoonController extends BaseController
{
    public function index()
    {
        return view('greeate::frontend.comingsoon');
    }
}
