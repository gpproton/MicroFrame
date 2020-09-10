<?php

/**
 * Core class
 *
 * PHP Version 7
 *
 * @category  MicroFrame
 * @package   MicroFrame
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/microframe
 * A file for testing docs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame;

/**
 * Framework root path.
 */
define('BASE_PATH', dirname(__DIR__));

use MicroFrame\{Core\Request as request, Handlers\ErrorHandler as handler, Core\Application as app};

/**
 * Core Class
 * MicroFrame core bootstrapper for application.
 *
 * @category Core
 * @package  MicroFrame
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Core
{

    /**
     * Core initialization method.
     *
     * @param handler $handler error handler class path.
     *
     * @return void
     */
    public function run(handler $handler): void
    {

        /**
         * Framework internals path.
         */
        define('CORE_PATH', BASE_PATH . '/MicroFrame');
        /**
         * Framework app code path.
         */
        define('APP_PATH', BASE_PATH . '/App');
        /**
         * Framework base data path.
         */
        define('DATA_PATH', BASE_PATH . '/Data');

        /**
         * Initialize PHP request and globals modification.
         */
        if (!request::overrideGlobals()) {
            die('Request can bot be routed!!!');
        }

        $handler->bootstrap(new app());
    }
}
