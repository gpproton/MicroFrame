<?php

/**
 * Core ModelQuery class
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

use MicroFrame\Library\Config;
use MicroFrame\Library\Reflect;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * ModelQuery class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class ModelQuery extends Core
{
    /**
     * A ModelQuery object instance query string.
     *
     * @var string
     */
    public $query;

    /**
     * ModelQuery constructor.
     *
     * @param string $method here
     *
     * @return self
     */
    public function __construct($method = "default")
    {
        $this->query = method_exists($this, $method)
            ? Reflect::check()->methodLoader(
                $this,
                $method,
                array()
            ) : $this->default();

        return $this;
    }

    /**
     * Retrieves configuration.
     *
     * @param string $name here
     *
     * @return mixed
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * Default model query check for if not other is specified.
     *
     * @return array
     */
    public function index()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        $sample = array();
        return array( 'query' => $query, 'sample' => $sample);
    }
}
