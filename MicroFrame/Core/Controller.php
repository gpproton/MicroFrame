<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Strings helper class
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace Microframe\Core;

use MicroFrame\Interfaces\IController;
use MicroFrame\Interfaces\IMiddleware;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Interfaces\IResponse;

class Controller implements IController
{

    // TODO: Completely define all output and input methods.
    protected $config;
    protected $request;
    protected $response;
    protected $model;
    protected $middlewareState;

    public function __construct()
    {
        $this->middlewareState = true;
    }

    public function build(IResponse $response = null, IRequest $request = null, IModel $model = null)
    {
        $this->config = (object) APPLICATION_CONFIG;
        if(!is_null($response)) $this->response = $response;
        if(!is_null($request)) $this->request = $request;
        if(!is_null($model)) $this->model = $model;
        return $this;
    }

    public function middleware(IMiddleware $middleware = null)
    {
        if (!is_null($middleware)) {
            $this->middlewareState = $middleware->handle() && $this->middlewareState;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function index()
    {
        // Implement index() method from child class.
    }

    /**
     * @return void
     */
    public function start()
    {
        /** @var IController $this */
        if ($this->middlewareState && !is_null($this->response)) {
            $this->response->proceed = true;
        } else {
            $this->response->proceed = false;
        }
        $this->index();
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

}
