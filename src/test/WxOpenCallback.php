<?php
namespace qwechat\test;

use qwechat\open\OpenCallback;

/**
 * 微信开放平台的回调
 *
 * 该类继承OpenCallback，需要实现OpenCallback中定义的一些抽象函数
 *
 * @date 2018年3月20日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class WxOpenCallback extends OpenCallback
{

    /**
     *
     * 授权通知
     *
     * 每10分钟一次，用于接收取消授权通知、授权成功通知、授权更新通知，也用于接收ticket，ticket是验证平台方的重要凭据，
     * 服务方在获取component_access_token时需要提供最新推送的ticket以供验证身份合法性。此ticket作为验证服务
     * 方的重要凭据，要妥善保存。
     *
     * {@inheritdoc}
     *
     * @see \qwechat\open\OpenCallback::CTicket()
     */
    public function CTicket($ticket)
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