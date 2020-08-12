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
use Phpfastcache\Core\Pool\ExtendedCacheItemPoolInterface;
use Phpfastcache\Exceptions\PhpfastcacheInvalidArgumentException;
use function array_splice;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class BaseCache
 * @package MicroFrame\Handlers\CacheSource
 */
abstract class BaseCache implements ICache
{

    protected $instance;
    protected $config;
    protected $source;

    /**
     * CacheSource constructor.
     * @param string $source
     */
    public function __construct($source = "default") {
        $this->source = $source;
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
    abstract function init($source) : ExtendedCacheItemPoolInterface;

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

    private function setPrefix($key) {
        $prefix = isset($this->config($this->source)['prefix']) ? $this->config($this->source)['prefix'] : 'mf_';
        if (gettype($key) === 'string') return $prefix . $key;
        elseif (gettype($key) === 'array') {
            for($x = 0; $x < sizeof($key); $x++) {
                $key[$x] = $prefix . $key[$x];
            }
            return $key;
        }

        throw new Exception(gettype($key) . ' is not a valid type for a key.');

    }

    /**
     * Initialize path for caching items.
     *
     * @param string $source
     * @return array|mixed|string|null
     */
    protected function pathInit($source = 'default') {
        $cachePath = Config::fetch('system.path.cache');
        if (!is_dir($cachePath)) $cachePath .= DATA_PATH . "/{$cachePath}";
        $cachePath .= "/{$source}";

        return $cachePath;
    }

    /**
     * @param $key
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheInvalidArgumentException
     */
    function get($key) {
        $key = $this->setPrefix($key);

        $item = $this->instance->getItem($key);
        return $item->get();
    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheInvalidArgumentException
     */
    function set($key, $value, $expiry = 900) {
        $key = $this->setPrefix($key);
        $item = $this->instance->getItem($key);
        $item->set($value)->expiresAfter($expiry);
        return $this->instance->save($item);
    }

    /**
     * @param $key
     * @param $value
     * @param int $expiry
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheInvalidArgumentException
     */
    function push($key, $value, $expiry = 1) {
        $key = $this->setPrefix($key);
        $item = $this->instance->getItem($key);
        $oldValues = $item->get();

        if ($oldValues === null) $item->set([$value])->expiresAfter((60 * 60 * 24) * $expiry);
        else {
            /**
             * Filter excess items in queue.
             */
            $maxListConfig = $this->config($this->source . '.maxQueue');
            if (gettype($oldValues) === 'array' && sizeof($oldValues) >= $maxListConfig) {
                array_splice($oldValues, 0, (sizeof($oldValues) - $maxListConfig) - 1);
            }

            $item->append($value);
        }

        return $this->instance->save($item);
    }

    /**
     * @param $key
     * @param int $count
     * @param int $expiry
     * @return mixed|void
     * @throws Exception
     * @throws PhpfastcacheInvalidArgumentException
     */
    function pop($key, int $count = 1, $expiry = 1) {
        $key = $this->setPrefix($key);
        $item = $this->instance->getItem($key);
        $oldValues = $item->get();
        $newValues = array();
        if ($oldValues === null || sizeof($oldValues) === 0) return null;
        else {
            if ($count >= 1) {
                foreach (range(0, $count - 1) as $position) {
                    $newValues[] = $oldValues[0];
                    array_splice($oldValues, 0, 1);
                }
            } else {
                $newValues[] = $oldValues[0];
                array_splice($oldValues, 0, 1);
            }
            $item->set($oldValues)->expiresAfter((60 * 60 * 24) * $expiry);

            /**
             * Filter excess items in queue.
             */
            $maxListConfig = $this->config($this->source . '.maxQueue');
            if (sizeof($oldValues) >= $maxListConfig) {
                array_splice($oldValues, 0, (sizeof($oldValues) - $maxListConfig) - 1);
            }
        }

        return $this->instance->save($item) ? $newValues : null;

    }

    /**
     * @param $key
     * @param $count
     * @return mixed|void
     * @throws Exception
     */
    function all($key, $count) {
        $key = $this->setPrefix($key);

    }

    /**
     * @param $key
     * @param int $count
     * @return mixed|void
     * @throws Exception
     */
    public function clear($key, $count = 1) {
        $key = $this->setPrefix($key);
        // TODO: Implement clear() method.
    }

    /**
     * @param $key
     * @return mixed|void
     * @throws Exception
     */
    public function delete($key) {
        $key = $this->setPrefix($key);
        // TODO: Implement delete() method.
    }

    /**
     * @param $keys
     * @param null $default
     * @return mixed|void
     * @throws Exception
     */
    public function getMultiple($keys, $default = null) {
        $keys = $this->setPrefix($keys);
        // TODO: Implement getMultiple() method.
    }

    /**
     * @param $values
     * @param null $ttl
     * @return mixed|void
     */
    public function setMultiple($values, $ttl = null) {
        // TODO: Implement setMultiple() method.
    }

    /**
     * @param $keys
     * @return mixed|void
     * @throws Exception
     */
    public function deleteMultiple($keys) {
        $keys = $this->setPrefix($keys);
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * @param $key
     * @return mixed|void
     * @throws Exception
     */
    public function has($key) {
        $key = $this->setPrefix($key);
        // TODO: Implement has() method.
    }
}