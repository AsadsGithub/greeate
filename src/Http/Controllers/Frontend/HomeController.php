<?php

namespace Greeate\Greeate\Http\Controllers\Frontend;

use Greeate\Greeate\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->greeatePage('greeate/frontend/home');
    }
}
