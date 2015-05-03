<?php

namespace sdk\Mvc\Flow;

use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;
use sdk\Http\HttpResponse;

/**
 * 视图渲染
 *
 * @package sdk\Mvc\Flow
 */
class ViewRender extends FlowLayer implements FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var HttpResponse $response */
        $response = $this->flow->contexts['response'];

        /**
         * 执行主请求
         */
        echo $response
            ->sendHeaders(true)
            ->body;
    }
}
