<?php
/**
 * Config Library class
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

use MicroFrame\Handlers\Exception;
use Noodlehaus\Config as configModule;
use Noodlehaus\AbstractConfig as configAbstractModule;

/**
 * Class Config
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
final class Config extends configAbstractModule
{

    /**
     * Get and merge all config.
     *
     * @return array
     */
    protected function getDefaults()
    {

        /**
         * Get CLI execution state and merge with config,
         */
        $defaults = array(
            'console' => php_sapi_name() === 'cli'
        );

        /**
         * Retrieve from core configuration yaml file
         */
        $confSys = configModule::load(CORE_PATH . "/config.default.yaml");
        $mimeSys = configModule::load(CORE_PATH . "/mimes.json");

        try {
            /**
             * Retrieve from all compatible file type in app config
             * directory.
             */
            $confPath = realpath('./../App/Config');
            $confApp = new configModule($confPath);
            /**
             * Merge all retrieved configurations.
             */
            $confSys->merge($confApp);
            $confSys->merge($mimeSys);
        } catch (\Exception $exception) {
            Exception::init($exception->getMessage())->output();
        }

        /**
         * Return merged configs as abstract defaults.
         */
        return array_merge($confSys->all(), $defaults);
    }

    /**
     * Initialize instance of the configuration retrieval.
     *
     * @param null $key here
     *
     * @return array|mixed|null
     */
    public static function fetch($key = null)
    {
        $instance = new self([]);

        try {
            $instance->_validate();
        } catch (\Exception $exception) {
            Exception::init($exception->getMessage())->output();
        }

        if (is_null($key)) {
            return $instance->all();
        }

        return $instance->get($key);
    }

    /**
     * Configuration  paths validation and creation...
     *
     * @return void
     */
    private function _validate()
    {
        /**
         * Paths validation...
         */
        $paths = $this->get('system.path');
        $basePath = DATA_PATH . "/";
        if (!is_null($paths)) {
            if (is_dir($paths['logs'])) {
                $this->set('system.path.logs', $paths['logs']);
            } else {
                $this->set(
                    'system.path.logs',
                    $this->_dirCheck($basePath . $paths['logs'])
                );
            }

            if (is_dir($paths['data'])) {
                $this->set('system.path.data', $paths['data']);
            } else {
                $this->set(
                    'system.path.data',
                    $this->_dirCheck($basePath . $paths['data'])
                );
            }

            if (is_dir($paths['cache'])) {
                $this->set('system.path.cache', $paths['cache']);
            } else {
                $this->set(
                    'system.path.cache',
                    $this->_dirCheck($basePath . $paths['cache'])
                );
            }

            if (is_dir($paths['storage'])) {
                $this->set('system.path.storage', $paths['storage']);
            } else {
                $this->set(
                    'system.path.storage',
                    $this->_dirCheck($basePath . $paths['storage'])
                );
            }
        }
    }

    /**
     * Assist to check and create directories.
     *
     * @param string $path here
     *
     * @return mixed
     */
    private function _dirCheck($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 777, true);
        }
        return $path;
    }
}
