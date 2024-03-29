<?php

/**
 * RedisCache CacheSource Handler class
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
use Phpfastcache\Drivers\Redis\Config as redisConfig;
use Phpfastcache\Drivers\Predis\Config as pRedisConfig;
use Phpfastcache\Helper\Psr16Adapter;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * RedisCache Class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers\CacheSource
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class RedisCache extends BaseCache
{

    /**
     * Initializes redis cache instance.
     *
     * @param string $source here
     *
     * @return mixed|null|BaseCache
     */
    public function init($source): Psr16Adapter
    {
        /**
         * Send null if initialization fails.
         */
        $this->config = $this->config($source);

        try {
            $configItems = [
                'host' => isset($this->config['host'])
                    ? $this->config['host'] : '127.0.0.1',
                'port' => isset($this->config['port'])
                    ? $this->config['port'] : 6379,
                'password' => isset($this->config['password'])
                    ? $this->config['password'] : '',
                'database' => isset($this->config['database'])
                    ? $this->config['database'] : 0,
                'timeout' => isset($this->config['timeout'])
                    ? $this->config['timeout'] : 5
            ];

            if (class_exists('Redis')) {
                $instanceType = 'redis';
                $cacheConfig = new redisConfig($configItems);
            } else {
                $instanceType = 'predis';
                $cacheConfig = new pRedisConfig($configItems);
            }

            return new Psr16Adapter($instanceType, $cacheConfig);
        } catch (\Exception $e) {
            Exception::init()->log($e);

            return null;
        }
    }
}
