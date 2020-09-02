<?php
/**
 * Middleware Core class
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

use MicroFrame\Interfaces\IMiddleware;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Library\Config;

/**
 * Middleware class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Middleware extends Core implements IMiddleware
{
    /**
     * Holds an instance of IRequest.
     *
     * @var IRequest
     */
    protected $request;

    /**
     * A Model object instance.
     *
     * @var IModel
     */
    protected $model;

    /**
     * Middleware constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->model = new Model();
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
     * Returns the proceed state for a controller or response.
     *
     * @return mixed
     */
    public function handle()
    {
        return false;
    }

    /**
     * Allows for interaction with any datasource.
     *
     * @param null $source here
     *
     * @return self|IModel
     */
    public static function model($source =  null)
    {
        if (is_null($source)) {
            return new Model();
        }
        return new Model($source);
    }
}
