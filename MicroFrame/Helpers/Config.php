<?php
/**
 * Config helper class
 *
 * PHP Version 7
 *
 * @category  Helpers
 * @package   MicroFrame\Helpers
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

namespace MicroFrame\Helpers;

defined('BASE_PATH') OR exit('No direct script access allowed');

use Dotenv\Dotenv as dotEnv;
use Dotenv\Exception\InvalidPathException;
use MicroFrame\Handlers\Exception;

/**
 * Class Config
 * @package MicroFrame\Helpers
 */
final class Config {

    /**
     * @summary Initialize configurations values and set to constants.
     *
     */
    public static function Load()
    {
        try {
            $dotEnv = dotEnv::createImmutable(BASE_PATH)->load();
        } catch (InvalidPathException $exception) {
            Exception::call($exception->getMessage())->output();
        }

        // TODO: Set config defaults.
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

        /**
         * @summary Configure application user space config.
         */
        define('APPLICATION_CONFIG', $AppConfig($dotEnv));

        /**
         * System configurations constants.
         */

        /**
         * @summary Application debug state.
         */
        define('SYS_DEBUG', getenv('SYS_DEBUG') === 'true');

        /**
         * @summary Application runtime check if it's console or web.
         */
        define('SYS_CONSOLE', php_sapi_name() === 'cli');

        /**
         * @summary Sets application page title.
         */
        define('SYS_APP_KEY', getenv('SYS_APP_KEY'));

        /**
         * @summary Fixed routing mode.
         */
        define('SYS_ROUTE_MODE', getenv('SYS_ROUTE_MODE'));

        /**
         * @summary Sets application page title.
         */
        define('SYS_SITE_TITLE', getenv('SYS_SITE_TITLE'));

        /**
         * @summary Selects authentication mode for application.
         */
        define('SYS_AUTH_TYPE', getenv('SYS_AUTH_TYPE'));

        /**
         * @summary Simple auth passkey.
         */
        define('SYS_PASS_KEY', getenv('SYS_PASS_KEY'));

        /**
         * @summary Authentication timeout config.
         */
        define('SYS_AUTH_TIMEOUT', getenv('SYS_AUTH_TIMEOUT'));

        /**
         * @summary Authentication session key.
         */
        define('SYS_SESSION_KEY', getenv('SYS_SESSION_KEY'));


        /**
         * Datasource and paths definition.
         */

        /**
         * @summary A JSON data source config.
         */
        define('SYS_DATA_SOURCE', self::loadJson(getenv('SYS_DATA_SOURCE')));

        /**
         * @summary A JSON data cache config.
         */
        define('SYS_DATA_CACHE', self::loadJson(getenv('SYS_DATA_CACHE')));

        /**
         * @summary Configure logger path for application.
         */
        define('SYS_LOG_PATH', Utils::dirChecks(BASE_PATH . "/" . getenv('SYS_LOG_PATH')));

        /**
         * @summary Configure file based cache path for application.
         */
        define('SYS_CACHE_PATH', Utils::dirChecks(BASE_PATH . "/" . getenv('SYS_CACHE_PATH')));

        /**
         * @summary Configure application storage path for application.
         */
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

