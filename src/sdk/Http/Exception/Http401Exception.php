<?php

namespace sdk\Http\Exception;

use sdk\Base\Exception\BaseException;

class Http401Exception extends ExpectedException
{

    /**
     * @var   integer    HTTP 401 Unauthorized
     */
    protected $_code = 401;

    /**
     * Specifies the WWW-Authenticate challenge.
     *
     * @param  string $challenge WWW-Authenticate challenge (eg `Basic realm="Control Panel"`)
     * @return $this
     */
    public function authenticate($challenge = null)
    {
        if (null === $challenge)
        {
            return $this->headers('www-authenticate');
        }

        $this->headers('www-authenticate', $challenge);

        return $this;
    }

    /**
     * Validate this exception contains everything needed to continue.
     *
     * @throws BaseException
     * @return bool
     */
    public function check()
    {
        if (null === $this->headers('www-authenticate'))
        {
            throw new BaseException("A 'www-authenticate' header must be specified for a HTTP 401 Unauthorized");
        }

        return true;
    }

}
