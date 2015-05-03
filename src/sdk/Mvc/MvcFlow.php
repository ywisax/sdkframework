<?php

namespace sdk\Mvc;

use sdk\Base\Flow;
use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;
use sdk\Http\HttpRequest;

/**
 * MVC工作流
 *
 * @package sdk\Mvc\Flow
 */
class MvcFlow extends FlowLayer implements FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var HttpRequest $request */

        $flow = Flow::instance('sdk-mvc');
        $flow->contexts =& $this->flow->contexts;
        $flow->layers = [
            'sdk\Mvc\Flow\MvcInit',        // MVC初始化

            'sdk\Mvc\Flow\ControllerInit', // 控制器初始化
            'sdk\Mvc\Flow\ControllerExec', // 控制器执行阶段

            'sdk\Mvc\Flow\ModelInit',      // 模型初始化
            'sdk\Mvc\Flow\ModelExec',      // 模型执行阶段

            'sdk\Mvc\Flow\ViewInit',       // 视图初始化
            'sdk\Mvc\Flow\ViewRender',     // 视图渲染阶段
        ];
        $flow->start();
    }
}
