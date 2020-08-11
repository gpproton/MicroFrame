<?php
/**
 * MemCached CacheSource Handler class
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
use Phpfastcache\CacheManager;
use Phpfastcache\Drivers\Memcached\Config as cacheConfig;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class MemCachedCache
 * @package MicroFrame\Handlers\CacheSource
 */
class MemCachedCache extends BaseCache
{

    /**
     *
     * Initializes Sqlite instance.
     *
     * @param $source
     * @return mixed|null
     */
    function init($source)
    {
        try {
            $configItems = [
                'host' => isset($this->config['host']) ? $this->config['host'] : '127.0.0.1',
                'port' => isset($this->config['port']) ? $this->config['port'] : 11211,
                'sasl_user' => isset($this->config['database']) ? $this->config['database'] : false,
                'sasl_password' => isset($this->config['password']) ? $this->config['password'] : false
            ];

            return CacheManager::getInstance(strtolower($this->config['type']), new cacheConfig($configItems));
        } catch (\Exception $e) {
            Exception::init()->log($e);

            return null;
        }
    }

}