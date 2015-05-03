<?php

namespace sdk\Base;

use sdk\Base\Flow\FlowHandlerInterface;
use sdk\Base\Flow\FlowLayer;
use sdk\Base\Helper\Url;
use sdk\Mvc\Route;

/**
 * SDK框架执行流
 *
 * @package sdk\Mvc\Flow
 */
class SdkFlow extends FlowLayer implements FlowHandlerInterface
{

    /**
     * 每个请求层，最终被调用的方法
     *
     * @return mixed
     */
    public function handle()
    {
        I18n::lang('zh-cn');

        Route::$lowerUri = true;

        Route::set('default', '(<controller>(/<action>(/<id>)))')
            ->defaults([
                'controller' => 'Site',
                'action'     => 'index',
            ]);

        $this->flow->contexts['uri'] = Url::detectUri();
    }
}
