<?php

namespace sdk\Base\Flow;

/**
 * handle实现接口
 *
 * @package sdk\Base\Flow
 */
interface FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle();
}
