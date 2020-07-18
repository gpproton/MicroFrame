<?php

/**
 * Core Application class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;

defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Handlers\Route;
use MicroFrame\Helpers\Utils;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


/**
 * Class Application
 * @package MicroFrame\Core
 */
class Application
{

    /**
     * Application constructor.
     */
    public function __construct() {

    }


    /**
     * Check debug settings and set error checking.
     *
     * @param bool $debug
     * @return bool
     */
    public function environment($debug = false) {
        return $debug && SYS_DEBUG;
    }

    /**
     * Boot up application
     *
     */
    public function start() {

        /**
         * Implement pretty error display.
         */
        if (SYS_DEBUG) {
            $whoops = new Run;
            $page = new PrettyPageHandler();
            $protectArray = array('_ENV', '_SERVER');

            foreach ($protectArray as $pat) {
                foreach ($GLOBALS[$pat] as $offKey => $offValue) {
                    $page->blacklist($pat, $offKey);
                }
            }
            $whoops->pushHandler($page)->register();
        }

        if (SYS_CONSOLE) {
            Console::init()->execute();

        } else {
            /**
             * Load defined routes to request
             */
            Utils::get()->injectRoutes();

            /**
             * Load only request route
             */
            Route::set()->boot();
        }
    }

}