<?php

namespace sdk\Http\Exception;

class Http501Exception extends HttpException
{

    /**
     * @var   integer    HTTP 501 Not Implemented
     */
    protected $_code = 501;

}
