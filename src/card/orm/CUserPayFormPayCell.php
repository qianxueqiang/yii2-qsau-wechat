<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 买单事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $UserCardCode code序列号。
 * @property String $TransId 微信支付交易订单号（只有使用买单功能核销的卡券才会出现）
 * @property String $LocationId 门店ID，当前卡券核销的门店ID（只有通过卡券商户助手和买单核销时才会出现）
 * @property String $Fee 实付金额，单位为分
 * @property String $OriginalFee 应付金额，单位为分
 *          
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserPayFormPayCell extends ORM
{
}