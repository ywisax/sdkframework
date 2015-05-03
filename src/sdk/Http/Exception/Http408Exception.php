<?php

namespace sdk\Http\Exception;

class Http408Exception extends HttpException
{

    /**
     * @var   integer    HTTP 408 Request Timeout
     */
    protected $_code = 408;

}
