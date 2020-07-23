<?php
/**
 * Config Library class
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

use MicroFrame\Handlers\Exception;
use Noodlehaus\Config as configModule;
use Noodlehaus\AbstractConfig as configAbstractModule;

/**
 * Class Config
 * @package MicroFrame\Library
 */
final class Config extends configAbstractModule {

    /**
     * @return array
     */
    protected function getDefaults() {

        try {
            /**
             * @summary
             */
            $defaults = array(
                'console' => php_sapi_name() === 'cli'
            );

            /**
             * @summary Retrieve from core configuration yaml file
             */
            $confSys = configModule::load(CORE_PATH . "/config.default.yaml");
            /**
             * @summary Retrieve from all compatible file type in app config
             * directory.
             */
            $confPath = realpath('./../App/Config');
            $confApp = new configModule($confPath);
            /**
             * @summary Merge all retrieved configurations.
             */
            $confSys->merge($confApp);

            /**
             * Return merged configs as abstract defaults.
             */
            return array_merge($confSys->all(), $defaults);

        } catch (Exception $exception) {

            Exception::call($exception->getMessage())->output();

        }
        return [];
    }

    public static function find($key = "debug") {

    }

    /**
     * @summary Initialize configurations values and set to constants.
     *
     */
    public static function Load()
    {

        var_dump((new self(array())));
        die();
        /**
         * @summary Application debug state.
         */
        define('SYS_DEBUG', getenv('SYS_DEBUG') === 'true');

        /**
         * @summary Configure application user space config.
         */
        define('APPLICATION_CONFIG', []);


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

}

