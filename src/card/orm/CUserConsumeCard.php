<?php
namespace qwechat\card\orm;

use qwechat\base\ORM;

/**
 * 核销事件推送
 *
 * @property String $ToUserName 开发者微信号
 * @property String $FromUserName 发送方帐号（一个OpenID）
 * @property String $CreateTime 消息创建时间 （整型）
 * @property String $CardId 卡券ID
 * @property String $UserCardCode 卡券Code码
 * @property String $ConsumeSource 核销来源。支持开发者统计API核销（FROM_API）、公众平台核销（FROM_MP）、卡券商户助手核销（FROM_MOBILE_HELPER）（核销员微信号）
 * @property String $LocationName 门店名称，当前卡券核销的门店名称（只有通过自助核销和买单核销时才会出现该字段）
 * @property String $StaffOpenId 核销该卡券核销员的openid（只有通过卡券商户助手核销时才会出现）
 * @property String $VerifyCode 自助核销时，用户输入的验证码
 * @property String $RemarkAmount 自助核销 时 ，用户输入的备注金额
 * @property String $OuterStr 开发者发起核销时传入的自定义参数，用于进行核销渠道统计
 *          
 *          
 *           @date 2018年4月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CUserConsumeCard extends ORM
{
}