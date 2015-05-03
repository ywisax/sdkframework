<?php

namespace sdk\Http\Exception;

class Http400Exception extends HttpException
{

    /**
     * @var   integer    HTTP 400 Bad Request
     */
    protected $_code = 400;

}
