<?php
/**
 * General Utility Library class
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   MicroFrame\Library
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

namespace MicroFrame\Library;

defined('BASE_PATH') OR exit('No direct script access allowed');

use ReflectionClass;
use ReflectionException;

/**
 * Class Utils
 * @package MicroFrame\Library
 */
final class Utils {

    private $debug;

    public static function get() {

        $instance = new self();
        $instance->debug = Config::fetch("debug");

        return $instance;
    }

    // TODO: Redefine this for more accuracy
    public function local() {
        $ipAddress = 'UNKNOWN';
        $keys=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');
        foreach($keys as $k)
        {
            if (isset($_SERVER[$k]) && !empty($_SERVER[$k])
                && filter_var($_SERVER[$k], FILTER_VALIDATE_IP))
            {
                $ipAddress = $_SERVER[$k];
                break;
            }
        }
        return (
            ($ipAddress == '::1'
            || $ipAddress == '127.0.0.1'
            || $ipAddress == '0.0.0.0')
            && $this->debug
        );
    }

    /**
     * @param $data
     */
    public function console($data) {
        ob_start();
        print_r("\n" . $data);
        error_log(ob_get_clean(), 4);
    }

    /**
     * @param $path
     * @return mixed
     */
    public function dirChecks($path) {
        if (!is_dir($path)) mkdir($path, 777, true);
        return $path;
    }

    public function injectRoutes() {
        ob_start();
        $sentValues = ob_get_contents();
        /**
         * TODO: Make more elaborate...
         */
        return require_once ( "./../App/Routes.php" );
    }

}