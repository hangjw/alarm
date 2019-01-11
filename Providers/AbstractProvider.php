<?php


namespace Hangjw\Alarm\Providers;

use Hangjw\Alarm\ProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractProvider.
 */
abstract class AbstractProvider implements ProviderInterface
{

    protected $title = '异常通知';

    protected $ip;

    protected $file;

    protected $message;

    protected $line;

    protected $code;

    protected $remark;

    protected $time;

    protected $config;

    protected $request;

    public function __construct(Request $request, $config = [])
    {
        $this->request = $request;
        $this->config = $config;
        $this->setTime(date('Y-m-d H:i:s'));
    }


    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setRemark($remark)
    {
        $this->remark = $remark;
        return $this;
    }

    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


    public function setLine($line)
    {
        $this->line = $line;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setException(\Exception $e)
    {
        $this->setCode($e->getCode());
        $this->setFile($e->getFile());
        $this->setLine($e->getLine());
        $this->setMessage($e->getMessage());
        return $this;
    }
}
