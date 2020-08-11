<?php
/**
 * MicroTask Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;

defined('BASE_PATH') OR exit('No direct script access allowed');

use \AsyncPHP\Doorman\Task;
use \AsyncPHP\Doorman\Manager\ProcessManager;
use \AsyncPHP\Doorman\Rule\InMemoryRule;
use \AsyncPHP\Doorman\Task\ProcessCallbackTask;
use MicroFrame\Handlers\CacheSource;
use MicroFrame\Handlers\Logger;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Library\Config;
use MicroFrame\Library\Strings;

/**
 * Class MicroTask
 * @package MicroFrame\Core
 */
class MicroTask
{

    public $timeout;
    public $name;
    public $count;
    public $minLoad;
    public $maxLoad;

    /**
     * @param $name
     * @return array|mixed|null
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * An in-class logger method, for much easier usage.
     *
     * @param $text
     * @param $type
     */
    protected function log($text, $type) {
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
     *
     */
    public function setup() {

    }

    /**
     *
     */
    public function getConfig() {

    }

    /**
     *
     */
    public function add() {

    }

    /**
     * Use closure for method capture
     *
     * @param $closure
     * @param $args
     */
    public function loop($closure, $args = []) {
        foreach ($args as $arg) {
            $closure($arg);
        }
    }

    /**
     *
     * Model static instance initializer.
     *
     * @param null $source
     * @return Model|IModel
     */
    public function model($source =  null) {
        if (is_null($source)) return new Model();
        return new Model($source);
    }

    /**
     * Initializes a cache instance.
     *
     * @param string $source
     * @return object
     */
    public function cache($source = 'default')
    {
        return CacheSource::init($source);
    }

    /**
     * Initializes a string instance.
     *
     * @param string $source
     * @return mixed|void
     */
    public function string($source = '')
    {
        return Strings::filter($source);
    }

    /**
     *
     */
    public function loader()
    {
        // TODO: Implement loader() method.
    }

}