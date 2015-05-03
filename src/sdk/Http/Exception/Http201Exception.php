<?php

namespace sdk\Http\Exception;

class Http201Exception extends RedirectException
{

    /**
     * @var   integer    HTTP 201 Created
     */
    protected $_code = 201;

}
