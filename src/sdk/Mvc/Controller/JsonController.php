<?php

namespace sdk\Mvc\Controller;

use sdk\Mvc\Controller;

abstract class JsonController extends Controller
{

    public function executeAction()
    {
        // 继续执行
        parent::executeAction();

        $this->response->headers('content-type', 'application/json');
        $this->response->body = json_encode($this->actionResult);
    }

}
