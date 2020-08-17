<?php
/**
 * Core Response interface
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

use MicroFrame\Interfaces\Core\ICore;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Interface IResponse
 *
 * @category Interface
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
interface IResponse extends ICore
{

    /**
     * Set response proceed state.
     *
     * @param bool $_proceed here
     *
     * @return void
     */
    public function setProceed(bool $_proceed);

    /**
     * Compose an array based response output.
     *
     * @param int    $status  here
     * @param int    $code    here
     * @param string $message here
     * @param array  $data    here
     *
     * @return self
     */
    public function setOutput($status = 0, $code = 204, $message = "", $data = []);

    /**
     * A specialized method for triggering a 404 error
     *
     * @return mixed|void
     */
    public function notFound();

    /**
     * A method for setting an array of allowed HTTP methods
     *
     * @param array $selected here
     * @param bool  $return   here
     * @param bool  $halt     here
     *
     * @return self|bool|IResponse
     */
    public function methods($selected = ['get'], $return = false, $halt = false);


    /**
     * Useful for validating and setting content type.
     *
     * @param null $type here
     *
     * @return self
     */
    public function format($type = null);

    /**
     * Sets an array or string to output or render.
     *
     * @param null|string|array $content here
     * @param bool              $raw     here
     *
     * @return self
     */
    public function data($content, $raw =  false);

    /**
     * A additional to data for setting if data should contain any metadata.
     *
     * @param bool $content here
     *
     * @return self
     */
    public function dataRaw($content = true);

    /**
     * A method for setting custom header options
     *
     * @param string $key    here
     * @param string $value  here
     * @param bool   $format here
     *
     * @return self
     */
    public function header($key, $value = null, $format = false);

    /**
     * Sets response header status code
     *
     * @param null|int $value here
     *
     * @return self|mixed
     */
    public function status($value = null);

    /**
     * Change location of current route to another.
     *
     * @param null|string $path    here
     * @param bool        $proceed here
     *
     * @return self
     */
    public function redirect($path = null, $proceed = true);

    /**
     * Sets a time frame for a route to refresh.
     *
     * @param int         $time    here
     * @param null|string $path    here
     * @param bool        $proceed here
     *
     * @return self
     */
    public function refresh($time = 5, $path = null, $proceed = true);

    /**
     * Set a response cookie value.
     *
     * @param string $key   here
     * @param string $value here
     *
     * @return self
     */
    public function cookie($key, $value = '');

    /**
     * Sets a session state.
     *
     * @param string $state here
     * @param string $value here
     *
     * @return self
     */
    public function session($state, $value = '');

    /**
     * Inits one or more middleware
     *
     * @param string|array|null $middleware here
     *
     * @return self
     */
    public function middleware($middleware = '');

    /**
     * Renders a webview or string.
     *
     * @param null|string $view here
     * @param array       $data here
     *
     * @return $this|void
     */
    public function render($view = null, $data = []);

    /**
     * Send an array or string based HTTP response.
     *
     * @return void
     */
    public function send();

    /**
     * Send a requested file to be forcefully downloaded via HTTP.
     *
     * @param string $path here
     *
     * @return void
     */
    public function download($path);

    /**
     * Send a file with no specified or forceful usage.
     *
     * @param string $path here
     *
     * @return void
     */
    public function file($path);
}
