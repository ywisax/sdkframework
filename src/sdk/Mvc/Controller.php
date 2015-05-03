<?php

namespace sdk\Mvc;

use sdk\Base\Object;
use sdk\Http\Exception\Http404Exception;
use sdk\Http\Exception\HttpException;
use sdk\Http\HttpResponse;
use sdk\Http\HttpRequest;
use sdk\Mvc\Controller\RestInterface;

/**
 * 控制器基础类，请求流程大概为：
 *
 *     $controller = new FooController($request);
 *     $controller->before();
 *     $controller->actionBar();
 *     $controller->after();
 *
 * @property  HttpRequest   request
 * @property  HttpResponse  response
 * @property  mixed         actionResult
 * @package    Sdk
 * @category   Controller
 * @author     YwiSax
 */
abstract class Controller extends Object
{

    /**
     * @var  HttpRequest  创建控制器实例的请求
     */
    public $_request;

    /**
     * @var  HttpResponse  用于返回控制器执行结果的响应实例
     */
    public $_response;

    /**
     * @var mixed action的执行结果
     */
    public $_actionResult;

    /**
     * @var boolean 标志位，是否停止执行
     */
    public $break = false;

    /**
     * 开始处理请求
     *
     * @throws  HttpException
     * @throws  Http404Exception
     * @return  HttpResponse
     */
    public function execute()
    {
        if ( ! $this->break)
        {
            $this->executeBefore();
        }
        if ( ! $this->break)
        {
            $this->executeAction();
        }
        if ( ! $this->break)
        {
            $this->executeAfter();
        }

        // Return the response
        return $this->response;
    }

    /**
     * 执行action
     *
     * @throws HttpException
     */
    public function executeAction()
    {
        $actionSign = '';
        foreach (explode('-', $this->request->action) as $part)
        {
            $actionSign .= ucfirst($part);
        }

        $actions = [];

        if ($this instanceof Controller && $this instanceof RestInterface)
        {
            $actions[] = strtolower($this->request->method) . $actionSign;
        }

        $actions[] = 'action' . $actionSign;

        $matchAction = false;
        foreach ($actions as $action)
        {
            if (method_exists($this, $action))
            {
                $matchAction = $action;
                break;
            }
        }

        // 检查对应的方法是否存在
        if ( ! $matchAction)
        {
            throw HttpException::factory(404,
                'The requested URL :uri was not found on this server.',
                [':uri' => $this->request->uri]
            )->request($this->request);
        }

        // 保存结果
        $this->actionResult = $this->{$matchAction}();
    }

    /**
     * 执行action前的操作，可以做预备操作
     *
     * @return  void
     */
    public function before()
    {
    }

    public function executeBefore()
    {
        $this->before();
    }

    /**
     * 执行action后的操作，可以用来做收尾工作
     *
     * @return  void
     */
    public function after()
    {
    }

    public function executeAfter()
    {
        $this->after();
    }

    /**
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param HttpRequest $request
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return HttpResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param HttpResponse $response
     */
    public function setResponse($response)
    {
        $this->_response = $response;
    }

    /**
     * @return mixed
     */
    public function getActionResult()
    {
        return $this->_actionResult;
    }

    /**
     * @param mixed $actionResult
     */
    public function setActionResult($actionResult)
    {
        $this->_actionResult = $actionResult;
    }
}
