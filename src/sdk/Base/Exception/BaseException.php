<?php

namespace sdk\Base\Exception;

use Exception;
use sdk\Base\Debug;
use sdk\Base\Log;
use sdk\Base\Sdk;
use sdk\Http\Exception\HttpException;
use sdk\Http\HttpResponse;
use sdk\Mvc\View;

/**
 * 最基础的异常类。 Translates exceptions using the [I18n] class.
 *
 * @package    Sdk
 * @category   Exceptions
 * @author     YwiSax
 */
class BaseException extends Exception implements ExceptionInterface
{

    /**
     * @var  array  PHP error code => human readable name
     */
    public static $phpErrors = [
        E_ERROR             => 'Fatal Error',
        E_USER_ERROR        => 'User Error',
        E_PARSE             => 'Parse Error',
        E_WARNING           => 'Warning',
        E_USER_WARNING      => 'User Warning',
        E_STRICT            => 'Strict',
        E_NOTICE            => 'Notice',
        E_RECOVERABLE_ERROR => 'Recoverable Error',
        E_DEPRECATED        => 'Deprecated',
    ];

    /**
     * @var  string  error rendering view
     */
    public static $errorView = 'sdk/error';

    /**
     * @var  string  error view content type
     */
    public static $errorViewContentType = 'text/html';

    /**
     * Creates a new translated exception.
     *     throw new BaseException('Something went terrible wrong, :user',
     *         [':user' => $user]);
     *
     * @param   string         $message   error message
     * @param   array          $variables translation variables
     * @param   integer|string $code      the exception code
     * @param   Exception      $previous  Previous exception
     */
    public function __construct($message = "", array $variables = null, $code = 0, Exception $previous = null)
    {
        $message = __($message, $variables);
        parent::__construct($message, (int) $code, $previous);
        $this->code = $code;
    }

    /**
     * Magic object-to-string method.
     *     echo $exception;
     *
     * @uses    BaseException::text
     * @return  string
     */
    public function __toString()
    {
        return self::text($this);
    }

    /**
     * 异常处理器，显示出错信息
     *
     * @param   Exception $e
     *
     * @return  void
     */
    public static function handler(Exception $e)
    {
        $response = self::_handler($e);
        echo $response->sendHeaders()->body;
        exit(1);
    }

    /**
     * 记录异常日志，同时返回一个用户输出异常提示的Response对象
     *
     * @param   Exception $e
     *
     * @return  HttpResponse
     */
    public static function _handler(Exception $e)
    {
        try
        {
            // Log the exception
            self::log($e);

            // Generate the response
            $response = self::response($e);

            return $response;
        }
        catch (Exception $e)
        {
            /**
             * Things are going *really* badly for us, We now have no choice
             * but to bail. Hard.
             */
            // Clean the output buffer if one exists
            ob_get_level() && ob_clean();
            // Set the Status code to 500, and Content-Type to text/plain.
            header('Content-Type: text/plain; charset=' . Sdk::$charset, true, 500);
            echo self::text($e);
            exit(1);
        }
    }

    /**
     * 记录异常信息
     *
     * @param   Exception $e
     */
    public static function log(Exception $e)
    {
        $error = self::text($e);
        Log::error($error);
    }

    /**
     * Get a single line of text representing the exception:
     * Error [ Code ]: Message ~ File [ Line ]
     *
     * @param   Exception $e
     *
     * @return  string
     */
    public static function text(Exception $e)
    {
        return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
            get_class($e), $e->getCode(), strip_tags($e->getMessage()), Debug::path($e->getFile()), $e->getLine());
    }

    /**
     * Get a Response object representing the exception
     *
     * @uses    BaseException::text
     *
     * @param   Exception $e
     *
     * @return  HttpResponse
     */
    public static function response(Exception $e)
    {
        try
        {
            // Get the exception information
            $class = get_class($e);
            $code = $e->getCode();
            $message = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTrace();

            /**
             * HTTP_Exceptions are constructed in the HTTP_Exception::factory()
             * method. We need to remove that entry from the trace and overwrite
             * the variables from above.
             */
            if ($e instanceof HttpException && $trace[0]['function'] == 'factory')
            {
                extract(array_shift($trace));
            }


            if ($e instanceof \ErrorException)
            {
                /**
                 * If XDebug is installed, and this is a fatal error,
                 * use XDebug to generate the stack trace
                 */
                if (function_exists('xdebug_get_function_stack') && $code == E_ERROR)
                {
                    $trace = array_slice(array_reverse(xdebug_get_function_stack()), 4);

                    foreach ($trace as & $frame)
                    {
                        /**
                         * XDebug pre 2.1.1 does not currently set the call type key
                         * http://bugs.xdebug.org/view.php?id=695
                         */
                        if ( ! isset($frame['type']))
                        {
                            $frame['type'] = '??';
                        }

                        // XDebug also has a different name for the parameters array
                        if (isset($frame['params']) && ! isset($frame['args']))
                        {
                            $frame['args'] = $frame['params'];
                        }
                    }
                }

                if (isset(self::$phpErrors[$code]))
                {
                    // Use the human-readable error name
                    $code = self::$phpErrors[$code];
                }
            }

            /**
             * The stack trace becomes unmanageable inside PHPUnit.
             * The error view ends up several GB in size, taking several minutes to render.
             */
            if (defined('PHPUnit_MAIN_METHOD'))
            {
                $trace = array_slice($trace, 0, 2);
            }

            // Instantiate the error view.
            $view = View::factory(self::$errorView, get_defined_vars());

            // Prepare the response object.
            $response = HttpResponse::factory();

            // Set the response status
            $response->status = ($e instanceof HttpException) ? $e->getCode() : 500;

            // Set the response headers
            $response->headers('Content-Type', self::$errorViewContentType . '; charset=' . Sdk::$charset);

            // Set the response body
            $response->body = $view->render();
        }
        catch (Exception $e)
        {
            /**
             * Things are going badly for us, Lets try to keep things under control by
             * generating a simpler response object.
             */
            $response = HttpResponse::factory();
            $response->status = 500;
            $response->headers('Content-Type', 'text/plain');
            $response->body = self::text($e);
        }

        return $response;
    }

}
