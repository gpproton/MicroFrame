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


    protected $request;
    protected $response;
    protected $model;
    protected $middlewareState;

    protected function __construct()
    {
        $this->middlewareState = false;
    }

    public function build(IRequest $request, IResponse $response, IModel $model)
    {
        $this->request = $request;
        $this->response = $response;
        $this->model = $model;
        return;
    }

    public function middleware(IMiddleware $middleware)
    {
        $this->middlewareState = $middleware->handle() && $this->middlewareState;
    }

    public function start()
    {
        if ($this->middlewareState && isset($this->response))
        {

        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

}
