<?php

namespace sdk\Http\Exception;

class Http404Exception extends HttpException
{

    /**
     * @var   integer    HTTP 404 Not Found
     */
    protected $_code = 404;

}
