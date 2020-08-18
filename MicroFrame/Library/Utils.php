<?php
/**
 * General Utility Library class
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

defined('BASE_PATH') or exit('No direct script access allowed');

use ReflectionClass;
use ReflectionException;

/**
 * Utils Class
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Utils
{
    /**
     * Property to hold debug state of application.
     *
     * @var array
     */
    private $_debug;

    /**
     * Statically returns an instance of utils.
     *
     * @return self
     */
    public static function get()
    {
        $instance = new self();
        $instance->_debug = Config::fetch("debug");

        return $instance;
    }

    /**
     * Returns state if running within local network.
     *
     * @return bool
     */
    public function local()
    {
        // TODO: Redefine this for more accuracy
        $ipAddress = 'UNKNOWN';
        $keys= [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($keys as $k) {
            if (isset($_SERVER[$k]) && !empty($_SERVER[$k])
                && filter_var(
                    $_SERVER[$k],
                    FILTER_VALIDATE_IP
                )
            ) {
                $ipAddress = $_SERVER[$k];
                break;
            }
        }
        return (
            ($ipAddress == '::1'
            || $ipAddress == '127.0.0.1'
            || $ipAddress == '0.0.0.0')
            && $this->_debug
        );
    }

    /**
     * Prints string to console.
     *
     * @param string $data String content to output.
     *
     * @return void.
     */
    public function console($data)
    {
        ob_start();
        print_r("\n" . $data);
        error_log(ob_get_clean(), 4);
    }

    /**
     * Utilzed once for route injection.
     *
     * @return string
     */
    public function injectRoutes()
    {
        ob_start();
        $sentValues = ob_get_contents();
        /**
         * TODO: Make more elaborate...
         */
        return include_once "./../App/Routes.php";
    }
}
