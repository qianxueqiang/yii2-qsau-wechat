<?php
namespace qwechat\card;

use qwechat\consts\MediaConsts;
use qwechat\tool\HttpClient;

/**
 * 微信卡券功能
 *
 * @date 2018年3月7日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class Media
{

    /**
     * 授权操作的access_token
     *
     * @var string
     */
    private $access_token;

    /**
     * 初始化函数
     *
     * @param string $access_token            
     */
    public function __construct($access_token)
    {
        if (empty($access_token)) {
            throw new \Exception("access_token不能未空！");
        }
        $this->access_token = $access_token;
    }

    /**
     * 获取操作令牌
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * 上传图片并返回数据
     *
     * @param string $buffer            
     * @return string
     */
    public function uploadImg($buffer)
    {
        $access_token = $this->getAccessToken();
        $url = MediaConsts::API_MEDIA_UPLOAD . "?access_token=" . $access_token;
        $postdata = [
            'buffer' => $buffer,
            'access_token' => $access_token
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }
}