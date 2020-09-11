<?php

/**
 * Route Handlers class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Default resource references
 */

use MicroFrame\Core\Core;
use MicroFrame\Core\Request;
use MicroFrame\Core\Response;
use MicroFrame\Defaults\Middleware\DefaultMiddleware;
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Strings;
use MicroFrame\Library\Value;

/**
 * Route class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Route extends Core
{
    /**
     * An instance of request
     *
     * @var IRequest
     */
    private $_request;

    /**
     * Response object instance.
     *
     * @var IResponse
     */
    private $_response;

    /**
     * A validation property for routes.
     *
     * @var bool
     */
    private $_proceed;

    /**
     * App controller dot root constant.
     *
     * @var string
     */
    const APP_CONTROLLER = "app.Controller.";

    /**
     * Core controller dot root constant.
     *
     * @var string
     */
    const SYS_CONTROLLER = "sys.Controller.";

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->_request = new Request();
        $this->_response = new Response();
        $this->_proceed = false;
    }

    /**
     * A static initializer.
     *
     * @return Route
     */
    public static function set()
    {
        return new self();
    }

    /**
     * Route controller resolver.
     *
     * @param string $path here
     * @param bool $check validation only boolean
     * @param null $response here
     * @param null $request here
     * @param bool $auto an assist param
     *
     * @return mixed
     */
    private function _initialize(
        string $path,
        $check = true,
        $response = null,
        $request = null,
        $auto = true
    ) {
        if ($check) {
            return Reflect::check()->stateLoader($path, $check);
        }
        $auto = !$auto ? "static" : $auto;
        Reflect::check()->stateLoader($path, array($response, $request, "", $auto))
            /**
             * Default middleware left here just for extra capability.
             */
            ->middleware(new DefaultMiddleware())
            ->start();
    }

    /**
     * Custom route mapping method for assigning to
     * controller, closure, string & paths
     *
     * @param string $path here
     * @param array $methods allowed HTTP methods
     * @param string $functions output struct
     * @param array $middleware a middleware array.
     * @param int $status status code.
     *
     * @return void
     */
    public static function map(
        $path = "index",
        $methods = array('get'),
        $functions = "index",
        $middleware = array(),
        $status = 200
    ): void {
        /**
         * Filter out unintended string output
         */
        ob_clean();

        $clazz = new self();
        $wildCard = Strings::filter($path)->contains("*");
        /**
         * Path filtering for illegal chars.
         */
        $path = Strings::filter($path)
            ->replace(["/", "\\", "-", "_", " "], [".", ".", ".", ".", ""])
            ->range("*", false, true)
            ->trim([" ", "."])
            ->value();
        $customScriptsPath = "./../App/Custom/";

        /**
         * Path validation logic
         */
        if (
            $wildCard
            && Strings::filter($clazz->_request->path())->contains($path)
        ) {
            $clazz->_proceed = true;
        } elseif ($path === $clazz->_request->path()) {
            $clazz->_proceed = true;
        } elseif (empty($path) && empty($clazz->_request->path())) {
            /**
             * Extra index check, may be redundant but for assurance.
             */
            $clazz->_proceed = true;
        }

        if ($clazz->_proceed) {
            /**
             * Handle request method mismatch
             */
            $clazz->_response->methods($methods, false, true);

            if (is_string($functions)) {
                /**
                 * Directory and script mapping
                 */
                if (
                    Strings::filter($functions)->contains("./")
                    || is_file($functions)
                ) {
                    $reqPath = $customScriptsPath .
                        Strings::filter($functions)->replace("./")->value();
                    /**
                     * Restore cleaned globals
                     */
                    Request::overrideGlobals(false);

                    if (
                        is_file($functions)
                        && Strings::filter($functions)->contains(".php")
                    ) {
                        include_once $functions;
                        die();
                    } elseif (is_dir($reqPath)) {
                        chdir($reqPath);
                        $dirContents = scandir("./");
                        if (in_array("index.html", $dirContents)) {
                            /**
                             * HTML index item inclusion.
                             */
                            echo file_get_contents("./index.html");
                        } elseif (in_array("index.php", $dirContents)) {
                            /**
                             * PHP index script inclusion.
                             */
                            include_once "index.php";
                        } else {
                            $clazz->_response->notFound();
                        }
                    } else {
                        $clazz->_response->notFound();
                    }
                    die();
                }
            }

            /**
             * Firstly check closure and then execute with return.
             */
            if (is_object($functions)) {
                $clazz->_response->data($functions());
            } elseif (
                Strings::filter($functions)->contains(self::SYS_CONTROLLER)
                && $clazz->_initialize($functions)
            ) {
                /**
                 * Handle System Controller mapping.
                 */
                $clazz->_initialize(
                    $functions,
                    false,
                    $clazz->_response,
                    $clazz->_request,
                    false
                );
            } elseif ($clazz->_initialize(self::APP_CONTROLLER . $functions)) {
                /**
                 * Handle App Controller mapping.
                 */
                $clazz->_initialize(
                    self::APP_CONTROLLER . $functions,
                    false,
                    $clazz->_response,
                    $clazz->_request,
                    false
                );
            } else {
                $clazz->_response->data($functions);
            }

            /**
             * TODO: Switch to a dot base middleware call.
             */
            foreach ($middleware as $middleKey) {
                $clazz->_response->middleware($middleKey);
            }

            $clazz->_response->status($status);
            /**
             * Send structured output.
             */
            $clazz->_response->send();
        }
    }

    /**
     * Routes unmapped url path.
     *
     * @param null $path here
     *
     * @return void
     */
    public function boot($path = null)
    {
        /**
         * Define custom system routes here with $this->map() method
         * E.g General Swagger | Docs | Wiki
         *
         * Find option for sys.Controller
         *
         * NOTE: Do not modify except you know what you're doing!!!!
         */

        /**
         * Swagger 3.0 Doc API for requested path
         */
        self::map(
            "/api/swagger*",
            ['get', 'post'],
            self::SYS_CONTROLLER . "Swagger",
            []
        );

        /**
         * Assist page config value.
         */

        $assistRoot = Value::init()->assistPath();

        /**
         * Swagger frontend for corresponding API Doc
         */
        self::map(
            "/{$assistRoot}/swagger*",
            ['get'],
            self::SYS_CONTROLLER . "SwaggerUI",
            []
        );

        /**
         * MarkDown based help documentation web view.
         */
        self::map("/{$assistRoot}/*", ['get'], self::SYS_CONTROLLER . "Help", []);

        /**
         * Resource router for requested resource files.
         */
        self::map("/resources/*", ['get'], self::SYS_CONTROLLER . "Resources", []);

        /**
         **** System route path end. ****
         */

        if (is_null($path)) {
            $path = $this->_request->path();
        }
        /**
         * Call Index if route is not set.
         */
        if (empty($path) && $this->_initialize(self::APP_CONTROLLER . "index")) {
            $this->_initialize(
                self::APP_CONTROLLER . "index",
                false,
                $this->_response,
                $this->_request
            );
        } elseif ($this->_initialize(self::APP_CONTROLLER . $path)) {
            /**
             * Try calling specified route if the controller exist.
             */
            $this->_initialize(
                self::APP_CONTROLLER . $path,
                false,
                $this->_response,
                $this->_request
            );
        } else {
            /**
             * Call default controller if all fail.
             */
            $this->_initialize(
                self::SYS_CONTROLLER . "default",
                false,
                $this->_response,
                $this->_request
            );
        }
    }
}
