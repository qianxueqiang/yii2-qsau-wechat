<?php
namespace qwechat\consts;

/**
 * 微信接口配置
 *
 * @date 2018年2月28日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class WxApiUrl
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
}