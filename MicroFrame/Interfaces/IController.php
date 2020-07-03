<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * App base controller interface
 *
 * PHP Version 5
 *
 * @category  Interfaces
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

namespace MicroFrame\Interfaces;

interface IController
{

    /**
     * @param IRequest $request
     * @param IResponse $response
     * @param IModel $model
     * @return mixed
     */
    public function build(IResponse $response = null, IRequest $request = null, IModel $model = null);

    /**
     * @param IMiddleware $middleware
     * @return mixed
     */
    public function middleware(IMiddleware $middleware = null);

    /**
     * @param IResponse $response
     * @param IRequest $request
     * @param IModel|null $model
     * @return void
     */
    public function index(IResponse $response, IRequest $request = null, IModel $model = null);

    /**
     * @return mixed
     */
    public function start();

}

