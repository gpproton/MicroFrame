<?php
/**
 * MinimalCache CacheSource Handler class
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
use Phpfastcache\Config\Config as cacheConfig;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class MinimalCache
 * @package MicroFrame\Handlers\CacheSource
 */
class MinimalCache extends BaseCache
{

    /**
     *
     * Initializes Sqlite instance.
     *
     * @param $source
     * @return mixed|null
     */
    public function init($source) {
        /**
         * Send null if initialization fails.
         */
        $this->config = $this->config($source);

        try {
            /**
             * Sort config differences with the minimal caches.
             */
            if ($this->config['type'] == 'sqlite') {
                CacheManager::setDefaultConfig(new cacheConfig([
                    "path" => $this->pathInit($source),
                ]));
            } elseif (strpos($this->config['type'], 'file') !== false) {
                CacheManager::setDefaultConfig(new cacheConfig([
                    "path" => $this->pathInit($source),
                    "itemDetailedDate" => false
                ]));
            }
            
            return CacheManager::getInstance(strtolower($this->config['type']));

        } catch (\Exception $e) {
            Exception::init()->log($e);
            return null;
        }
    }

}