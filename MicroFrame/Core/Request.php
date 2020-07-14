<?php
/**
 * Request Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
 * @author    Godwin peter .O <me@godwin.dev>
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
defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Helpers\Utils;
use MicroFrame\Interfaces\IRequest;

/**
 * Class Request
 * @package MicroFrame\Core
 */
final class Request implements IRequest
{
    private static $cookie;
    private static $env;
    private static $files;
    private static $get;
    private static $post;
    private static $request;
    private static $server;
    private static $session;

    public function __construct()
    {

    }

    public static function get() {
        return new self();
    }


    /**
     * Get request method type in plain string
     * @return mixed
     */
    public function method()
    {
        if (!empty(self::$server['REQUEST_METHOD'])) return strtolower(self::$server['REQUEST_METHOD']);
        return null;
    }

    /**
     *Get all request variable values
     */
    Public function all()
    {
        return array_merge($this->query(), $this->post());
    }


    /**
     * @param null $string filter for desired get value
     * @param bool $multiple option for return an array
     * @return array|mixed|null
     */
    Public function query($string = null, $multiple = false)
    {
        $query  = explode('&', self::$server['QUERY_STRING']);
        if(count($query) > 0 && !empty($query[0]))
        {
            $params = array();
            $finalParams = null;
            foreach( $query as $param )
            {
                // prevent notice on explode() if $param has no '='
                if (strpos($param, '=') === false) $param += '=';
                list($name, $value) = explode('=', $param, 2);
                $params[urldecode($name)][] = urldecode($value);
            }
            if(is_null($string) && !$multiple) {
                return $params;
            } else if(!is_null($string) && $multiple) {
                $finalParams = isset($params[$string]) ? $params[$string] : null;
            } else if(!is_null($string) && !$multiple) {
            $finalParams = isset($params[$string]) ? $params[$string][0] : null;
            }
            else {
                $finalParams = array();
            }
            return $finalParams;
        }
    }

    /**
     * @param null $string  filter for desired post value
     * @return mixed|null
     */
    Public function post($string = null)
    {
        $post = self::$post;
        if(is_null($string)) return $post;
        else {
            if(isset($post[$string])) return $post[$string];
            return null;
        }
    }

    /**
     * @return false|string
     */
    Public function raw()
    {
        $data = file_get_contents('php://input');
        return !empty($data) ? $data : null;
    }

    /**
     * @param null $string filter for desired header value
     * @return array|false|mixed|null
     */
    Public function header($string = null)
    {
        if (empty($string)) { return getallheaders(); }
        else {
            $string = str_replace('-', '_', $string);
            $header = self::$server['HTTP_' . strtoupper($string)];
            if(is_null($header)){
                return null;
            }

            switch ($string) {
                case 'accept':
                default:
                    break;
            }
            /** @var mixed $header */
            return $header;
        }
    }

    /**
     * @return string
     */
    public function format()
    {
        return !is_null($this->query('accept')) ?
            $this->query('accept') : $this->header('accept');
    }

    /**
     * @inheritDoc
     */
    public function contentType()
    {
        if ($this->formEncoded()) return $this->format();
        return !is_null($this->query('accept')) ?
            $this->query('accept') : $this->header('content-type');
    }

    /**
     * @param null $string
     * @return mixed
     */
    Public function session($string = null)
    {
        if (!is_null($string)) return self::$session[$string];
        return self::$session;
    }

    /**
     * @param null $string
     * @return mixed
     */
    Public function cookie($string = null)
    {
        if (!is_null($string)) return self::$cookie[$string];
        return self::$cookie;
    }

    /**
     * Reference location for commonly used super globals
     *
     * @return boolean
     */
    public static function overrideGlobals()
    {
        self::$cookie = $_COOKIE;
        self::$files = $_FILES;
        self::$get = $_GET;
        self::$post = $_POST;
        self::$request = $_REQUEST;
        self::$server = $_SERVER;

//        self::$env = $_ENV;
//        self::$session = $_SESSION;

        return self::flushGlobals();
    }

    /**
     * Clear original contents for commonly used globals after initialization
     * @return boolean
     */
    private static function flushGlobals()
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
     * @param null $string
     * @return mixed|null
     */
    Public function server($string = null)
    {
        if (is_null($string)) return self::$server;
        return is_null(self::$server[$string]) ? null : self::$server[$string];
    }

    /**
     * @param null $option
     * @return mixed|void
     */
    Public function auth($option = null)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="MicroFrame basic auth"');
    }

    /**
     * @return bool
     */
    public function browser()
    {
        return (strpos($this->header('content-type'), 'image/webp') !== false);
    }

    /**
     * @return bool
     */
    public function formEncoded()
    {
        return (strpos($this->header('content-type'), 'multi') !== false);
    }

    /**
     * @return string
     */
    public function path()
    {
        $final = "";
        if (!is_null($this->post('route'))) {
            $final = $this->post('route');
        } else if (!is_null($this->query('controller'))) {
            $final = $this->query('controller');
        } else if (!is_null($this->query('route'))) {
            $final = $this->query('route');
        } else {
            $final = "";
        }
        $final = str_replace("/", ".", $final);
        return preg_replace('/[^A-Za-z.\-]/', '', $final);
    }
}
