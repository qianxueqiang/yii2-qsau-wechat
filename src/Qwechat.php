<?php
namespace qwechat;

use yii\base\Component;
use qwechat\open\Open;
use yii\base\ExitException;
use qwechat\card\Card;

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
            if (! isset($this->conf['open'])) {
                throw new ExitException(0, "Qwechat配置出错，缺少open项目", 0);
            }
            self::$open = new Open($this->conf['open']);
        }
        return self::$open;
    }
}