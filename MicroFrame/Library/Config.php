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

        try {
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

        } catch (\Exception $exception) {
            Exception::call($exception->getMessage())->output();
        }

        /**
         * @summary Return merged configs as abstract defaults.
         */
        return array_merge($confSys->all(), $defaults);
    }

    /**
     * @summary Initialize instance of the configuration retrieval.
     *
     * @param null $key
     * @return array|mixed|null
     */
    public static function fetch($key = null) {
        $instance = new self([]);

        try {
            $instance->validate();
        } catch (\Exception $exception) {
            Exception::call($exception->getMessage())->output();
        }

        if (is_null($key)) return $instance->all();

        return $instance->get($key);
    }

    /**
     * @summary Configuration validation...
     */
    private function validate() {

        /**
         * @summary paths validation...
         *
         */
        $paths = $this->get('system.path');
        $basePath = DATA_PATH . "/";
        if(!is_null($paths)) {

            if (is_dir($paths['logs'])) $this->set('system.path.logs', $paths['logs']); else {
                $this->set('system.path.logs', $this->dirCheck($basePath . $paths['logs']));
            }

            if (is_dir($paths['cache'])) $this->set('system.path.cache', $paths['cache']); else {
                $this->set('system.path.cache', $this->dirCheck($basePath . $paths['cache']));
            }

            if (is_dir($paths['storage'])) $this->set('system.path.storage', $paths['storage']); else {
                $this->set('system.path.storage', $this->dirCheck($basePath . $paths['storage']));
            }

        }
    }
    private function dirCheck($path) {
        if (!is_dir($path)) mkdir($path, 777, true);
        return $path;
    }

}

