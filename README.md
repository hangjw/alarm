# alarm
laravel下的代码异常报警

>目前支持方式只有钉钉机器人。在pc钉钉群组中添加钉钉机器人，将token填入alarm配置中即可。
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


四、在laravel中配置

在Exceptions\Handler.php的render加入代码
```
$ding = Alarm::driver('ding');
try {
    dd($a);
} catch (\Exception $e) {
    dd($ding->setException($e)->setIp('127.0.0.1')->setRemark('备注')->run());
}
```