# alarm
laravel下的代码异常报警

>目前支持方式只有钉钉机器人和企业微信机器人。
>在钉钉或企微群组中添加钉钉机器人，将token填入alarm配置中即可。
######
一、安装
```
composer require hangjw/alarm
```

二、获取配置并修改
```
php artisan vendor:publish
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

在Exceptions\Handler.php的report加入代码
```
public function report($request, Exception $exception)
{
    $ding = \Hangjw\Alarm\Alarm::driver('ding');
    $ding->setException($exception)->setRemark('测试备注')->run();
    parent::report($exception);
}
```