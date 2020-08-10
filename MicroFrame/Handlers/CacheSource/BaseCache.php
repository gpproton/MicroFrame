<?php
/**
 * Base CacheSource Handler class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers\CacheSource
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


namespace MicroFrame\Handlers\CacheSource;

use MicroFrame\Handlers\Exception;
use MicroFrame\Interfaces\ICache;
use MicroFrame\Library\Config;
use PDO;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class BaseCache
 * @package MicroFrame\Handlers\CacheSource
 */
abstract class BaseCache implements ICache
{

    protected $instance;

    /**
     * CacheSource constructor.
     * @param string $source
     */
    public function __construct($source = "default") {
        $this->instance = $this->init($source);

        return $this;
    }

    /**
     *
     * A central initialization point, for any type of datasource.
     *
     * @param $source
     * @return mixed|null
     */
    protected function init($source) {
        /**
         * Send null if initialization fails.
         */

        try {
            return null;
        } catch (\Exception $e) {
            Exception::init()->output($e);

            return null;
        }
    }

    /**
     * Retrieve configuration values.
     *
     * @param $name
     * @return mixed|void
     */
    public function config($name)
    {
        return Config::fetch('cacheSource.' . $name);
    }

    /**
     * @param $key
     * @return mixed|void
     */
    function get($key) {

    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    function set($key, $value, $expiry = 0) {

    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    function push($key, $value, $expiry = 0) {

    }

    /**
     * @param $key
     * @return mixed|void
     */
    function pop($key) {

    }

    /**
     * @param $key
     * @param $count
     * @return mixed|void
     */
    function all($key, $count) {

    }

    /**
     * @param $key
     * @param int $count
     * @return mixed|void
     */
    public function clear($key, $count = 1)
    {
        // TODO: Implement clear() method.
    }
}