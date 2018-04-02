<?php
namespace qwechat\base;

/**
 * 数据映射基类
 *
 * @date 2018年4月2日
 *
 * @author xueqiang.qian<xueqiang.qian@qq.com>
 */
class ORM
{

    public function __construct(array $data)
    {
        $this->assign($data);
    }

    /**
     * 对象赋值
     *
     * @param array $data            
     */
    private function assign(array $data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }
}