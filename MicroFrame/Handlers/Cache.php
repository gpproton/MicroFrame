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

use MicroFrame\Interfaces\ICache;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class Cache
 * @package MicroFrame\Handlers
 */
class Cache implements ICache
{

    /**
     * Cache constructor.
     * @param string $string
     * @param bool $cache
     */
    public function __construct($string = "default", $cache = false) {

    }
    /**
     * @inheritDoc
     */
    public function config($name)
    {
        // TODO: Implement config() method.
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * @inheritDoc
     */
    public function push($key, $value)
    {
        // TODO: Implement push() method.
    }

    /**
     * @inheritDoc
     */
    public function pop($key)
    {
        // TODO: Implement pop() method.
    }

    /**
     * @inheritDoc
     */
    public function all($key, $count)
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function clear($key)
    {
        // TODO: Implement clear() method.
    }
}