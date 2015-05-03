<?php

namespace sdk\Http\Exception;

class Http413Exception extends HttpException
{

    /**
     * @var   integer    HTTP 413 Request Entity Too Large
     */
    protected $_code = 413;

}
