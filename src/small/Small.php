<?php
namespace qwechat\small;

use qwechat\consts\SmallConsts;
use qwechat\tool\HttpClient;

class Small
{

    /**
     * 小程序的操作令牌
     *
     * @var string
     */
    private $access_token;

    /**
     * 初始化函数
     *
     * @param string $appid            
     * @param string $secret            
     * @throws \Exception
     */
    public function __construct($access_token)
    {
        if (empty($access_token)) {
            throw new \Exception("操作令牌不能未空！");
        }
        $this->access_token = $access_token;
    }

    /**
     * 获取小程序操作令牌
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }
}