<?php

namespace DavidNineRoc\Payment\Facades;

use Illuminate\Support\Facades\Facade;

class PaysApi extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'paysapi';
    }
}
