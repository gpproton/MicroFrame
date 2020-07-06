<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * General Utility helper class
 *
 * PHP Version 5
 *
 * @category  Helpers
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Helpers;

use ReflectionClass;
use ReflectionException;

final class Utils {

    
    public static function local()
    {
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
            && SYS_PRODUCTION_MODE
        );
    }

    /**
     * @param $data
     */
    public static function console($data) {
        ob_start();
        print_r("\n" . $data);
        error_log(ob_get_clean(), 4);
    }

    /**
     * @param $type
     * @param $path
     * @param $args
     * @return object
     * @throws ReflectionException
     */
    public static function stateLoader($type, $path, $args = array()) {

        // TODO: Complete implementation for App | SYS view/Controller/Models/Middleware

        $path = str_replace(".", "\\", $path);
        $path = str_replace("/", "\\", $path);
        $path = str_replace("-", "\\", $path);

        switch ($type) {
            case 'SYSController':
                $path = "Microframe\Defaults\Controller\\" . $path . "Controller";
                break;
            default:
                break;
        }

        $classBuilder = new ReflectionClass($path);
        return $classBuilder->newInstanceArgs($args);
    }

    /**
     * @param $path
     * @return mixed
     */
    public static function dirChecks($path) {
        if (!is_dir($path)) mkdir($path, 777);
        return $path;
    }

}