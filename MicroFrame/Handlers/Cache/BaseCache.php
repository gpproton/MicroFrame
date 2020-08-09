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

use MicroFrame\Interfaces\ICache;
use MicroFrame\Library\Config;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class BaseCache
 * @package MicroFrame\Handlers\Cache
 */
abstract class BaseCache implements ICache
{

    private $instance;

    /**
     * Cache constructor.
     * @param string $source
     */
    public function __construct($source = "default") {
        $this->instance = $this->initialize($source);

        return $this;
    }

    private function initialize($source) {
        //TODO: Check datatype and initialize uniquely.
//        try {
//            return DataSource::get($source, false);
//        } catch (\Exception $e) {
//            Exception::init()->output($e);
//        }
    }

    /**
     * @param $name
     * @return mixed|void
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    public function set($key, $value, $expiry = 0)
    {
        // TODO: Implement set() method.
    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    public function push($key, $value, $expiry = 0)
    {
        // TODO: Implement push() method.
    }

    /**
     * @param $key
     * @return mixed|void
     */
    public function pop($key)
    {
        // TODO: Implement pop() method.
    }

    /**
     * @param $key
     * @param $count
     * @return mixed|void
     */
    public function all($key, $count)
    {
        // TODO: Implement all() method.
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