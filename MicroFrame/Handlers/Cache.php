<?php
/**
 * Cache Handler class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;

use MicroFrame\Library\Config;
use ReflectionClass;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class Cache
 * @package MicroFrame\Handlers
 */
class Cache
{

    private $instance;
    /**
     * Init based on \MicroFrame\Handlers\** reflected classes.
     * @param string $source
     * @throws \Exception
     */
    public function __construct($source = "default") {
        /**
         * Retrieves requested cache config.
         */
        $cacheType = Config::fetch('cache.' . $source . '.type');
        $cacheType = ucfirst($cacheType);

        /**
         * Reflected class instance.
         */
        $path = 'MicroFrame\\Handlers\\Cache\\' . $cacheType . 'Cache';

        /**
         * Instance arguments.
         */
        $args = array($source);

        if (class_exists($path)) {
            $classBuilder = null;
            try {
                $classBuilder = new ReflectionClass($path);
            } catch (\ReflectionException $e) {
                Logger::set($e->getMessage())->error();
            }
            /** @var ReflectionClass $classBuilder */

            $this->instance = !is_null($classBuilder) ? $classBuilder->newInstanceArgs($args) : null;
        } else {
            throw new Exception('Requested Cache type does not exist, please \\n create class' . $path);
        }

    }

    public static function  get($source = "default") {
        $instance = null;
        try {
            $instance = new self($source);
        } catch (\Exception $e) {
            Logger::set($e->getMessage())->error();
        }

        return !is_null($instance) ? $instance->instance : null;
    }

}