<?php
namespace qwechat\open;

use qwechat\tool\XmlFormat;
use qwechat\base\ICallback;
use qwechat\Qwechat;

/**
 * 第三方开放平台接受解析回调类
 *
 * 1、首先需要定义一个类，继承该类。
 * 2、实现该类的抽象函数
 * 3、执行run函数，启用回调的调用
 *
 * 注：
 * 1、在调用该类的run()函数时，run函数会自动调用对应的函数（如：CTicket，抓取ticket的回调）进行回调操作
 * 2、在回调过程中如果有异常回自动调用CError函数，通过此抓取error异常，并记录相关日志等
 *
 *
 *
 * // 引用：
 * $qwechat = \Yii::$app->qwechat;
 * $cb = new WxOpenCallback($qwechat);
 * $cb->run($xml);
 * echo 'success';
 *
 * 
 * 派生类（回调操作类），用于接受回调的具体操作，可参考类：
 * qwechat\test\WxOpenCallback
 * 
 * @date 2018年3月20日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
abstract class OpenCallback implements ICallback
{

    /**
     * 微信组件
     */
    private $qwechat;

    /**
     * 初始化
     *
     * 初始化过程中，必须要将微信组件实例化后传递过来（因为有些配置是走配置文件的，所以在初始化时，必须要注册该函数）
     *
     * @param Qwechat $qwechat            
     */
    public function __construct(Qwechat $qwechat)
    {
        $this->qwechat = $qwechat;
    }

    /**
     * 开放平台的callback检测开启
     *
     *
     * {@inheritdoc}
     *
     * @see \qwechat\base\ICallback::run()
     * @return boolean 当操作成功返回true，失败返回false
     */
    public function run($xml = '')
    {
        try {
            // 抓取回调数据
            if (empty($xml))
                $xml = @file_get_contents('php://input');
            
            // 解析回调数据
            $body = XmlFormat::WxXml2Array($xml);
            $open = $this->qwechat->getOpen();
            $crypt = $open->getPrpcrypt();
            $res = $crypt->decrypt($body['Encrypt'], $body['AppId']);
            
            // 识别数据合法
            if (empty($res) || $res[0] != 0) {
                throw new \Exception(json_encode($res));
            }
            
            // 处理
            $data = XmlFormat::WxXml2Array($res[1]);
            switch ($data['InfoType']) {
                // 抓取微信的authcode
                case "component_verify_ticket":
                    $this->CTicket($data['ComponentVerifyTicket']);
                    break;
                default:
                    throw new \Exception("未找到解析内容");
                    break;
            }
            return true;
        } catch (\Exception $e) {
            $err = "OpenCallback::error:" . $e->getMessage();
            $this->error($err);
            return false;
        }
    }

    /**
     * ticket的回调
     * 微信每10分钟会进行一次ticket回调，当服务端接收到此数据后，对数据进行解析，解析成功后会自动调用该函数
     *
     * @param string $ticket            
     */
    abstract public function CTicket($ticket);
}