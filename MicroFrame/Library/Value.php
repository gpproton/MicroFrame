<?php

/**
 * Value Library class
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   MicroFrame\Library
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

namespace MicroFrame\Library;

use MicroFrame\Core\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Value Class
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Value extends Core
{
    /**
     * Value class static initializer.
     *
     * @return self|void
     */
    public static function init()
    {
        return new self();
    }

    /**
     * A method to return a specific error HTTP code.
     *
     * @param int $code here
     *
     * @return mixed
     */
    public function httpCodes($code)
    {
        $http = array(
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version Not Supported',
        );

        $selected = function ($code, $array = array()) {
            $string = $array[$code];
            return (object) array(
                "code" => $code,
                "text" => str_replace("HTTP/1.1 {$code} ", "", $string),
                "full" => $string
            );
        };

        if (isset($http[$code])) {
            return $selected($code, $http);
        }

        return $selected(500, $http);
    }

    /**
     * Returns the requested mime type.
     *
     * @param string $filename file path requested.
     *
     * @return string|null
     */
    public function mimeType($filename)
    {
        $extSortArray = explode('.', $filename);
        $ext = sizeof($extSortArray) !== 0
            ? strtolower($extSortArray[sizeof($extSortArray) - 1])
            : strtolower($extSortArray[0]);
        $extSysValue = Config::fetch('system.mimes.' . $ext);

        if ($extSysValue !== null) {
            return $extSysValue;
        } elseif (function_exists('finfo_open')) {
            $info = finfo_open(FILEINFO_MIME);
            $mimetic = finfo_file($info, $filename);
            finfo_close($info);
            return $mimetic;
        } else {
            return 'application/octet-stream';
        }
    }

    /**
     * An helper on parsing the configured root help page.
     *
     * @return string
     */
    public function assistPath()
    {
        $assistRoot = Config::fetch('site.assist') !== null
            ? Config::fetch('site.assist') : 'help/';
        return rtrim($assistRoot, '/');
    }
}
