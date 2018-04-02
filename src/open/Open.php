<?php
namespace qwechat\open;

use qwechat\tool\HttpClient;
use qwechat\consts\OpenConsts;
use qwechat\crypto\WXBizMsgCrypt;
use qwechat\crypto\Prpcrypt;

/**
 * 第三方开放平台类
 *
 * 参考文档：https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1453779503&token=&lang=zh_CN
 *
 * 操作步骤：
 * 1、接受微信推送的component_verify_ticket，接受微信推送后，需要将xml中的Encrypt通过
 * qwechat\crypto\Prpcrypt::decrypt进行解密，得到ticket
 * 数据接收用@file_get_contents('php://input');进行接收，得到的数据大概如下：
 * <xml>\n <AppId><![CDATA[wx949f5f983209f77e]]><\/AppId>\n <Encrypt><![CDATA[VkrHOme\/X3yOLymrh\/5oViODoDZuMrwSIFhc3tmT5c7Flw8tVeLVndSN6eA\/mLRGEjxcoSuFT7sl6Z5OfoSCrX1YHeOmc1ufJj7\/F66Cn5K+atMvm8zSvPaHw4JQAd\/gt6nY3jN2cCh2qriFxhpatCaE8h6tOKAKdFxsM1e3QO+5T+A+Rw+yGpYUosssEsCrDlyX51UGHKvKVzzufI8NCNBqRvsefcKqtj3Jlt5mUj16+9K7OQvO15bOP8yPAHjEw0PC4whLMuQUnJUdO8Y5NHGRrfmWCHGMExe2qraf0mdNPhfHFolq18emNVXEZVgHERGCgWeazB0tpK77sXuMQI0V2FZH\/HvWObwO83ozT78B1Ef3ZbZjoXAb+Nylm3xN8TArDxf4T1iW\/v+hWTdtrHX0Q8sv\/tz1KuRTkQ8uEtwmVt6mcEdTZSm8tVEgJ40JHL\/ROFr676Dcp4Ld8aLsKw==]]><\/Encrypt>\n<\/xml>\n
 *
 * 2、获取第三方平台component_access_token【qwechat\open\Open::getAccessToken($ticket)】
 * 来获取第三方平台的access_token
 *
 * 3、获取预授权码pre_auth_code，【qwechat\open\Open::getAuthCode($access_token)】
 * 来获取第三方平台的pre_auth_code
 *
 * 4、生成授权二维码，此过程需需要调用，【qwechat\open\Open::getAuthUrl($auth_code,$redirect_uri)】
 * 将页面跳转到返回url中即可。
 * 此时需要注意的是：
 * 1）“登录授权的发起页域名”和此时做页面跳转的域名，还有“授权事件接收URL”的域名要保持在一个域名下（如果用二级域名，则全部需要填写二级域名）
 * 2）appid是公众号的appid
 *
 * 5、公众号管理员扫了授权二维码后，就会向根据公众号运营者管理员的授权信息，去抓取auth_code和expires_in，通过302的形式跳转到redirect_uri对应地址
 * 数据格式：
 * https://iadapi.51wanquan.com/?auth_code=queryauthcode@@@xxxx&expires_in=3600
 *
 * 6、通过auth_code就可以对被授权的公众平台做相关操作了
 * 1）获取公众号或小程序的接口调用凭据和授权信息【qwechat\open\Open::getAuthInfo($appid,$auth_code)】
 * 2）刷新授权token【qwechat\open\Open::refreshAuthAccessToken($access_token, $authorizer_appid, $authorizer_refresh_token)】
 * 3）获取公众号或小程序的授权基本信息【qwechat\open\Open::getAuthAccountInfo($appid,$auth_code)】
 * 4）获取授权方的选项设置信息
 * 5）设置授权方的选项信息
 *
 * @date 2018年3月6日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class Open
{

    /**
     * 第三方公众平台的appid
     *
     * @var string
     */
    private $appid;

    /**
     * 第三方平台的key（encodingAesKey）
     *
     * @var string
     */
    private $aeskey;

    /**
     * 开放平台的token
     *
     * @var string
     */
    private $token;

    /**
     * 开放平台的secret
     *
     * @var string
     */
    private $secret;

    /**
     * 初始化函数
     *
     * @param string $conf            
     */
    public function __construct($conf)
    {
        $this->appid = isset($conf['appid']) ? $conf['appid'] : '';
        $this->aeskey = isset($conf['aeskey']) ? $conf['aeskey'] : '';
        $this->token = isset($conf['token']) ? $conf['token'] : '';
        $this->secret = isset($conf['secret']) ? $conf['secret'] : '';
    }

    /**
     * 获取当前应用的appid
     *
     * @return string
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * 设置appid
     *
     * @param string $appid            
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;
    }

    /**
     * 获取secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * 获取解密私钥
     *
     * @return string
     */
    public function getAesKey()
    {
        return $this->aeskey;
    }

    /**
     * 设置secret
     *
     * @param string $secret            
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * 获取加密类
     *
     * @param String $token
     *            token信息
     * @param String $encodingAesKey
     *            AesKey编码
     * @param String $appId
     *            应用的appid
     * @return \qwechat\crypto\WXBizMsgCrypt
     */
    public function getCrypto($token, $encodingAesKey, $appId)
    {
        return new WXBizMsgCrypt($token, $encodingAesKey, $appId);
    }

    /**
     * 获取直接加密解密对象
     *
     * @param string $key
     *            解密的key对象，对应：公众号消息加解密Key
     *            
     * @return \qwechat\crypto\Prpcrypt
     */
    public function getPrpcrypt($aeskey = "", $appid = "")
    {
        if (empty($aeskey)) {
            $aeskey = $this->getAesKey();
        }
        if (empty($appid)) {
            $appid = $this->getAppid();
        }
        return new Prpcrypt($aeskey, $appid);
    }

    /**
     * 获取开放平台的 access_token
     *
     * @param string $appid
     *            component_appid 第三方平台appid
     * @param string $secret
     *            component_appsecret 第三方平台appsecret
     * @param string $ticket
     *            component_verify_ticket 微信后台推送的ticket，此ticket会定时推送，具体请见本页的推送说明
     */
    public function getAccessToken($ticket)
    {
        $url = OpenConsts::API_OPEN_ACCESS_TOKEN;
        $postdata = [
            'component_appid' => $this->appid,
            'component_appsecret' => $this->secret,
            'component_verify_ticket' => $ticket
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 获取authcode
     *
     * @param string $access_token            
     * @param string $appid            
     * @return mixed
     */
    public function getAuthCode($access_token, $appid = "")
    {
        if (! empty($appid)) {
            $this->appid = $appid;
        }
        $url = OpenConsts::API_OPEN_AUTH_CODE . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $this->appid
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 获取用户授权页的URL地址
     *
     * @param string $appid
     *            component_appid第三方平台方appid
     * @param string $pre_auth_code
     *            第三方平台方appid预授权码
     * @param string $redirect_uri
     *            redirect_uri回调URI，此URL必须和开放平台填写的“登录授权的发起页域名”保持一致
     * @param number $auth_type
     *            要授权的帐号类型， 1则商户扫码后，手机端仅展示公众号、2表示仅展示小程序，3表示公众号和小程序都展示。
     *            如果为未制定，则默认小程序和公众号都展示。第三方平台开发者可以使用本字段来控制授权的帐号类型。
     * @return string
     */
    public function getAuthUrl($pre_auth_code, $redirect_uri, $auth_type = 3, $appid = "")
    {
        $appid = empty($appid) ? $this->appid : $appid;
        $url = OpenConsts::API_OPEN_AUTH_URL . "?component_appid=" . $appid . "&pre_auth_code=" . $pre_auth_code . "&redirect_uri=" . $redirect_uri . "&auth_type=" . $auth_type;
        return $url;
    }

    /**
     * 获取公众号或者小程序的授权信息，授权信息中包括：
     *
     * authorizer_appid 授权方appid
     * authorizer_access_token 授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌
     * expires_in 有效期（在授权的公众号或小程序具备API权限时，才有此返回值）
     * authorizer_refresh_token 接口调用凭据刷新令牌（在授权的公众号具备API权限时，才有此返回值），刷新令牌主要用于第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。 一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌
     * func_info 授权给开发者的权限集列表，ID为1到26分别代表： 1、消息管理权限 2、用户管理权限 3、帐号服务权限 4、网页服务权限 5、微信小店权限 6、微信多客服权限 7、群发与通知权限 8、微信卡券权限 9、微信扫一扫权限 10、微信连WIFI权限 11、素材管理权限 12、微信摇周边权限 13、微信门店权限 14、微信支付权限 15、自定义菜单权限 16、获取认证状态及信息 17、帐号管理权限（小程序） 18、开发管理与数据分析权限（小程序） 19、客服消息管理权限（小程序） 20、微信登录权限（小程序） 21、数据分析权限（小程序） 22、城市服务接口权限 23、广告管理权限 24、开放平台帐号管理权限 25、 开放平台帐号管理权限（小程序） 26、微信电子发票权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。
     *
     * @param string $access_token
     *            第三方开放平台的操作码
     * @param string $auth_code
     *            公众号授权的auth_codes
     * @param string $appid
     *            第三方开放平台appid
     * @return mixed
     */
    public function getAuthInfo($access_token, $auth_code, $appid = "")
    {
        $appid = empty($appid) ? $this->appid : $appid;
        $url = OpenConsts::API_OPEN_QUERY_AUTH . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $appid,
            'authorization_code' => $auth_code
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 刷新公众号|小程序的授权的access_token
     *
     * @param string $access_token
     *            第三方的access_token
     * @param string $authorizer_appid
     *            授权的appid
     * @param string $authorizer_refresh_token
     *            授权的refresh_token
     * @param string $appid
     *            第三方appid
     * @return mixed
     */
    public function refreshAuthAccessToken($access_token, $authorizer_appid, $authorizer_refresh_token, $appid = "")
    {
        $appid = empty($appid) ? $this->appid : $appid;
        $url = OpenConsts::API_OPEN_REFRESH_ACCESS_TOKEN . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $appid,
            'authorizer_appid' => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 获取授权的公众号或小程序的账户信息
     *
     * @param string $access_token
     *            开放平台的access_token
     * @param string $auth_appid
     *            授权的appid
     * @param string $appid
     *            可选，开放平台的appid
     * @return mixed
     */
    public function getAuthAccountInfo($access_token, $auth_appid, $appid = "")
    {
        $appid = empty($appid) ? $this->appid : $appid;
        $url = OpenConsts::API_OPEN_AUTH_ACCOUNT_INFO . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $appid,
            'authorizer_appid' => $auth_appid
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 获取授权方的选项设置信息
     *
     * 该API用于获取授权方的公众号或小程序的选项设置信息，如：地理位置上报，语音识别开关，多客服开关。注意，获取各项选项设置信息，需要有授权方的授权，详见权限集说明。
     *
     * @param string $access_token
     *            第三方开放平台的access_token
     * @param string $auth_appid
     *            授权公众平台的appid
     * @param string $open_name
     *            要查询选型的名称
     * @return mixed
     */
    public function getAuthOption($access_token, $auth_appid, $open_name)
    {
        $url = OpenConsts::API_OPEN_AUTH_OPTION . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $appid,
            'authorizer_appid' => $auth_appid,
            'option_name' => $open_name
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 设置授权方的选项信息
     *
     * 该API用于设置授权方的公众号或小程序的选项信息，如：地理位置上报，语音识别开关，多客服开关。注意，设置各项选项设置信息，需要有授权方的授权，详见权限集说明。
     *
     * @param string $access_token
     *            第三方开放平台的access_token
     * @param string $auth_appid
     *            授权公众平台的appid
     * @param string $open_name
     *            要查询选型的名称
     * @param string $open_value
     *            设置的选项值
     * @return mixed
     */
    public function setAuthOption($access_token, $auth_appid, $open_name, $open_value)
    {
        $url = OpenConsts::API_OPEN_SET_AUTH_OPTION . "?component_access_token=" . $access_token;
        $postdata = [
            'component_appid' => $appid,
            'authorizer_appid' => $auth_appid,
            'option_name' => $open_name,
            'option_value' => $open_value
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 开放平台小程序login操作
     *
     * @param string $appid            
     * @param string $js_code            
     * @param string $grant_type            
     * @return string
     */
    public function smallLogin($appid, $js_code, $grant_type = 'authorization_code')
    {
        $component_appid = $this->getAppid();
        $url = OpenConsts::API_OPEN_SMALL_USER_LOGIN . "?appid=" . $appid . "&js_code=" . $js_code . "&grant_type=" . $grant_type . "&component_appid=" . $component_appid . "&component_access_token=" . $access_token;
        $http = new HttpClient();
        $data = $http->get($url);
        return $data;
    }
}