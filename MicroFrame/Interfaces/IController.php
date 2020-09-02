<?php
/**
 * Core Controller interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

namespace MicroFrame\Interfaces;

use Closure;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * IController Interface
 *
 * @category Interface
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
interface IController extends ICore
{

    /**
     * Controller constructor.
     *
     * @param IResponse $response here
     * @param IRequest  $request  here
     * @param string    $method   here
     * @param bool      $auto     here
     *
     * @return self
     */
    public function __construct(
        IResponse $response,
        IRequest $request,
        $method = "",
        $auto = true
    );

    /**
     * Used to call a middleware.
     *
     * @param IMiddleware|null $middleware here
     *
     * @return $this|mixed
     */
    public function middleware(IMiddleware $middleware = null);

    /**
     * Run controller instance
     *
     * @return void
     */
    public function start();
}
