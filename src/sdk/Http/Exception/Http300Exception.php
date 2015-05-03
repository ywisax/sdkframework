<?php

namespace sdk\Http\Exception;

class Http300Exception extends RedirectException
{

    /**
     * @var   integer    HTTP 300 Multiple Choices
     */
    protected $_code = 300;

}
