<?php
/**
 * App model interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

namespace MicroFrame\Interfaces;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Interface ICache
 * @package MicroFrame\Interfaces
 */
interface ICache
{
    /**
     * @param $name
     * @return mixed
     */
    public function config($name);

    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed
     */
    public function set($key, $value, $expiry = 0);

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed
     */
    public function push($key, $value, $expiry = 0);

    /**
     * @param $key
     * @return mixed
     */
    public function pop($key);

    /**
     * @param $key
     * @param $count
     * @return mixed
     */
    public function all($key, $count);

    /**
     * @param $key
     * @param int $count
     * @return mixed
     */
    public function clear($key, $count = 1);

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);

    /**
     * @param $keys
     * @param null $default
     * @return mixed
     */
    public function getMultiple($keys, $default = null);

    /**
     * @param $values
     * @param null $ttl
     * @return mixed
     */
    public function setMultiple($values, $ttl = null);

    /**
     * @param $keys
     * @return mixed
     */
    public function deleteMultiple($keys);

    /**
     * @param $key
     * @return mixed
     */
    public function has($key);

}