<?php
/**
 * MicroTask Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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
namespace MicroFrame\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

use Closure;
use MicroFrame\Handlers\CacheSource;
use MicroFrame\Handlers\Logger;
use MicroFrame\Interfaces\ICache;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Library\Config;
use MicroFrame\Library\Strings;

/**
 * MicroTask class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class MicroTask
{
    /**
     * Timeout value in seconds for a task
     *
     * @var int
     */
    public $timeout;

    /**
     * Specified task custom name.
     *
     * @var string
     */
    public $name;

    /**
     * Task periodic execution.
     *
     * @var int
     */
    public $count;

    /**
     * Minimum CPU load for task.
     *
     * @var int
     */
    public $minLoad;

    /**
     * Maximum CPU load for task.
     *
     * @var int
     */
    public $maxLoad;

    /**
     * Get config by dot notation.
     *
     * @param string $name Name of config to retrieve.
     *
     * @comment Config retrieval.
     *
     * @return array|mixed|null
     */
    protected function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * An in-class logger method, for much easier usage.
     *
     * @param $text string here
     * @param $type string here
     *
     * @return void
     */
    protected function log($text, $type)
    {
        $instance = Logger::set($text);
        switch ($type) {
        case 'info':
            $instance->info();
            break;
        case 'warn':
            $instance->warn();
            break;
        case 'error':
            $instance->error();
            break;
        case 'debug':
            $instance->debug();
            break;
        default:
            $instance->fatal();
            break;
        }
    }

    /**
     * New method
     *
     * @summary pending
     *
     * @return void
     */
    protected function setup()
    {
    }

    /**
     * New method
     *
     * @summary pending
     *
     * @return void
     */
    protected function getConfig()
    {
    }

    /**
     * New method
     *
     * @summary pending
     *
     * @return void
     */
    protected function add()
    {
    }

    /**
     * Use closure for method capture
     * TODO: Change for async task properties without awaiting.
     *
     * @param $closure closure here
     * @param $args    array here
     *
     * @return void;
     */
    private function _loop($closure, $args = [])
    {
        foreach ($args as $arg) {
            $closure($arg);
        }
    }

    /**
     * Model static instance initializer.
     *
     * @param null $source here
     *
     * @return Model|IModel
     */
    protected function model($source =  null) : IModel
    {
        if (is_null($source)) {
            return new Model();
        }
        return new Model($source);
    }

    /**
     * Initializes a cache instance.
     *
     * @param string $source here
     *
     * @return ICache|object
     */
    protected function cache($source = 'default') : ICache
    {
        return CacheSource::init($source);
    }

    /**
     * Initializes a string instance.
     *
     * @param string $source here
     *
     * @return mixed|void
     */
    protected function string($source = '') : Strings
    {
        return Strings::filter($source);
    }

    /**
     * New method
     *
     * @summary pending
     *
     * @return void
     */
    protected function loader()
    {
        // TODO: Implement loader() method.
    }
}
