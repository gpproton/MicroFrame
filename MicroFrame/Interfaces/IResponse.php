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
     * @param bool $_proceed
     */
    public function setProceed(bool $_proceed);

    /**
     * @param  int    $status
     * @param  int    $code
     * @param  string $message
     * @param  array  $data
     * @return mixed
     */
    public function setOutput($status = 0, $code = 204, $message = "", $data = []);

    /**
     * @return mixed
     */
    public function notFound();

    /**
     * @param  string $type
     * @return self
     */
    public function format($type = 'json');

    /**
     * @param  array $selected
     * @param  null  $return
     * @param  bool  $halt
     * @return self
     */
    public function methods($selected = ['get'], $return = null, $halt = false);

    /**
     * @param  $content
     * @param  bool $raw
     * @return self
     */
    public function data($content, $raw =  false);

    /**
     * @param  $content
     * @return self
     */
    public function dataRaw($content = true);

    /**
     * @param  $key
     * @param  $value
     * @return self
     */
    public function header($key, $value = null);

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
