<?php
namespace qwechat;

use yii\base\Component;
use qwechat\open\Open;
use qwechat\card\Card;
use qwechat\tool\HttpClient;
use qwechat\small\Small;
use qwechat\card\Media;
use qwechat\consts\SmallConsts;

/**
 * Qwechat微信SDK插件
 *
 * @property \qwechat\tool\HttpClient $http 一个http客户端，curl工具
 * @property \qwechat\open\Open $open 微信第三方开放平台
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
     * @var array
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
    private static $cards;

    /**
     * 小程序对象
     *
     * @var array
     */
    private static $smalls = [];

    /**
     * 获取资源
     *
     * @var array
     */
    private static $medias = [];

    /**
     * 设置微信配置
     *
     * @param string $conf            
     */
    public function setConf($conf)
    {
        $this->conf = $conf;
    }

    /**
     * 小程序login
     *
     * @param string $appid            
     * @param string $secret            
     * @param string $js_code            
     * @param string $grant_type            
     * @return mixed|string
     */
    public function smallLogin($appid, $secret, $js_code, $grant_type = 'authorization_code')
    {
        $url = SmallConsts::API_SMALL_USER_LOGIN. '?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $js_code . '&grant_type=' . $grant_type;
        $data = $this->getHttp()->get($url);
        return $data;
    }

    /**
     * 获取卡券对象
     *
     * @param string $access_token
     *            小程序的access_token
     * @throws Exception
     * @return \qwechat\card\Card|boolean
     */
    public function getCard($access_token)
    {
        try {
            if (empty($access_token)) {
                throw new \Exception("access_token不能未空！");
            }
            if (! isset(self::$cards[$access_token]) || empty(self::$cards[$access_token])) {
                self::$cards[$access_token] = new Card($access_token);
            }
            return self::$cards[$access_token];
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    /**
     * 获取小程序
     *
     * @param string $access_token
     *            小程序的access_token
     * @throws Exception
     * @return \qwechat\small\Small|boolean
     */
    public function getSmall($access_token)
    {
        try {
            if (empty($access_token)) {
                throw new \Exception('access_token不能未空！');
            }
            if (! isset(self::$smalls[$access_token]) || empty(self::$smalls[$access_token])) {
                self::$smalls[$access_token] = new Small($access_token);
            }
            return self::$smalls[$access_token];
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    /**
     * 获取开放平台对象
     *
     * @throws \Exception
     * @return \qwechat\open\Open
     */
    public function getOpen()
    {
        if (! empty(self::$open))
            return self::$open;
        
        if (isset($this->conf['open'])) {
            self::$open = new Open($this->conf['open']);
            return self::$open;
        }
        throw new \Exception("Qwechat配置出错，缺少open项目");
    }

    /**
     * 获取媒体资源类
     *
     * @param string $access_token
     *            操作令牌
     * @throws \Exception
     * @return \qwechat\media\Media|boolean
     */
    public function getMedia($access_token)
    {
        try {
            if (empty($access_token)) {
                throw new \Exception('access_token不能未空！');
            }
            if (! isset(self::$medias[$access_token]) || empty(self::$medias[$access_token])) {
                self::$medias[$access_token] = new Media($access_token);
            }
            return self::$medias[$access_token];
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
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