<?php
/**
 * SwaggerUI controller class
 *
 * PHP Version 7
 *
 * @category  Controller
 * @package   MicroFrame\Defaults\Controller
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

namespace MicroFrame\Defaults\Controller;

defined('BASE_PATH') or exit('No direct script access allowed');


use \MicroFrame\Core\Controller as Core;
use MicroFrame\Library\Strings;
use MicroFrame\Library\Value;

/**
 * SwaggerUIController Class
 *
 * @category Controller
 * @package  MicroFrame\Defaults\Controller
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class SwaggerUIController extends Core
{

    /**
     * Renders UI for openAPI spec.
     *
     * @return void
     */
    public function index()
    {
        $fullUrl = $this->request->url();
        /**
         * Get co responding API path to scan for annotations.
         */
        $apiPath = Strings::filter($fullUrl)
            ->replace(Value::init()->assistPath() . "/swagger", "api/swagger")
            ->value();

        $this->response
            ->data(['apiPath' => $apiPath])
            ->render('sys.SwaggerUI');
    }
}
