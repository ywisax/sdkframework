<?php

namespace sdk\Http\Request\Client;

use Exception;
use sdk\Base\Helper\Arr;
use sdk\Base\Sdk;
use sdk\Http\HttpResponse;
use sdk\Http\HttpRequest;
use sdk\Http\Request\Exception\RequestException;
use sdk\Http\Request\RequestClient;

/**
 * [Request_Client_External] provides a wrapper for all external request
 * processing. This class should be extended by all drivers handling external
 * requests.
 * Supported out of the box:
 *  - Curl (default)
 *  - PECL HTTP
 *  - Streams
 * To select a specific external driver to use as the default driver, set the
 * following property within the Application bootstrap. Alternatively, the
 * client can be injected into the request object.
 *
 * @example
 *             // In application bootstrap
 *             Request_Client_External::$client = 'Request_Client_Stream';
 *             // Add client to request
 *             $request = Request::factory('http://some.host.tld/foo/bar')
 *             ->client(Request_Client_External::factory('Request_Client_HTTP));
 * @package    Sdk
 * @category   Base
 * @author     YwiSax
 */
abstract class ExternalClient extends RequestClient
{

    /**
     * Use:
     *  - CurlClient (default)
     *  - HttpClient
     *  - StreamClient
     *
     * @var     string    defines the external client to use by default
     */
    public static $client = 'sdk\Http\Request\Client\CurlClient';

    /**
     * Factory method to create a new ExternalClient object based on
     * the client name passed, or defaulting to ExternalClient::$client
     * by default.
     * ExternalClient::$client can be set in the application bootstrap.
     *
     * @param   array  $params parameters to pass to the client
     * @param   string $client external client to use
     *
     * @return  ExternalClient
     * @throws  RequestException
     */
    public static function factory(array $params = [], $client = null)
    {
        if (null === $client)
        {
            $client = ExternalClient::$client;
        }

        $client = new $client($params);

        if ( ! $client instanceof ExternalClient)
        {
            throw new RequestException('Selected client is not a ExternalClient object.');
        }

        return $client;
    }

    /**
     * @var     array     curl options
     * @link    http://www.php.net/manual/function.curl-setopt
     * @link    http://www.php.net/manual/http.request.options
     */
    protected $_options = [];

    /**
     * Processes the request, executing the controller action that handles this
     * request, determined by the [Route].
     * 1. Before the controller action is called, the [Controller::before] method
     * will be called.
     * 2. Next the controller action will be called.
     * 3. After the controller action is called, the [Controller::after] method
     * will be called.
     * By default, the output from the controller is captured and returned, and
     * no headers are sent.
     *     $request->execute();
     *
     * @param   HttpRequest  $request  A request object
     * @param   HttpResponse $response A response object
     *
     * @return  HttpResponse
     * @throws  Exception
     */
    public function executeRequest(HttpRequest $request, HttpResponse $response)
    {
        // Store the current active request and replace current with new request
        $previous = HttpRequest::$current;
        HttpRequest::$current = $request;

        // Resolve the POST fields
        if ($post = $request->post())
        {
            $request->body = http_build_query($post, null, '&');
            $request->headers('content-type', 'application/x-www-form-urlencoded; charset=' . Sdk::$charset);
        }
        if (Sdk::$expose)
        {
            $request->headers('user-agent', Sdk::version());
        }
        try
        {
            $response = $this->_sendMessage($request, $response);
        }
        catch (Exception $e)
        {
            // Restore the previous request
            HttpRequest::$current = $previous;
            throw $e;
        }

        // Restore the previous request
        HttpRequest::$current = $previous;

        // Return the response
        return $response;
    }

    /**
     * Set and get options for this request.
     *
     * @param   mixed $key   Option name, or array of options
     * @param   mixed $value Option value
     *
     * @return  mixed
     * @return  $this
     */
    public function options($key = null, $value = null)
    {
        if (null === $key)
        {
            return $this->_options;
        }

        if (is_array($key))
        {
            $this->_options = $key;
        }
        elseif (null === $value)
        {
            return Arr::get($this->_options, $key);
        }
        else
        {
            $this->_options[$key] = $value;
        }

        return $this;
    }

    /**
     * Sends the HTTP message [Request] to a remote server and processes
     * the response.
     *
     * @param   HttpRequest  $request  Request to send
     * @param   HttpResponse $response Response to send
     *
     * @return  HttpResponse
     */
    abstract protected function _sendMessage(HttpRequest $request, HttpResponse $response);

}
