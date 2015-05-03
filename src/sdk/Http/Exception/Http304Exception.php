<?php

namespace sdk\Http\Exception;

class Http304Exception extends ExpectedException
{

    /**
     * @var   integer    HTTP 304 Not Modified
     */
    protected $_code = 304;

}
