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

// TODO: This will extend external library task class.

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
     * @summary Use closure for method capture
     *
     * @param $closure
     * @param $args
     */
    public function loop($closure, $args = []) {
        foreach ($args as $arg) {
            $closure($arg);
        }
    }

}