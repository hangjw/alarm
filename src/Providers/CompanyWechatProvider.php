<?php

namespace Hangjw\Alarm\Providers;

use App\Exceptions\BugNoticeException;
use Exception;
use Hangjw\Alarm\ProviderInterface;

/**
 * Class CompanyWechatProvider.
 *
 */
class CompanyWechatProvider extends AbstractProvider implements ProviderInterface
{
    protected $path = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send';

    /**
     * @return bool
     * @throws BugNoticeException
     */
    public function run()
    {
        $message = "## {$this->title}\n\n"
            . ($this->ip ? ("> 客户端ip: $this->ip \n\n") : '')
            . ($this->file ? ("> 文件: $this->file \n\n") : '')
            . ($this->line ? ("> 行号: $this->line \n\n") : '')
            . ($this->message ? ("> 内容: $this->message \n\n") : '')
            . ($this->remark ? ("> 备注: $this->remark") : '');
        $url = $this->path . '?key=' . $this->config['token'];
        try {
            $this->client->post($url, [
                'body'    => json_encode($this->markdown($this->title, $message)),
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 3,
            ]);
        } catch (Exception $exception) {
            throw new BugNoticeException($exception->getMessage(), $exception->getCode());
        }

        return true;
    }

    protected function markdown($title, $message)
    {
        $data = [
            'msgtype'  => 'markdown',
            'markdown' => [
                'content' => $title . "\n" . $message
            ]
        ];

        return $data;
    }
}
