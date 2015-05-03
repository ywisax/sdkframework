<?php

namespace sdk\Http\Exception;

class Http301Exception extends RedirectException
{

    /**
     * @var   integer    HTTP 301 Moved Permanently
     */
    protected $_code = 301;

}
