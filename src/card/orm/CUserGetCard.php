<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 领取事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $IsGiveByFriend 是否为转赠领取，1代表是，0代表否。
 * @property String $FriendUserName 当IsGiveByFriend为1时填入的字段，表示发起转赠用户的openid
 * @property String $UserCardCode code序列号。
 * @property String $OldUserCardCode 为保证安全，微信会在转赠发生后变更该卡券的code号，该字段表示转赠前的code。
 * @property String $OuterStr 领取场景值，用于领取渠道数据统计。可在生成二维码接口及添加Addcard接口中自定义该字段的字符串值。
 * @property String $IsRestoreMemberCard 用户删除会员卡后可重新找回，当用户本次操作为找回时，该值为1，否则为0
 *          
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserGetCard extends ORM
{
}