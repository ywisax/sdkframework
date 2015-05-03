<?php

namespace sdk\Mvc\Flow;

use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;
use sdk\Http\HttpRequest;

/**
 * MVC初始化流程
 *
 * @package sdk\Mvc\Flow
 */
class MvcInit extends FlowLayer implements FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle()
    {
        // 进行路由分发

        /** @var HttpRequest $request */
        $request = $this->flow->contexts['request'];
        //var_dump($request->query());
        //echo "mvcInit: " . spl_object_hash($request) . "<br>\n";

        $this->flow->contexts['response'] = $request->execute();
    }
}
