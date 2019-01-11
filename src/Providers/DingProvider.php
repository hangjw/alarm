<?php


namespace Hangjw\Alarm\Providers;

use function GuzzleHttp\Promise\all;
use Hangjw\Alarm\ProviderInterface;

/**
 * Class DoubanProvider.
 *
 * @see http://developers.douban.com/wiki/?title=oauth2 [使用 OAuth 2.0 访问豆瓣 API]
 */
class DingProvider extends AbstractProvider implements ProviderInterface
{

    protected $path = 'https://oapi.dingtalk.com/robot/send';

    public function run()
    {
        $message = "## {$this->title}\n\n"
            . ($this->ip ? ("> 客户端ip: $this->ip \n\n") : '')
            . ($this->file ? ("> 文件: $this->file \n\n") : '')
            . ($this->line ? ("> 行号: $this->line \n\n") : '')
            . ($this->message ? ("> 内容: $this->message \n\n") : '')
            . ($this->remark ? ("> 备注: $this->remark") : '');
        $url = $this->path . '?access_token=' . $this->config['token'];
        $this->client->post($url, [
            'body' => json_encode($this->markdown($this->title, $message)),
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'timeout' => 3,
        ]);
        return true;
    }


    protected function markdown($title, $message)
    {

        $data = array(
            'msgtype'  => 'markdown',
            'markdown' => array(
                'title' => $title,
                'text'  => $message
            )
        );

        return $data;
    }
}

//        "{"msgtype":"markdown","markdown":{"title":"\u5f02\u5e38\u63d0\u9192","text":"## \u67d0\u67d0\u9879\u76ee\u5f02\u5e38\u63d0\u9192\n\n> clientIp: 127.0.0.1 \n\n> file:  \n\n> line: \u6d4b\u8bd5 \n\n> message: \u6d4b\u8bd5 \n\n> trace: \u6d4b\u8bd5"}}"

