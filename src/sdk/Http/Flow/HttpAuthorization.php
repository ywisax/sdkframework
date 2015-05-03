<?php

namespace sdk\Http\Flow;

use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;

/**
 * HTTP授权
 *
 * @package sdk\Mvc\Flow
 */
class HttpAuthorization extends FlowLayer implements FlowHandlerInterface
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
