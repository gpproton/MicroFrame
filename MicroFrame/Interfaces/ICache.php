<?php
/**
 * App Cache interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

use MicroFrame\Handlers\Exception;
use Phpfastcache\Exceptions\PhpfastcacheSimpleCacheException;
use Psr\Cache\InvalidArgumentException;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * ICache Interface
 *
 * @category Interface
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
interface ICache extends ICore
{

    /**
     * Retrieve configuration to a cache instance
     *
     * @param string $name here
     *
     * @return mixed
     */
    public function config($name);

    /**
     * Get value for single item.
     *
     * @param string $key here
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function get($key);

    /**
     * Set value for single item.
     *
     * @param string                $key    here
     * @param string|array|int|null $value  here
     * @param int                   $expiry here
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function set($key, $value, $expiry = 900);

    /**
     * Push items to back of array
     *
     * @param string                $key    here
     * @param string|array|int|null $value  here
     * @param int                   $expiry here
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function push($key, $value, $expiry = 1);

    /**
     * Remove the front items in array.
     *
     * @param string $key    here
     * @param int    $count  number of items to pop.
     * @param int    $expiry here
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function pop($key, int $count = 1, $expiry = 1);

    /**
     * Returns all queue items by the requested count or all.
     *
     * @param string $key   here
     * @param int    $count number of items to retrieve.
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function all($key, $count);

    /**
     * Clears all entered keys.
     *
     * @return mixed|void|boolean
     *
     * @throws PhpfastcacheSimpleCacheException
     */
    public function clear();

    /**
     * Delete requested key completely.
     *
     * @param string $key here
     *
     * @return mixed|void|boolean
     *
     * @throws Exception
     * @throws PhpfastcacheSimpleCacheException
     */
    public function delete($key);

    /**
     * An array of keys to return.
     *
     * @param array $keys    here
     * @param null  $default here
     *
     * @return mixed|void|array
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function getMultiple($keys, $default = null);

    /**
     * A key value save of multiple keys.
     *
     * @param array $values A key value array store.
     * @param int   $expiry expiry in seconds
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws PhpfastcacheSimpleCacheException
     */
    public function setMultiple($values, $expiry = 900);

    /**
     * Delete multiple keys.
     *
     * @param array $keys here
     *
     * @return mixed|void
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws PhpfastcacheSimpleCacheException
     */
    public function deleteMultiple($keys);

    /**
     * Check if a key exist.
     *
     * @param string $key here
     *
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheSimpleCacheException
     */
    public function has($key);
}
