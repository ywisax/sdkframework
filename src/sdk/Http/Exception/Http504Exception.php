<?php

namespace sdk\Http\Exception;

class Http504Exception extends ExpectedException
{

    /**
     * @var   integer    HTTP 504 Gateway Timeout
     */
    protected $_code = 504;

}
