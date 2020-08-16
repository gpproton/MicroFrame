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

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Interface IResponse
 *
 * @category Core
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
interface IResponse
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
     * @param  null $value
     * @return self
     */
    public function status($value = null);

    /**
     * @param  null $path
     * @param  bool $proceed
     * @return self
     */
    public function redirect($path = null, $proceed = true);

    /**
     * @param  null $path
     * @param  null $time
     * @param  bool $proceed
     * @return self
     */
    public function refresh($path = null, $time = null, $proceed = true);

    /**
     * @param  $key
     * @param  $value
     * @return self
     */
    public function cookie($key, $value);

    /**
     * @param  $state
     * @param  $value
     * @return self
     */
    public function session($state, $value = null);

    /**
     * @param  int | string | array $middleware
     * @return self
     */
    public function middleware($middleware = null | '' | []);

    /**
     * @param  null | string $view
     * @param  array         $data
     * @return self
     */
    public function render($view = null, $data = []);

    /**
     * @return void
     */
    public function send();

    /**
     * @param  $path
     * @return void
     */
    public function download($path);

    /**
     * @param  $path
     * @return void
     */
    public function file($path);
}
