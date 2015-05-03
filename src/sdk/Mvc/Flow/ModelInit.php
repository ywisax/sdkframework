<?php

namespace sdk\Mvc\Flow;

use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;

/**
 * 模型初始化
 *
 * @package sdk\Mvc\Flow
 */
class ModelInit extends FlowLayer implements FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle()
    {
    }
}
