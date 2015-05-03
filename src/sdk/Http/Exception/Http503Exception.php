<?php

namespace sdk\Http\Exception;

class Http503Exception extends HttpException
{

    /**
     * @var   integer    HTTP 503 Service Unavailable
     */
    protected $_code = 503;

}
