<?php
namespace qwechat\base;

/**
 * 回调接口
 *
 * @date 2018年3月16日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
interface ICallback
{

    /**
     * 执行回调操作
     */
    public function run();

    /**
     * 异常回调，当执行过程中出现异常时的异常回调处理
     *
     * @param unknown $err            
     */
    public function error($err);
}