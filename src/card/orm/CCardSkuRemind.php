<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 库存报警事件
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $Detail 报警详细信息
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CCardSkuRemind extends ORM
{
}