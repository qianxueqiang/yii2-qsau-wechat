<?php
namespace qwechat\test;

use qwechat\card\CardCallback;

/**
 * 针对微信卡券的回调
 *
 * @date 2018年3月29日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class WxCardCallback extends CardCallback
{

    /**
     * 卡券审核通过
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::cardAuditSuccess()
     * @return boolean
     */
    public function cardAuditSuccess($obj)
    {}

    /**
     * 卡券审核通过
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::cardAuditSuccess()
     * @return boolean
     */
    public function cardAuditSuccess($obj)
    {}

    /**
     * 卡券审核不通过
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::cardAuditRefuse()
     * @return boolean
     */
    public function cardAuditRefuse($obj)
    {}

    /**
     * 用户领取卡券
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userGetCard()
     * @return boolean
     */
    public function userGetCard($obj)
    {}

    /**
     * 转赠事件
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userGiftingCard()
     * @return boolean
     */
    public function userGiftingCard($obj)
    {}

    /**
     * 用户删除卡券
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userDelCard()
     * @return boolean
     */
    public function userDelCard($obj)
    {}

    /**
     * 卡券核销事件推送
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userConsumeCard()
     * @return boolean
     */
    public function userConsumeCard($obj)
    {}

    /**
     * 买单事件推送
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userPayFromPayCell()
     * @return boolean
     */
    public function userPayFromPayCell($obj)
    {}

    /**
     * 进入会员卡事件推送
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userViewCard()
     * @return boolean
     */
    public function userViewCard($obj)
    {}

    /**
     * 进入会员卡事件推送
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::userEnterSessionFromCard()
     * @return boolean
     */
    public function userEnterSessionFromCard($obj)
    {}

    /**
     * 会员卡内容更新事件
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::updateMemberCard()
     * @return boolean
     */
    public function updateMemberCard($obj)
    {}

    /**
     * 库存报警事件
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::cardSkuRemind()
     * @return boolean
     */
    public function cardSkuRemind($obj)
    {}

    /**
     * 券点流水详情事件
     *
     * @param \qwechat\card\orm\CCardPayOrder $obj            
     * @return boolean
     */
    public function cardPayOrder($obj)
    {}

    /**
     * 会员卡激活事件推送
     *
     * {@inheritdoc}
     *
     * @see \qwechat\card\CardCallback::submitMembercardUserInfo()
     * @return boolean
     */
    public function submitMembercardUserInfo($obj)
    {}

    /**
     * 异常处理
     *
     * 当通知出现异常时，可以通过此回调函数对异常进行处理
     *
     * {@inheritdoc}
     *
     * @see \qwechat\base\ICallback::error()
     */
    public function error($err)
    {}
}