<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Config helper class
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

use \Dotenv\Dotenv as dotEnv;

final class Config {

    /**
     * Initialize configurations values
     */
    public static function Load()
    {
        $dotEnv = dotEnv::createImmutable(BASE_PATH)->load();

        /**
         * Auto config object builder
         * @param $array
         * @return array
         */
        $AppConfig = function ($array) {
            $newarray = array();
            foreach ($array as $key => $value) {
                if (strpos($key, 'APP_') !== false) $newarray[strtoupper($key)] = $value;
            }
            return $newarray;
        };
        define('APPLICATION_CONFIG', $AppConfig($dotEnv));

        /**
         * System configurations constants
         */

        define('SYS_PRODUCTION_MODE', getenv('SYS_PRODUCTION_MODE') === 'true');

        define('SYS_ROUTE_MODE', getenv('SYS_ROUTE_MODE'));

        define('SYS_SITE_TITLE', getenv('SYS_SITE_TITLE'));

        define('SYS_PASS_KEY', getenv('SYS_PASS_KEY'));

        define('SYS_AUTH_TYPE', getenv('SYS_AUTH_TYPE'));

        define('SYS_AUTH_TIMEOUT', getenv('SYS_AUTH_TIMEOUT'));

        define('SYS_SESSION_KEY', getenv('SYS_SESSION_KEY'));


        /**
         * Datasource and paths definition
         */
        define('SYS_DATA_SOURCE', self::loadJson(getenv('SYS_DATA_SOURCE')));

        define('SYS_DATA_CACHE', self::loadJson(getenv('SYS_DATA_CACHE')));

        define('SYS_LOG_PATH', Utils::dirChecks(BASE_PATH . "/" . getenv('SYS_LOG_PATH')));

        define('SYS_CACHE_PATH', Utils::dirChecks(BASE_PATH . "/" . getenv('SYS_CACHE_PATH')));

        define('SYS_STORAGE_PATH', Utils::dirChecks(BASE_PATH . "/" . getenv('SYS_STORAGE_PATH')));

    }

    /**
     * @param $string
     * @return mixed
     */
    private static function loadJson($string) {
        return json_decode(
            str_replace("'", "\"", $string),
            true);
    }

}

