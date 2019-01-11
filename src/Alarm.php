<?php

namespace Hangjw\Alarm;

use Illuminate\Support\Facades\Facade;
use Hangjw\Alarm\Providers\AbstractProvider;

/**
 * @package Hangjw\Alarm*
 * @method static AbstractProvider driver($driver) @return
 */

class Alarm extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'Hangjw\\Alarm\\AlarmManager';
    }
}
