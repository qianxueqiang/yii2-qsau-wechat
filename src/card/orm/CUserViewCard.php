<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 进入会员卡事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $UserCardCode code序列号。
 * @property String $OuterStr 商户自定义二维码渠道参数，用于标识本次扫码打开会员卡来源来自于某个渠道值的二维码
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserViewCard extends ORM
{
}