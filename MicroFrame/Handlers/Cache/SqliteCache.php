<?php
/**
 * SqliteCache Cache Handler class
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

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class SqliteCache
 * @package MicroFrame\Handlers\Cache
 */
class SqliteCache extends BaseCache
{

    /**
     * Get a single item by key
     *
     * @param $key
     * @return mixed|void
     */
    public function get($key)
    {

    }

    /**
     * Set a single item by key
     *
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    public function set($key, $value, $expiry = 0)
    {

    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     */
    function push($key, $value, $expiry = 0) {
        // TODO: Implement push() method.
    }

    /**
     * @param $key
     * @return mixed|void
     */
    function pop($key) {
        // TODO: Implement pop() method.
    }

    /**
     * @param $key
     * @param $count
     * @return mixed|void
     */
    function all($key, $count){
        // TODO: Implement all() method.
    }

}