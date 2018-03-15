<?php
namespace qwechat;

use yii\base\Component;
use qwechat\open\Open;
use yii\base\ExitException;
use qwechat\card\Card;
use qwechat\tool\HttpClient;

/**
 * Qwechat微信SDK插件
 *
 * @property \qwechat\tool\HttpClient $http 一个http客户端，curl工具
 * @property \qwechat\open\Open $open 微信第三方开放平台
 * @property \qwechat\card\Card $card 微信卡券类
 * @property \qwechat\media\Media $media 媒体资源类
 *          
 *          
 *           @date 2018年3月8日
 *          
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class Qwechat extends Component
{

    /**
     * 微信配置
     *
     * @var unknown
     */
    private $conf;

    /**
     * 公众平台对象
     *
     * @var \qwechat\open\Open
     */
    private static $open;

    /**
     * 微信卡券对象
     *
     * @var \qwechat\card\Card
     */
    private static $card;

    /**
     * 设置微信配置
     *
     * @param unknown $conf            
     */
    public function setConf($conf)
    {
        $this->conf = $conf;
    }

    /**
     * 获取卡券对象
     *
     * @return \qwechat\card\Card
     */
    public function getCard()
    {
        if (empty(self::$card)) {
            self::$card = new Card();
        }
        return self::$card;
    }

    /**
     * 获取开放平台对象
     *
     * @throws ExitException
     * @return \qwechat\open\Open
     */
    public function getOpen()
    {
        if (empty(self::$open)) {
            echo 11;
            if (! isset($this->conf['open'])) {
                throw new ExitException(0, "Qwechat配置出错，缺少open项目", 0);
            }
            self::$open = new Open($this->conf['open']);
        }
        return self::$open;
    }

    /**
     * 获取http客户端
     *
     * @return \qwechat\tool\HttpClient
     */
    public function getHttp()
    {
        return new HttpClient();
    }
}