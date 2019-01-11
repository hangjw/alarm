# alarm
laravel下的代码异常报警

######
一、安装
```
composer require hangjw/alarm
```

二、获取配置并修改
```
php artisan vendor:publish --provider="Hangjw/Alarm/AlarmServiceProvider"
```

三、使用
```
try {
    dd($a);
} catch (\Exception $e) {
    dd($ding->setException($e)->setIp('127.0.0.1')->setRemark('备注')->run());
}
```