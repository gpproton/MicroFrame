<?php
/**
 * Request Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/microframe
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Library\Strings;
use MicroFrame\Library\Utils;
use MicroFrame\Interfaces\IRequest;

/**
 * Request class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Request extends Core implements IRequest
{
    /**
     * An internal array of cookies.
     *
     * @var array
     */
    private static $_cookie = [];

    /**
     * An internal array of environmental variables.
     *
     * @var array
     */
    private static $_env = [];

    /**
     * Sent files over request.
     *
     * @var array
     */
    private static $_files = [];

    /**
     * HTTP queries key value array.
     *
     * @var array
     */
    private static $_get = [];

    /**
     * An internal array of received post data.
     *
     * @var array
     */
    private static $_post = [];

    /**
     * An internal array of all server request.
     *
     * @var array
     */
    private static $_request = [];

    /**
     * More server requested content.
     *
     * @var array
     */
    private static $_server = [];

    /**
     * An internal array of session.
     *
     * @var array
     */
    private static $_session = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get instance of the class
     *
     * @return Request
     */
    public static function get()
    {
        return new self();
    }


    /**
     * Get request method type in plain string
     *
     * @return mixed
     */
    public function method()
    {
        if (!empty(self::$_server['REQUEST_METHOD'])) {
            return strtolower(self::$_server['REQUEST_METHOD']);
        }
        return null;
    }

    /**
     * Retrieve requested format information.
     *
     * @return string
     */
    public function format()
    {
        $check = !empty($this->query('format')) ?
            $this->query('format') : $this->header('accept');
        return !empty($check) ? $check : $this->query('accept');
    }

    /**
     * Get all request variable values
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->query(), $this->post());
    }


    /**
     * Get all query parameters
     *
     * @param null $string   filter for desired get value
     * @param bool $multiple option for return an array
     *
     * @return array|mixed|null
     */
    public function query($string = null, $multiple = false)
    {
        $query = array();
        if (!empty(self::$_server['QUERY_STRING'])) {
            $query  = explode('&', self::$_server['QUERY_STRING']);
        }
        if (count($query) > 0 && !empty($query[0])) {
            $params = array();
            $finalParams = null;
            foreach ($query as $param) {
                // TODO: Find solution for empty query string.
                // prevent notice on explode() if $param has no '='
                if (strpos($param, '=') === false) {
                    $param += '=';
                }
                list($name, $value) = explode('=', $param, 2);
                $params[urldecode($name)][] = urldecode($value);
            }
            if (is_null($string) && !$multiple) {
                return $params;
            } elseif (!is_null($string) && $multiple) {
                $finalParams = isset($params[$string]) ? $params[$string] : null;
            } elseif (!is_null($string) && !$multiple) {
                $finalParams = isset($params[$string]) ? $params[$string][0] : null;
            } else {
                $finalParams = array();
            }
            return $finalParams;
        }
    }

    /**
     * Get posted data
     *
     * @param null $string filter for desired post value
     *
     * @return mixed|null
     */
    public function post($string = null)
    {
        $post = self::$_post;
        if (is_null($string)) {
            return $post;
        } else {
            if (isset($post[$string])) {
                return $post[$string];
            }
            return null;
        }
    }

    /**
     * Get raw data posted
     *
     * @return false|string
     */
    public function raw()
    {
        $data = file_get_contents('php://input');
        return !empty($data) ? $data : null;
    }

    /**
     * Get sent header data
     *
     * @param null $string filter for desired header value
     *
     * @return array|false|mixed|null
     */
    public function header($string = null)
    {
        if (is_null($string)) {
            $header = [];
            if (sizeof(self::$_server) === 0) {
                self::$_server = $_SERVER;
            }

            foreach (self::$_server as $serverKey => $serverValue) {
                if (strpos($serverKey, 'HTTP_') !== false) {
                    $header[strtolower(
                        str_replace(
                            'HTTP_',
                            '',
                            $serverKey
                        )
                    )] = $serverValue;
                }
            }

            return $header;
        } else {
            $header = null;
            $string = str_replace('-', '_', $string);
            if (isset(self::$_server['HTTP_' . strtoupper($string)])) {
                $header = self::$_server['HTTP_' . strtoupper($string)];
            }

            /**
             * Final header value requested.
             *
             * @var mixed $header
            */
            return $header;
        }
    }

    /**
     * Get if current session is browser.
     *
     * @return bool
     */
    public function browser()
    {
        return Strings::filter($this->header('accept'))->contains('html');
    }

    /**
     * Extra format/content type information
     *
     * @return array|false|mixed|string|null
     */
    public function contentType()
    {
        if ($this->formEncoded()) {
            return $this->format();
        }
        return !empty($this->header('content-type')) ?
            $this->header('content-type') : $this->format();
    }

    /**
     * Get all session info.
     *
     * @param null $string here
     *
     * @return mixed
     */
    public function session($string = null)
    {
        // TODO: Use session global here directly.
        if (!is_null($string)) {
            return self::$_session[$string];
        }
        return self::$_session;
    }

    /**
     * Get sent cookie info.
     *
     * @param null $string here
     *
     * @return mixed
     */
    public function cookie($string = null)
    {
        if (!is_null($string)) {
            return self::$_cookie[$string];
        }
        return self::$_cookie;
    }

    /**
     * Reference location for commonly used super globals
     *
     * @param bool $done here
     *
     * @return boolean
     */
    public static function overrideGlobals($done = true)
    {
        if ($done) {
            /**
             * For initialization and flushing defaults.
             */
            self::$_cookie = $_COOKIE;
            self::$_files = $_FILES;
            self::$_get = $_GET;
            self::$_post = $_POST;
            self::$_request = $_REQUEST;
            self::$_server = $_SERVER;

            return self::_flushGlobals();
        } else {
            /**
             * Return removed defaults.
             */
            $_COOKIE = self::$_cookie;
            $_FILES = self::$_files;
            $_GET = self::$_get;
            $_POST = self::$_post;
            $_REQUEST = self::$_request;
            $_SERVER = self::$_server;
        }
        //        self::$env = $_ENV;
        //        self::$session = $_SESSION;
    }

    /**
     * Clear original contents for commonly used globals after initialization
     *
     * @return boolean
     */
    private static function _flushGlobals()
    {
        $_COOKIE = [];
        $_FILES = [];
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_SERVER = [];
        //        $_ENV = [];
        //        $_SESSION = [];

        // TODO: Test new session initialization.
        session_start();
        return true;
    }

    /**
     * Get all request information.
     *
     * @param null $string here
     *
     * @return mixed|null
     */
    public function server($string = null)
    {
        if (is_null($string)) {
            return self::$_server;
        }
        $string = str_replace('-', '_', strtoupper($string));
        return isset(self::$_server[$string]) ? self::$_server[$string] : null;
    }

    /**
     * Start a basic auth request and retrieve entered valued.
     *
     * @param null $option here
     *
     * @return mixed|void
     */
    public function auth($option = null)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="MicroFrame basic auth"');
    }

    /**
     * Get form encoded data.
     *
     * @return bool
     */
    public function formEncoded()
    {
        return (strpos($this->header('content-type'), 'multi') !== false);
    }

    /**
     * Returns request path information with required formatting.
     *
     * @param bool $dotted here
     *
     * @return string
     */
    public function path($dotted = true)
    {
        if (!is_null($this->post('route'))) {
            $final = $this->post('route');
        } elseif (!is_null($this->query('controller'))) {
            $final = $this->query('controller');
        } elseif (!is_null($this->server("PATH_INFO"))) {
            $final = $this->server("PATH_INFO");
        } elseif (!is_null($this->query('route'))) {
            $final = $this->query('route');
        } else {
            $final = "";
        }

        return Strings::filter($final)
            ->leftTrim("/")
            ->rightTrim("/")
            ->dotted($dotted ? true : false)
            ->value();
    }

    /**
     * Get current request URL actual address
     *
     * @param bool $full here
     *
     * @return string
     */
    public function url($full = false)
    {
        $current = (isset(self::$_server['HTTPS'])
            && self::$_server['HTTPS'] === 'on' ? "https" : "http")
            . "://" . self::$_server['HTTP_HOST'] . self::$_server['REQUEST_URI'];

        if (!$full) {
            return Strings::filter($current)->range("?", false, true)->value();
        }
        return $current;
    }
}
