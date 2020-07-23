<?php
/**
 * Core class
 *
 * PHP Version 7
 *
 * @category  MicroFrame
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/microframe
 * @summary A file for testing docs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame;

/**
 * @summary Framework root path.
 */
define('BASE_PATH', realpath(__DIR__ .'/..'));

use MicroFrame\Core\Request as request;
use MicroFrame\Handlers\ErrorHandler as handler;
use MicroFrame\Core\Application as app;

/**
 * Class Core
 * @package MicroFrame
 * @summary MicroFrame core bootstrapper for application.
 */
final class Core {

    /**
     * @summary Core initialization method.
     *
     * @param handler $handler
     */
    public function run(handler $handler)
    {

        /**
         * @summary Framework internals path.
         */
        define('CORE_PATH', realpath(__DIR__ .'/../MicroFrame'));
        /**
         * @summary Framework app code path.
         */
        define('APP_PATH', realpath(__DIR__ .'/../App'));
        /**
         * @summary Framework base data path.
         */
        define('DATA_PATH', realpath(__DIR__ .'/../Data'));

        /**
         * @summary Initialize PHP request and globals modification.
         */
        if (!request::overrideGlobals()) die('Request can bot be routed!!!');
        else {
            $handler->bootstrap(new app);
        }
    }
}
