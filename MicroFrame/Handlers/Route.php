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

use MicroFrame\Core\Request;
use MicroFrame\Core\Response;
use MicroFrame\Helpers\Reflect;

/**
 * Default resource references
 */
use MicroFrame\Defaults\Middleware\DefaultMiddleware;
use MicroFrame\Interfaces\IMiddleware;

/**
 * Class Route
 * @package MicroFrame\Handlers
 */
class Route
{

    protected $request;
    private $response;
    public $routes = array();

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public static function set() {
        return new self();
    }

    /**
     * @param array $methods
     * @param string $path
     * @param string $functions
     * @param array $middleware
     * @param int $status
     */
    public function map($path = "index", $methods = array('get'), $functions = "Default", $middleware = array(), $status = 200) {
        $this->routes[$path]['methods'] = $methods;
        $this->routes[$path]['functions'] = $functions;
        $this->routes[$path]['middleware'] = $middleware;
        $this->routes[$path]['status'] = $status;

        // TODO: First check if $path class or method exist.
        if (false) {
            $this->route();
        }

    }

    private function route() {
        foreach ($this->routes as $route => $func) {

            $response = $this->response;
            $response->status($func['status']);
            $response->methods($func['methods']);
            foreach ($func['middleware'] as $middleKey) {
                $response->middleware($middleKey);
            }
            ob_start();
            if (gettype($func['functions']) == 'closure') $response->data($func['functions']());
            $response->data($func['functions']);
            ob_clean();

            $response->send();
        }
    }

    /**
     *
     */
    public static function Boot()
    {
        // TODO: Include conditions based on the route and request state.
        // SYSController | AppController | AppControllerFunc | AppModel | AppModelFunc | SYSView | App View | AppViewLayout | AppViewComponents
        Reflect::check()->stateLoader('SYSController', 'Default', array(new Response(), new Request()))
        ->middleware(new DefaultMiddleware)
            ->start();
    }

}


