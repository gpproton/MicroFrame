<?php
/**
 * Route Handlers class
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

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Default resource references
 */
use MicroFrame\Core\Request;
use MicroFrame\Core\Response;
use MicroFrame\Helpers\Reflect;
use MicroFrame\Defaults\Middleware\DefaultMiddleware;
use MicroFrame\Helpers\Strings;

/**
 * Class Route
 * @package MicroFrame\Handlers
 */
class Route
{

    private $request;
    private $response;
    private $proceed;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->proceed = false;
    }

    /**
     * @return Route
     */
    public static function set() {
        return new self();
    }

    /**
     * @param $path
     * @param string $type
     * @param bool $check
     * @param null $response
     * @param null $request
     * @return mixed
     */
    private function initialize($path, $type = "app.Controller", $check = true, $response = null, $request = null) {
        if ($check) return Reflect::check()->stateLoader($type, $path, $check);
        Reflect::check()->stateLoader($type, $path, array($response, $request))
            /**
             * Default middleware left here just for extra capability.
             */
            ->middleware(new DefaultMiddleware)
            ->start();
    }

    /**
     * @param string $path
     * @param array $methods
     * @param string $functions
     * @param array $middleware
     * @param int $status
     * @return void
     */
    public static function map($path = "index", $methods = array('get'), $functions = "Default", $middleware = array(), $status = 200) {

        $clazz = new self();

        $wildCard  = Strings::filter($path)->contains("*");

        /**
         * Path filtering for illegal chars.
         */
        // TODO: handle filesystem path first
        $path = Strings::filter($path)
            ->replace("/", ".")
            ->replace("\\", ".")
            ->replace(" ", "")
            ->replace("-", ".")
            ->replace("_", ".")
            ->range("*", false, true)
            ->leftTrim()
            ->rightTrim()
            ->leftTrim(".")
            ->rightTrim(".")
            ->value();

        if ($wildCard && Strings::filter($clazz->request->path())->contains($path)) {
            $clazz->proceed = true;
        } else if ($path === $clazz->request->path()) {
            $clazz->proceed = true;
        }


        if ($clazz->proceed) {

            // TODO: First check if $path class or method exist, and it's matches with request path.
            // initialize($path, $type = "app.Controller", $check = true, $response = null, $request = null)

            $clazz->response->status($status);
            $clazz->response->methods($methods);

            foreach ($middleware as $middleKey) {
                $clazz->response->middleware($middleKey);
            }

            if (gettype($functions) === 'closure') {
                $clazz->response->data($functions());
            } else if ($clazz->initialize($functions)) {
                $clazz->initialize($path, "app.Controller", false, $clazz->response, $clazz->request);
            }

            $clazz->response->data($functions);
            ob_clean();
        }

    }

    /**
     *
     * @param string $path
     */
    public function boot($path = null)
    {
        if (is_null($path)) $path = $this->request->path();
        /**
         * Call Index if route is not set.
         */
        if (empty($path) && $this->initialize("index")) {
            $this->initialize("index", "app.Controller", false, $this->response, $this->request);
        }
        /**
         * Try calling specified route if the controller exist.
         */
        else if ($this->initialize($path)) {
            $this->initialize($path, "app.Controller", false, $this->response, $this->request);
        }
        /**
         * Call default controller if all fail.
         */
        else {
            $this->initialize("default", "sys.Controller", false, $this->response, $this->request);
        }
    }

}


