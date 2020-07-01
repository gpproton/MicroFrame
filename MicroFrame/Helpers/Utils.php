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

final class Utils {

    
    public static function getLocalStatus()
    {
        $ipaddress = 'UNKNOWN';
        $keys=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');
        foreach($keys as $k)
        {
            if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP))
            {
                $ipaddress = $_SERVER[$k];
                break;
            }
        }
        return (
            ($ipaddress == '::1'
            || $ipaddress == '127.0.0.1'
            || $ipaddress == '0.0.0.0')
            && !Config::$PRODUCTION_MODE
        );
    }

    public static function errorHandler($option)
    {
        if(Utils::getLocalStatus())
        {
            echo json_encode($option);
            return false;
        }
        // TODO: Fix future redirection logic
        // Routes::RedirectQuery(Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[4]));
    }

}