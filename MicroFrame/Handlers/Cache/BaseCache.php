<?php
/**
 * Base Cache Handler class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers\Cache
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


namespace MicroFrame\Handlers\Cache;

use MicroFrame\Handlers\DataSource;
use MicroFrame\Handlers\Exception;
use MicroFrame\Interfaces\ICache;
use MicroFrame\Library\Config;
use PDO;
use Predis\Client as redisClient;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class BaseCache
 * @package MicroFrame\Handlers\Cache
 */
abstract class BaseCache implements ICache
{

    protected $instance;

    /**
     * Cache constructor.
     * @param string $source
     */
    public function __construct($source = "default") {
        $this->instance = $this->init($source);

        if ($this->config($source)['type'] ==  'redis') {
            $this->instance->connect();
        } elseif ($this->config($source)['type'] ==  'sqlite') {
            /**
             * Initialize any specified maintenance.
             */
        }

        return $this;
    }

    /**
     *
     * A central initialization point, for any type of datasource.
     *
     * @param $source
     * @return mixed|PDO|redisClient|null
     */
    protected function init($source) {
        /**
         * Send null if initialization fails.
         */
        try {
            return DataSource::get($source, true);
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
        return Config::fetch('cache.' . $name);
    }

    /**
     * @param $key
     * @return mixed|void
     */
    abstract function get($key);

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    abstract function set($key, $value, $expiry = 0);

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    abstract function push($key, $value, $expiry = 0);

    /**
     * @param $key
     * @return mixed|void
     */
    abstract function pop($key);

    /**
     * @param $key
     * @param $count
     * @return mixed|void
     */
    abstract function all($key, $count);

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