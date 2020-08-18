<?php
/**
 * Core Controller class
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

use Closure;
use MicroFrame\Handlers\CacheSource;
use MicroFrame\Handlers\Logger;
use MicroFrame\Interfaces\ICache;
use MicroFrame\Interfaces\IController;
use MicroFrame\Interfaces\IMiddleware;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Library\Config;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Strings;

/**
 * Controller class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
abstract class Controller implements IController
{
    /**
     * Holds an instance of IRequest.
     *
     * @var IRequest
     */
    protected $request;

    /**
     * An object instance of IResponse.
     *
     * @var IResponse
     */
    protected $response;

    /**
     * Property for the requested controller method.
     *
     * @var mixed|string
     */
    protected $method;

    /**
     * A address for one or more middleware.
     *
     * @var string|array
     */
    protected $middleware;

    /**
     * Boolean for allowing auto routing or not.
     *
     * @var bool
     */
    private $_auto;

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
    ) {
        define(
            "API_HOST",
            Config::fetch("system.debug")
            ? "localhost" : Config::fetch("site.api.host")
        );

        $this->middleware = true;
        $this->_auto = $auto;

        $this->request = $request;
        $this->response = $response;
        $this->method = $method;

        return $this;
    }

    /**
     * Used for configuration retrieval
     *
     * @param string $name here
     *
     * @return array|mixed|null
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * Used to call a middleware.
     *
     * @param IMiddleware|null $middleware here
     *
     * @return $this|mixed
     */
    public function middleware(IMiddleware $middleware = null)
    {
        if (!is_null($middleware)) {
            $this->middleware = $middleware->handle() && $this->middleware;
        }
        return $this;
    }

    /**
     * Index/Default controller method
     *
     * @return void
     */
    protected function index()
    {
        /**
         * Implement index method from children class if required.
         */
        $defaultTest = 'Requested resource requires extension..';
        if ($this->request->browser()) {
            $this->response
                ->data(
                    [
                        'errorText' => $defaultTest,
                        'errorTitle' => 'New resource',
                        'errorImage' => 'images/vector/build.svg',
                        'errorColor' => 'dodgerblue',
                        'showReturn' => false
                    ]
                )
                ->render('sys.Default');
        } else {
            $this->response
                ->data([$defaultTest])
                ->send();
        }
    }

    /**
     * Set option for page to auto route
     *
     * @param bool $state here
     *
     * @return mixed|void
     */
    protected function auto($state = true)
    {
        if (!$state && gettype($this->_auto) === 'boolean') {
            $this->response->notFound();
        }
    }

    /**
     * An in-class logger method, for much easier usage.
     *
     * @param string $text here
     * @param string $type here
     *
     * @return void
     */
    protected function log($text, $type)
    {
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
     * Model static instance initializer.
     *
     * @param null $source here
     *
     * @return Model|IModel
     */
    protected function model($source =  null) : IModel
    {
        if (is_null($source)) {
            return new Model();
        }
        return new Model($source);
    }

    /**
     * Initializes a cache instance.
     *
     * @param string $source here
     *
     * @return ICache|object
     */
    protected function cache($source = 'default') : ICache
    {
        return CacheSource::init($source);
    }

    /**
     * Initializes a string instance.
     *
     * @param string $source here
     *
     * @return mixed|void
     */
    protected function string($source = '') : Strings
    {
        return Strings::filter($source);
    }

    /**
     * Initializes an in process task.
     *
     * @param Closure $closure here
     * @param string  $type    here
     *
     * @return mixed|void
     */
    protected function await($closure, $type = 'current')
    {
        // TODO: Implement await() method.
    }

    /**
     * Run controller instance
     *
     * @return void
     */
    public function start()
    {
        if ($this->middleware && !is_null($this->response)) {
            $this->response->setProceed(true);
        } else {
            $this->response->setProceed(true);
        }

        if (empty($this->method)) {
            $this->index();
        } else {

            /**
             * String based method call.
             */
            $methodName = strtolower($this->method);

            if (method_exists($this, $methodName)) {
                ob_start();
                Reflect::check()->methodLoader($this, $methodName, array());
                $checkForOutput = ob_get_contents();
                ob_clean();

                if (empty($checkForOutput) || strlen($checkForOutput) >= 1) {
                    $defaultTest = 'Please Implement a standard response...';
                    if ($this->request->browser()) {
                        $this->response
                            ->data(
                                [
                                'errorText' => $defaultTest,
                                'errorTitle' => 'New resource',
                                'errorImage' => 'images/vector/cream.svg',
                                'errorColor' => 'dodgerblue',
                                'showReturn' => false
                                ]
                            )
                            ->render('sys.Default');
                    } else {
                        $this->response
                            ->data([$defaultTest])
                            ->send();
                    }
                }
            } else {
                $this->index();
            }
            $this->index();
        }
    }
}
