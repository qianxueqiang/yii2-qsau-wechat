<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 券点流水详情事件
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $OrderId 本次推送对应的订单号
 * @property String $Status 本次订单号的状态：
 *           ORDER_STATUS_WAITING 等待支付
 *           ORDER_STATUS_SUCC 支付成功
 *           ORDER_STATUS_FINANCE_SUCC 加代币成功
 *           ORDER_STATUS_QUANTITY_SUCC 加库存成功
 *           ORDER_STATUS_HAS_REFUND 已退币
 *           ORDER_STATUS_REFUND_WAITING 等待退币确认
 *           ORDER_STATUS_ROLLBACK 已回退,系统失败
 *           ORDER_STATUS_HAS_RECEIPT 已开发票
 * @property String $CreateOrderTime 购买券点时，支付二维码的生成时间
 * @property String $PayFinishTime 购买券点时，实际支付成功的时间
 * @property String $Desc 支付方式，一般为微信支付充值
 * @property String $FreeCoinCount 剩余免费券点数量
 * @property String $PayCoinCount 剩余付费券点数量
 * @property String $RefundFreeCoinCount 本次变动的免费券点数量
 * @property String $RefundPayCoinCount 本次变动的付费券点数量
 * @property String $OrderType 所要拉取的订单类型：
 *           ORDER_TYPE_SYS_ADD 平台赠送券点
 *           ORDER_TYPE_WXPAY 充值券点
 *           ORDER_TYPE_REFUND 库存未使用回退券点
 *           ORDER_TYPE_REDUCE 券点兑换库存
 *           ORDER_TYPE_SYS_REDUCE 平台扣减
 * @property String $Memo 系统备注，说明此次变动的缘由，如开通账户奖励、门店奖励、核销奖励以及充值、扣减
 * @property String $ReceiptInfo 所开发票的详情
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CCardPayOrder extends ORM
{
}