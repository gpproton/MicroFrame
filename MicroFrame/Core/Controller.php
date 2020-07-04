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
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Interfaces\IResponse;

class Controller implements IController
{
    protected $config;
    protected $request;
    protected $response;
    protected $middlewareState;

    public function __construct(IResponse $response, IRequest $request)
    {
        $this->middlewareState = true;
        $this->config = (object) APPLICATION_CONFIG;
        if(!is_null($response)) $this->response = $response;
        if(!is_null($request)) $this->request = $request;
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
    public function index(IResponse $response, IRequest $request)
    {
        // Implement index() method from child class.
        $response->send();
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
        $this->index($this->response, $this->request);
    }

    public function __destruct()
    {

    }

    public static function Model($source =  null)
    {
        if (is_null($source)) return new Model();
        return new Model($source);
    }
}
