<?php

/**
 * Base CacheSource Handler class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers\CacheSource
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
use Phpfastcache\Exceptions\PhpfastcacheSimpleCacheException;
use Phpfastcache\Helper\Psr16Adapter;
use Psr\Cache\InvalidArgumentException;

use function array_splice;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * BaseCache Class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers\CacheSource
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
abstract class BaseCache implements ICache
{
    /**
     * An instance of cache class
     *
     * @var ICache
     */
    protected $instance;

    /**
     * An array or string of the requested configuration.
     *
     * @var array|string
     */
    protected $config;

    /**
     * A string for requesting for specific cache config.
     *
     * @var string
     */
    protected $source;

    /**
     * CacheSource constructor.
     *
     * @param string $source cache source.
     *
     * @return void|self
     */
    public function __construct($source = "default")
    {
        $this->source = $source;
        $this->instance = $this->init($source);

        return $this;
    }

    /**
     * A central initialization point, for any type of datasource.
     *
     * @param string $source Cache source to pass to constructor.
     *
     * @return mixed|null
     */
    abstract public function init($source): Psr16Adapter;

    /**
     * Retrieve configuration values.
     *
     * @param string $name name of configuration to retrieve.
     *
     * @return mixed|void
     */
    public function config($name)
    {
        return Config::fetch('cacheSource.' . $name);
    }

    /**
     * Prepend configured prefix on requested keys.
     *
     * @param string $key here
     *
     * @return string|array
     *
     * @throws Exception
     */
    private function _setPrefix($key)
    {
        $prefix = isset($this->config($this->source)['prefix'])
            ? $this->config($this->source)['prefix'] : 'mf_';
        if (gettype($key) === 'string') {
            return $prefix . $key;
        } elseif (gettype($key) === 'array') {
            for ($x = 0; $x < sizeof($key); $x++) {
                $key[$x] = $prefix . $key[$x];
            }
            return $key;
        }

        throw new Exception(gettype($key) . ' is not a valid type for a key.');
    }

    /**
     * Initialize path for caching items.
     *
     * @param string $source Root path for cache to initialize.
     *
     * @return array|mixed|string|null
     */
    protected function pathInit($source = 'default')
    {
        $cachePath = Config::fetch('system.path.cache');
        if (!is_dir($cachePath)) {
            $cachePath .= DATA_PATH . "/{$cachePath}";
        }
        $cachePath .= "/{$source}";

        return $cachePath;
    }

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
    public function get($key)
    {
        $key = $this->_setPrefix($key);

        return $this->instance->get($key);
    }

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
    public function set($key, $value, $expiry = 900)
    {
        $key = $this->_setPrefix($key);

        return $this->instance->set($key, $value, $expiry);
    }

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
    public function push($key, $value, $expiry = 1)
    {
        $key = $this->_setPrefix($key) . '_queue';
        $expiry = (60 * 60 * 24) * $expiry;
        $oldValues = $this->instance->get($key);

        if ($oldValues === null && gettype($value) !== 'array') {
            return $this->instance->set($key, [$value], $expiry);
        } elseif ($oldValues === null && gettype($value) === 'array') {
            return $this->instance->set($key, $value, $expiry);
        } else {
            /**
             * Filter excess items in queue.
             */
            $maxListConfig = $this->config($this->source . '.maxQueue');
            if (
                gettype($oldValues) === 'array'
                && sizeof($oldValues) >= $maxListConfig
            ) {
                array_splice(
                    $oldValues,
                    0,
                    (sizeof($oldValues) - $maxListConfig) - 1
                );
            }

            if (gettype($value) === 'array') {
                foreach ($value as $item) {
                    $oldValues[] = $item;
                }
            } else {
                $oldValues[] = $value;
            }
        }

        return $this->instance->set($key, $oldValues, $expiry);
    }

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
    public function pop($key, int $count = 1, $expiry = 1)
    {
        $key = $this->_setPrefix($key) . '_queue';
        $expiry = (60 * 60 * 24) * $expiry;
        $oldValues = $this->instance->get($key);

        $newValues = array();
        if ($oldValues === null || sizeof($oldValues) === 0) {
            return null;
        } else {
            if ($count >= 1) {
                foreach (range(0, $count - 1) as $position) {
                    $newValues[] = $oldValues[0];
                    array_splice($oldValues, 0, 1);
                }
            } else {
                $newValues[] = $oldValues[0];
                array_splice($oldValues, 0, 1);
            }

            /**
             * Filter excess items in queue.
             */
            $maxListConfig = $this->config($this->source . '.maxQueue');
            if (sizeof($oldValues) >= $maxListConfig) {
                array_splice(
                    $oldValues,
                    0,
                    (sizeof($oldValues) - $maxListConfig) - 1
                );
            }
        }

        return $this->instance->set($key, $oldValues, $expiry) ? $newValues : null;
    }

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
    public function all($key, $count = 100)
    {
        $key = $this->_setPrefix($key) . '_queue';
        $item = $this->instance->get($key);
        if (sizeof($count) >= 1) {
            array_slice($item, 0, $count);
        }
        return $item;
    }

    /**
     * Clears all entered keys.
     *
     * @return mixed|void|boolean
     *
     * @throws PhpfastcacheSimpleCacheException
     */
    public function clear()
    {
        return $this->instance->clear();
    }

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
    public function delete($key)
    {
        $key = $this->_setPrefix($key);
        return $this->instance->delete($key);
    }

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
    public function getMultiple($keys, $default = null)
    {
        if (gettype($keys) === 'array') {
            $keys = $this->_setPrefix($keys);

            return $this->instance->getMultiple($keys);
        }

        return null;
    }

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
    public function setMultiple($values, $expiry = 900)
    {
        if (gettype($values) === 'array') {
            foreach ($values as $key => $value) {
                $values[$this->_setPrefix($key)] = $value;
                unset($values[$key]);
            }

            return $this->instance->setMultiple($values);
        }

        return false;
    }

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
    public function deleteMultiple($keys = [])
    {
        if (gettype($keys) === 'array' && sizeof($keys) >= 1) {
            $keys = $this->_setPrefix($keys);

            return $this->instance->deleteMultiple($keys);
        }

        return false;
    }

    /**
     * Check if a key exist.
     *
     * @param string $key here
     *
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheSimpleCacheException
     */
    public function has($key)
    {
        if (gettype($key) === 'string') {
            $key = $this->_setPrefix($key);

            return $this->instance->has($key);
        }

        return false;
    }
}
