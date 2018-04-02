<?php
namespace qwechat\consts;

/**
 * 微信卡券接口配置
 *
 * @date 2018年3月9日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class CardConsts
{

    /**
     * 添加卡券
     *
     * @var string
     */
    const API_CARD_CREATE = 'https://api.weixin.qq.com/card/create';

    /**
     * 删除卡券
     *
     * @var string
     */
    const API_CARD_DELETE = 'https://api.weixin.qq.com/card/delete';

    /**
     * 设置卡券失效
     *
     * @var string
     */
    const API_CARD_UNAVAILABLE = 'https://api.weixin.qq.com/card/code/unavailable';

    /**
     * 获取卡券信息
     *
     * @var string
     */
    const API_CARD_GET = 'https://api.weixin.qq.com/card/get';

    /**
     * 获取卡券在该公众号上的领取列表
     *
     * @var string
     */
    const API_CARD_GETCARDLIST = 'https://api.weixin.qq.com/card/user/getcardlist';

    /**
     * 修改卡券接口
     *
     * @var string
     */
    const API_CARD_UPDATE = 'https://api.weixin.qq.com/card/update';

    /**
     * 修改卡券库存
     *
     * @var string
     */
    const API_CARD_UPDATE_STOCK = 'https://api.weixin.qq.com/card/modifystock';

    /**
     * 修改卡券code
     *
     * @var string
     */
    const API_CARD_UPDATE_CODE = 'https://api.weixin.qq.com/card/code/update';

    /**
     * 拉取卡券概况数据接口
     *
     * @var string
     */
    const API_CARD_BIZUININFO = 'https://api.weixin.qq.com/datacube/getcardbizuininfo';

    /**
     * 拉取卡券概况数据接口
     *
     * @var string
     */
    const API_CARD_CONSUME = 'https://api.weixin.qq.com/card/code/consume';

    /**
     * 创建卡券发券二维码
     *
     * @var string
     */
    const API_CARD_CREATE_QRCODE = 'https://api.weixin.qq.com/card/qrcode/create';

    /**
     * 为制定的卡券增加自定义code
     *
     * @var string
     */
    const API_CARD_PUSH_CODE = 'http://api.weixin.qq.com/card/code/deposit';

    /**
     * 查询导入code数目
     */
    const API_CARD_GETE_DEPOSIT_COUNT = 'http://api.weixin.qq.com/card/code/getdepositcount';

    /**
     * 查询导入code数目接口
     *
     * @var string
     */
    const API_CARD_GET_PUSH_CODE_COUNT = 'http://api.weixin.qq.com/card/code/getdepositcount';

    /**
     * 核查code接口
     *
     * @var string
     */
    const API_CARD_CHECK_CODE = 'http://api.weixin.qq.com/card/code/checkcode';

    /**
     * 获取卡券列表
     * 
     * @var string
     */
    const API_CARD_LIST = 'https://api.weixin.qq.com/card/batchget';

    /**
     * 图片上传地址
     */
    const API_CARD_IMG_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg';
}