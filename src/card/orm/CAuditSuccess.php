<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 审核事件推送：审核通过
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CAuditSuccess extends ORM
{
}