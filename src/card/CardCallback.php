<?php
namespace qwechat\card;

use qwechat\base\ICallback;
use qwechat\tool\XmlFormat;
use qwechat\Qwechat;
use qwechat\card\orm\CAuditSuccess;
use qwechat\card\orm\CAuditRefuse;
use qwechat\card\orm\CUserGetCard;
use qwechat\card\orm\CUserGiftingCard;
use qwechat\card\orm\CUserDelCard;
use qwechat\card\orm\CUserConsumeCard;
use qwechat\card\orm\CUserPayFormPayCell;
use qwechat\card\orm\CUserViewCard;
use qwechat\card\orm\CUserEnterSessionFormCard;
use qwechat\card\orm\CUpdateMemberCard;
use qwechat\card\orm\CCardSkuRemind;
use qwechat\card\orm\CCardPayOrder;
use qwechat\card\orm\CSubmitMembercardUserInfo;

/**
 * 卡券消息推送接受解析类
 *
 * 接口文档参考（公众号-微信卡券-卡券事件推送）：
 * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025274
 *
 * 入口需要实例化并且执行run函数
 * $qwechat = \Yii::$app->qwechat;
 * $wxc = new WxCardCallback($qwechat);
 * $wxc->run($xml);
 *
 * 派生类（回调操作类），用于接受回调的具体操作，可参考类：
 * qwechat\test\WxCardCallback
 *
 * @date 2018年3月15日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
abstract class CardCallback implements ICallback
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
     * 卡券回调数据接受入口，用于接受卡券的所有回调
     * 回调解析成功，会调用对应的函数，将回调过程中解析的数据透传给处理函数
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
            $xml = empty($xml) ? @file_get_contents('php://input') : $xml;
            if (empty($xml))
                throw new \Exception("参数异常，未接收到postdata！");
            
            // 解析回调数据
            $body = XmlFormat::WxXml2Array($xml);
            $open = $this->qwechat->getOpen();
            $crypt = $open->getPrpcrypt();
            $res = $crypt->decrypt($body['Encrypt']);
            
            // 数据解密异常
            if (empty($res))
                throw new \Exception("数据解析异常！");
            
            // 识别数据合法
            if ($res[0] != 0)
                throw new \Exception("数据格式不合法：" . json_encode($res));
            
            // 数据转换
            $data = XmlFormat::WxXml2Array($res[1]);
            $event = isset($data['Event']) ? $data['Event'] : '';
            $msgType = isset($data['MsgType']) ? $data['MsgType'] : '';
            if ($msgType != 'event' || empty($event)) {
                throw new \Exception("解析xml格式异常!xml=" . $res);
            }
            unset($data['Event']);
            unset($data['MsgType']);
            
            $result = false;
            // 具体处理
            switch ($event) {
                case "card_pass_check": // 卡券审核通过
                    $result = $this->cardAuditSuccess(new CAuditSuccess($data));
                    break;
                case 'card_not_pass_check': // 卡券审核不通过
                    $result = $this->cardAuditRefuse(new CAuditRefuse($data));
                    break;
                case 'user_get_card': // 用户领取卡券
                    $result = $this->userGetCard(new CUserGetCard($data));
                case 'user_gifting_card': // 转赠事件推送
                    $result = $this->userGiftingCard(new CUserGiftingCard($data));
                case 'user_del_card': // 用户删除
                    $result = $this->userDelCard(new CUserDelCard($data));
                case 'user_consume_card': // 卡券核销事件推送
                    $result = $this->userConsumeCard(new CUserConsumeCard($data));
                case 'user_pay_from_pay_cell': // 用户买单
                    $result = $this->userPayFromPayCell(new CUserPayFormPayCell($data));
                case 'user_view_card': // 进入会员卡事件推送
                    $result = $this->userViewCard(new CUserViewCard($data));
                case 'user_enter_session_from_card': // 从卡券进入公众号会话事件推送
                    $result = $this->userEnterSessionFromCard(new CUserEnterSessionFormCard($data));
                case 'update_member_card': // 会员卡内容更新事件
                    $result = $this->updateMemberCard(new CUpdateMemberCard($data));
                case 'card_sku_remind': // 库存报警事件
                    $result = $this->cardSkuRemind(new CCardSkuRemind($data));
                case 'card_pay_order': // 券点流水详情事件
                    $result = $this->cardPayOrder(new CCardPayOrder($data));
                case 'submit_membercard_user_info': // 会员卡激活事件推送
                    $result = $this->submitMembercardUserInfo(new CSubmitMembercardUserInfo($data));
                default:
                    throw new \Exception("未找到解析内容");
                    break;
            }
            return $result;
        } catch (\Exception $e) {
            $err = "CardCallback::error:" . $e->getMessage();
            $this->error($err);
            return false;
        }
    }

    /**
     *
     * 卡券审核通过
     *
     * @param \qwechat\card\orm\CAuditSuccess $obj            
     * @return boolean
     */
    abstract public function cardAuditSuccess($obj);

    /**
     * 卡券审核不通过
     *
     * @param \qwechat\card\orm\CAuditRefuse $obj            
     * @return boolean
     */
    abstract public function cardAuditRefuse($obj);

    /**
     * 用户领取卡券
     *
     * @param \qwechat\card\orm\CUserGetCard $obj            
     * @return boolean
     */
    abstract public function userGetCard($obj);

    /**
     * 转赠事件
     *
     * @param \qwechat\card\orm\CUserGiftingCard $obj            
     * @return boolean
     */
    abstract public function userGiftingCard($obj);

    /**
     * 用户删除卡券
     *
     * @param \qwechat\card\orm\CUserDelCard $obj            
     * @return boolean
     */
    abstract public function userDelCard($obj);

    /**
     * 卡券核销事件推送
     *
     * @param \qwechat\card\orm\CUserConsumeCard $obj            
     * @return boolean
     */
    abstract public function userConsumeCard($obj);

    /**
     * 买单事件推送
     *
     * @param \qwechat\card\orm\CUserPayFormPayCell $obj            
     * @return boolean
     */
    abstract public function userPayFromPayCell($obj);

    /**
     * 进入会员卡事件推送
     *
     * @param \qwechat\card\orm\CUserViewCard $obj            
     * @return boolean
     */
    abstract public function userViewCard($obj);

    /**
     * 进入会员卡事件推送
     *
     * @param \qwechat\card\orm\CUserEnterSessionFormCard $obj            
     * @return boolean
     */
    abstract public function userEnterSessionFromCard($obj);

    /**
     * 会员卡内容更新事件
     *
     * @param \qwechat\card\orm\CUpdateMemberCard $obj            
     * @return boolean
     */
    abstract public function updateMemberCard($obj);

    /**
     * 库存报警事件
     *
     * @param \qwechat\card\orm\CCardSkuRemind $obj            
     * @return boolean
     */
    abstract public function cardSkuRemind($obj);

    /**
     * 券点流水详情事件
     *
     * @param \qwechat\card\orm\CCardPayOrder $obj            
     * @return boolean
     */
    abstract public function cardPayOrder($obj);

    /**
     * 会员卡激活事件推送
     *
     * @param \qwechat\card\orm\CSubmitMembercardUserInfo $obj            
     * @return boolean
     */
    abstract public function submitMembercardUserInfo($obj);
}