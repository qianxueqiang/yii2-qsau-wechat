<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 转赠事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $FriendUserName 接收卡券用户的openid
 * @property String $UserCardCode code序列号。
 * @property String $IsReturnBack 是否转赠退回，0代表不是，1代表是
 * @property String $IsChatRoom 是否是群转赠
 *          
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserGiftingCard extends ORM
{
}