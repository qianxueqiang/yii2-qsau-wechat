<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 删除事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $UserCardCode code序列号。自定义code及非自定义code的卡券被领取后都支持事件推送
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserDelCard extends ORM
{
}