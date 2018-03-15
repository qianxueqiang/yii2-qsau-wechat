<?php
namespace qwechat\card;

use qwechat\consts\CardConsts;

/**
 * 微信卡券功能
 *
 * @property \qwechat\card\CardStyle $card_style 卡券资源
 *          
 *           @date 2018年3月7日
 *          
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class Card
{

    /**
     * 授权操作的access_token
     *
     * @var unknown
     */
    private $access_token;

    /**
     * 卡券样式资源类
     *
     * @var \qwechat\card\CardStyle
     */
    private static $card_style;

    /**
     * 初始化函数
     *
     * @param unknown $access_token            
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * 创建卡券
     *
     * @param unknown $cardType            
     * @param unknown $baseInfo            
     * @param unknown $especial            
     * @return boolean
     */
    public function create($base_info, $advanced_info = '', $card_type = "GROUPON")
    {
        $url = CardConsts::API_CARD_CREATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card' => [
                'card_type' => $card_type,
                'groupon' => [
                    'base_info' => $base_info,
                    'advanced_info' => $advanced_info,
                    'default_detail' => $default_detail
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 创建代金券
     *
     * @param unknown $base_info
     *            优惠券信息
     * @param string $least_cost
     *            满多少
     * @param string $reduce_cost
     *            减多少
     * @param string $advanced_info
     *            高级属性
     * @return unknown
     */
    public function createCash($base_info, $least_cost = '1000', $reduce_cost = '100', $advanced_info = '')
    {
        $url = CardConsts::API_CARD_CREATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card' => [
                'card_type' => 'CASH',
                'cash' => [
                    'base_info' => $base_info,
                    'advanced_info' => $advanced_info,
                    'least_cost' => $least_cost,
                    'reduce_cost' => $reduce_costa
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 创建折扣券
     *
     * @param unknown $base_info
     *            优惠券基本信息
     * @param number $discount
     *            优惠百分比
     * @param string $advanced_info
     *            优惠券高级属性
     * @return unknown
     */
    public function createDiscount($base_info, $discount = 30, $advanced_info = '')
    {
        $url = CardConsts::API_CARD_CREATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card' => [
                'card_type' => 'DISCOUNT',
                'cash' => [
                    'base_info' => $base_info,
                    'advanced_info' => $advanced_info,
                    'discount' => $discount
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 创建兑换券
     *
     * @param unknown $base_info
     *            优惠券基本信息
     * @param string $gift
     *            兑换券信息
     * @param string $advanced_info
     *            优惠券高级选项
     * @return unknown
     */
    public function createGift($base_info, $gift = '', $advanced_info = '')
    {
        $url = CardConsts::API_CARD_CREATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card' => [
                'card_type' => 'GIFT',
                'gift' => [
                    'base_info' => $base_info,
                    'advanced_info' => $advanced_info,
                    'gift' => $gift
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 创建普通优惠券
     *
     * @param unknown $base_info
     *            优惠券基本信息
     * @param string $default_detail
     *            优惠券专用，填写优惠详情。
     * @param string $advanced_info
     *            优惠券高级选项
     * @return string
     */
    public function createCoupon($base_info, $default_detail = '', $advanced_info = '')
    {
        $url = CardConsts::API_CARD_CREATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card' => [
                'card_type' => 'GENERAL_COUPON',
                'gift' => [
                    'base_info' => $base_info,
                    'advanced_info' => $advanced_info,
                    'default_detail' => $default_detail
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 删除卡券
     *
     * @param unknown $card_id            
     * @return string
     */
    public function delete($card_id)
    {
        $url = CardConsts::API_CARD_DELETE . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 更改卡券信息：
     * 支持更新所有卡券类型的部分通用字段及特殊卡券（会员卡、飞机票、电影票、会议门票）中特定字段的信息。
     *
     * @param unknown $card_id
     *            要修改的卡券id
     * @param unknown $base_info
     *            要修改卡券的基础信息
     * @param array $custom_attr
     *            要修改卡券的自定义信息，如：bonus_cleared（积分清零规则，会员卡专用。）
     * @return unknown
     */
    public function update($card_id, $base_info, $custom_attr = [])
    {
        $url = CardConsts::API_CARD_UPDATE . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'member_card' => [
                'base_info' => $base_info
            ]
        ];
        if (is_array($custom_attr)) {
            foreach ($custom_attr as $key => $val) {
                $postdata['member_card'][$key] = $val;
            }
        }
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 卡券修改库存
     *
     * @param unknown $card_id
     *            卡券ID
     * @param unknown $increase_stock_value
     *            增加多少库存，支持不填或填0。
     * @param unknown $reduce_stock_value
     *            减少多少库存，可以不填或填0。
     * @return unknown
     */
    public function updateStock($card_id, $increase_stock_value = 0, $reduce_stock_value = 0)
    {
        $url = CardConsts::API_CARD_UPDATE_STOCK . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'increase_stock_value' => $increase_stock_value,
            'reduce_stock_value' => $reduce_stock_value
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 更改Code接口
     *
     * @param unknown $card_id
     *            卡券ID。自定义Code码卡券为必填
     * @param unknown $old_code
     *            需变更的Code码
     * @param unknown $new_code
     *            变更后的有效Code码
     * @return unknown
     */
    public function updateCode($card_id, $old_code, $new_code)
    {
        $url = CardConsts::API_CARD_UPDATE_CODE . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'code' => $old_code,
            'new_code' => $new_code
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 设置自定义卡券失效
     *
     * @param unknown $card_id
     *            卡券id
     * @param unknown $code
     *            卡券code
     * @return unknown
     */
    public function updateCustomUnavailable($card_id, $code)
    {
        $url = CardConsts::API_CARD_UNAVAILABLE . "?access_token=" . $this->access_token;
        $postdata = [
            'code' => $code,
            'card_id' => $card_id
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 设置非自定义卡券失效
     *
     * @param unknown $code
     *            卡券code
     * @param unknown $reason
     *            卡券失效原因
     * @return unknown
     */
    public function updateUncustomUnavailable($code, $reason)
    {
        $url = CardConsts::API_CARD_UNAVAILABLE . "?access_token=" . $this->access_token;
        $postdata = [
            'code' => $code,
            'reason' => $reason
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 查询Code接口，校验卡券code是否合法
     *
     * @param unknown $card_id
     *            卡券ID代表一类卡券。
     * @param unknown $code
     *            卡券code，自定义code卡券必填
     * @param string $check_consume
     *            是否校验code核销状态，填入true和false时的code异常状态返回数据不同。
     * @return unknown
     */
    public function get($card_id, $code = false, $check_consume = true)
    {
        $url = CardConsts::API_CARD_GET . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'check_consume' => $check_consume
        ];
        if ($code) {
            $postdata['code'] = $code;
        }
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 获取用户已领取卡券接口
     *
     * @param unknown $openid
     *            需要查询的用户openid
     * @param string $card_id
     *            卡券ID。不填写时默认查询当前appid下的卡券。
     *            
     * @return unknown
     */
    public function getCardList($openid, $card_id = '')
    {
        $url = CardConsts::API_CARD_GETCARDLIST . "?access_token=" . $this->access_token;
        $postdata = [
            'openid' => $openid
        ];
        if (! empty($card_id)) {
            $postdata['card_id'] = $card_id;
        }
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 查看卡券详情
     *
     * @param unknown $card_id
     *            卡券ID
     * @return unknown
     */
    public function getCardInfo($card_id)
    {
        $url = CardConsts::API_CARD_GET . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 批量查询卡券列表
     *
     * @param number $offset
     *            查询卡列表的起始偏移量，从0开始，即offset: 5是指从从列表里的第六个开始读取。
     * @param number $count
     *            需要查询的卡片的数量（数量最大50）。
     * @param array $status_list
     *            支持开发者拉出指定状态的卡券列表 “CARD_STATUS_NOT_VERIFY”, 待审核 ； “CARD_STATUS_VERIFY_FAIL”, 审核失败； “CARD_STATUS_VERIFY_OK”， 通过审核； “CARD_STATUS_DELETE”， 卡券被商户删除； “CARD_STATUS_DISPATCH”， 在公众平台投放过的卡券a
     *            示例：["CARD_STATUS_VERIFY_OK", "CARD_STATUS_DISPATCH"]
     * @return unknown
     */
    public function getCardList($offset = 0, $count = 10, $status_list = [])
    {
        $url = CardConsts::API_CARD_GET . "?access_token=" . $this->access_token;
        $postdata = [
            'offset' => $offset,
            'count' => $count
        ];
        if (! empty($status_list)) {
            $postdata['status_list'] = $status_list;
        }
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 拉取卡券概况数据
     * 说明：支持调用该接口拉取本商户的总体数据情况，包括时间区间内的各指标总量。
     *
     * @param unknown $begin_date
     *            查询数据的起始时间
     * @param unknown $end_date
     *            查询数据的截至时间
     * @param number $cond_source
     *            卡券来源，0为公众平台创建的卡券数据 、1是API创建的卡券数据
     * @return unknown
     */
    public function getBizuininfo($begin_date, $end_date, $cond_source = 0)
    {
        $url = CardConsts::API_CARD_BIZUININFO . "?access_token=" . $this->access_token;
        $postdata = [
            'begin_date' => $begin_date,
            'end_date' => $end_date,
            'cond_source' => $cond_source
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 核销卡券
     *
     * @param unknown $code
     *            需核销的Code码
     * @param string $card_id
     *            卡券ID。创建卡券时use_custom_code填写true时必填。非自定义Code不必填写
     * @return unknown
     */
    public function consume($code, $card_id = "")
    {
        $url = CardConsts::API_CARD_CONSUME . "?access_token=" . $this->access_token;
        $postdata = [
            'code' => $code
        ];
        if (! empty($card_id)) {
            $postdata['card_id'] = $card_id;
        }
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 创建单张卡券二维码领取
     * 参考：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1451025062
     *
     * @param string $code
     *            卡券Code码,use_custom_code字段为true的卡券必须填写，非自定义code和导入code模式的卡券不必填写
     * @param string $card_id
     *            卡券id
     * @param string $is_unique_code
     *            指定下发二维码，生成的二维码随机分配一个code，领取后不可再次扫描。填写true或false。默认false，注意填写该字段时，卡券须通过审核且库存不为0
     * @param string $openid
     *            指定领取者的openid，只有该用户能领取。bind_openid字段为true的卡券必须填写，非指定openid不必填写
     * @param string $outer_str
     *            outer_id字段升级版本，字符串类型，用户首次领卡时，会通过 领取事件推送 给商户； 对于会员卡的二维码，用户每次扫码打开会员卡后点击任何url，会将该值拼入url中，方便开发者定位扫码来源
     * @return string {
     *         "errcode": 0,
     *         "errmsg": "ok",
     *         "ticket": "gQHB8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JIV3lhX3psZmlvSDZmWGVMMTZvAAIEsNnKVQMEIAMAAA==",//获取ticket后需调用换取二维码接口获取二维码图片，详情见字段说明。
     *         "expire_seconds": 1800,
     *         "url": "http://weixin.qq.com/q/BHWya_zlfioH6fXeL16o ",
     *         "show_qrcode_url": " https://mp.weixin.qq.com/cgi-bin/showqrcode? ticket=gQH98DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0czVzRlSWpsamlyM2plWTNKVktvAAIE6SfgVQMEgDPhAQ%3D%3D"
     *         }
     */
    public function createQRCode($code, $card_id = '', $expire_seconds = 1800, $openid = '', $is_unique_code = false, $outer_str = '')
    {
        $url = CardConsts::API_CARD_CREATE_QRCODE . "?access_token=" . $this->access_token;
        $card = [
            'code' => $code,
            'is_unique_code' => $is_unique_code
        ];
        if (! empty($card_id)) {
            $card['card_id'] = $card_id;
        }
        if (! empty($openid)) {
            $card['openid'] = $openid;
        }
        if (! empty($outer_str)) {
            $card['outer_str'] = $outer_str;
        }
        $postdata = [
            'action_name' => 'QR_CARD',
            'expire_seconds' => $expire_seconds,
            'action_info' => [
                'card' => $card
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 设置扫描二维码领取多张卡券
     *
     * @param array $card_list
     *            卡列表，数组形式
     *            [{
     *            "card_id": "p1Pj9jgj3BcomSgtuW8B1wl-wo88", // 卡券ID
     *            "code":"2392583481", // 卡券Code码,use_custom_code字段为true的卡券必须填写，非自定义code和导入code模式的卡券不必填写
     *            "outer_str":"12b" // outer_id字段升级版本，字符串类型，用户首次领卡时，会通过 领取事件推送 给商户； 对于会员卡的二维码，用户每次扫码打开会员卡后点击任何url，会将该值拼入url中，方便开发者定位扫码来源
     *            }]
     * @return string {
     *         "errcode": 0,
     *         "errmsg": "ok",
     *         "ticket": "gQHB8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JIV3lhX3psZmlvSDZmWGVMMTZvAAIEsNnKVQMEIAMAAA==",//获取ticket后需调用换取二维码接口获取二维码图片，详情见字段说明。
     *         "expire_seconds": 1800,
     *         "url": "http://weixin.qq.com/q/BHWya_zlfioH6fXeL16o ",
     *         "show_qrcode_url": " https://mp.weixin.qq.com/cgi-bin/showqrcode? ticket=gQH98DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0czVzRlSWpsamlyM2plWTNKVktvAAIE6SfgVQMEgDPhAQ%3D%3D"
     *         }
     */
    public function createQRCodes($card_list = [])
    {
        $url = CardConsts::API_CARD_CREATE_QRCODE . "?access_token=" . $this->access_token;
        $postdata = [
            'action_name' => 'QR_MULTIPLE_CARD',
            'action_info' => [
                'multiple_card' => [
                    'card_list' => $card_list
                ]
            ]
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 为卡券增加自定义code，条件在创建卡券时需要设置：
     * 1、get_custom_code_mode = GET_CUSTOM_CODE_MODE_DEPOSIT 填入该字段后，自定义code卡券方可进行导入code并投放的动作
     * 2、use_custom_code = true 将卡券设置为自定义code
     *
     * 注：
     * 1）单次调用接口传入code的数量上限为100个
     * 2）每一个 code 均不能为空串
     * 3）导入结束后系统会自动判断提供方设置库存与实际导入code的量是否一致
     * 4）导入失败支持重复导入，提示成功为止
     *
     * @param unknown $card_id
     *            需要进行导入code的卡券ID
     * @param array $codes
     *            需导入微信卡券后台的自定义code，上限为100个
     * @return string
     */
    public function pushCode($card_id, $codes = [])
    {
        $url = CardConsts::API_CARD_PUSH_CODE . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'code' => $codes
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }

    /**
     * 查询导入code数目（导入成功）
     *
     * @param string $card_id
     *            卡券id
     * @param array $codes
     *            要检测的code码列表，格式：['1234','121212']
     *            注意：code最多支持100个code吗
     *            
     * @return string {
     *         "errcode":0, // 错误码，0为正常；40109：code数量超过100个
     *         "errmsg":"ok" // 错误信息
     *         "exist_code":["11111","22222","33333"], // 已经成功存入的code
     *         "not_exist_code":["44444","55555"] // 没有存入的code
     *         }
     */
    public function getPushCodeCount($card_id, $codes = [])
    {
        $url = CardConsts::API_CARD_CHECK_CODE . "?access_token=" . $this->access_token;
        $postdata = [
            'card_id' => $card_id,
            'code' => $codes
        ];
        $http = new HttpClient();
        $data = $http->setPostBodyRaw(json_encode($postdata))->post($url);
        return $data;
    }
}