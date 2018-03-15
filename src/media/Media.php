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
     * @var unknown
     */
    private $access_token;

    /**
     * 初始化函数
     *
     * @param unknown $access_token            
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * 上传图片并返回数据
     * 
     * @param unknown $buffer
     * @return mixed|\qwechat\tool\unknown
     */
    public function uploadImg($buffer){
        $url = MediaConsts::API_MEDIA_UPLOAD . "?component_access_token=" . $access_token;
        $postdata = [
            'buffer' => $buffer,
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }
}