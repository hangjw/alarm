<?php

namespace Hangjw\Alarm;

use Illuminate\Support\Facades\Facade;

class Alarm extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'Hangjw\\Alarm\\AlarmManager';
    }
}
