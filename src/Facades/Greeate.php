<?php

namespace Greeate\Greeate\Facades;

use Illuminate\Support\Facades\Facade;

class Greeate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'greeate';
    }
}
