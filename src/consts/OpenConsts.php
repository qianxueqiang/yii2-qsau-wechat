<?php
namespace qwechat\consts;

/**
 * 微信开放平台的配置
 *
 * @date 2018年2月28日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class OpenConsts
{

    /**
     * 开放平台授权
     *
     * @var string
     */
    const API_OPEN_AUTH = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';

    /**
     * 获取开放平台的access_token
     *
     * @var string
     */
    const API_OPEN_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';

    /**
     * 获取开放平台的authcode
     *
     * @var string
     */
    const API_OPEN_AUTH_CODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode';

    /**
     * 获取开放平台执行公众号|小程序授权信息
     *
     * @var string
     */
    const API_OPEN_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth';

    /**
     * 调起授权二维码的授权地址
     *
     * @var string
     */
    const API_OPEN_AUTH_URL = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';

    /**
     * 刷新access_token
     *
     * @var string
     */
    const API_OPEN_REFRESH_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token';

    /**
     * 获取公众号|小程序的账户信息
     *
     * @var string
     */
    const API_OPEN_AUTH_ACCOUNT_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info';

    /**
     * 获取授权方的选项设置信息
     *
     * @var string
     */
    const API_OPEN_AUTH_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_option';

    /**
     * 设置授权方的选项信息
     *
     * @var string
     */
    const API_OPEN_SET_AUTH_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/api_set_authorizer_option';

    /**
     * 小程序微信login
     *
     * @var string
     */
    const API_OPEN_SMALL_USER_LOGIN = 'https://api.weixin.qq.com/sns/component/jscode2session';
}