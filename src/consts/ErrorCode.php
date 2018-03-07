<?php

namespace qwechat\consts;

/**
 * error code 说明.
 * <ul>
 *    <li>-40001: 签名验证错误</li>
 *    <li>-40002: xml解析失败</li>
 *    <li>-40003: sha加密生成签名失败</li>
 *    <li>-40004: encodingAesKey 非法</li>
 *    <li>-40005: appid 校验错误</li>
 *    <li>-40006: aes 加密失败</li>
 *    <li>-40007: aes 解密失败</li>
 *    <li>-40008: 解密后得到的buffer非法</li>
 *    <li>-40009: base64加密失败</li>
 *    <li>-40010: base64解密失败</li>
 *    <li>-40011: 生成xml失败</li>
 * </ul>
 *
 * @date 2018年3月2日
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class ErrorCode
{
    /**
     * 正确
     * 
     * @var integer
     */
	public static $OK = 0;
	/**
	 * 签名校验失败
	 * 
	 * @var unknown
	 */
	public static $ValidateSignatureError = -40001;
	/**
	 * xml解析异常
	 * 
	 * @var unknown
	 */
	public static $ParseXmlError = -40002;
	/**
	 * 计算签名异常
	 * 
	 * @var unknown
	 */
	public static $ComputeSignatureError = -40003;
	/**
	 * 非法的AesKey
	 * @var unknown
	 */
	public static $IllegalAesKey = -40004;
	/**
	 * appid校验异常
	 * 
	 * @var unknown
	 */
	public static $ValidateAppidError = -40005;
	public static $EncryptAESError = -40006;
	public static $DecryptAESError = -40007;
	public static $IllegalBuffer = -40008;
	public static $EncodeBase64Error = -40009;
	public static $DecodeBase64Error = -40010;
	public static $GenReturnXmlError = -40011;
}

?>