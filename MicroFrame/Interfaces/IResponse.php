<?php
/**
 * App response interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

namespace MicroFrame\Interfaces;
defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Interface IResponse
 * @package MicroFrame\Interfaces
 */
interface IResponse
{

    /**
     * @param int $status
     * @param int $code
     * @param string $message
     * @param array $data
     * @return mixed
     */
    public function setOutput($status = 0, $code = 204, $message = "", $data = []);

    /**
     * @return mixed
     */
    public function notFound();

    /**
     * @param string $type
     * @return self
     */
    Public function format($type = 'json');

    /**
     * @param array $selected
     * @param null $return
     * @param bool $halt
     * @return self
     */
    public function methods($selected = ['get'], $return = null,  $halt = false);

    /**
     * @param $content
     * @param bool $raw
     * @return self
     */
    Public function data($content, $raw =  false);

    /**
     * @param $content
     * @return self
     */
    Public function dataRaw($content = true);

    /**
     * @param $key
     * @param $value
     * @return self
     */
    Public function header($key, $value = null);

    /**
     * @param null $value
     * @return self
     */
    Public function status($value = null);

    /**
     * @param null $path
     * @param bool $proceed
     * @return self
     */
    Public function redirect($path = null, $proceed = true);

    /**
     * @param null $path
     * @param null $time
     * @param bool $proceed
     * @return self
     */
    Public function refresh($path = null, $time = null, $proceed = true);

    /**
     * @param $key
     * @param $value
     * @return self
     */
    Public function cookie($key, $value);

    /**
     * @param $state
     * @param $value
     * @return self
     */
    Public function session($state, $value = null);

    /**
     * @param IMiddleware $middleware
     * @return self
     */
    public function middleware(IMiddleware $middleware = null);

    /**
     * @param IView|null $view
     * @param IModel|null $model
     * @param array $data
     * @return self
     */
    public function render(IView $view = null, IModel $model = null, $data = []);

    /**
     * @return void
     */
    public function send();

    /**
     * @param $path
     * @return void
     */
    Public function download($path);

    /**
     * @param $path
     * @return void
     */
    Public function file($path);
}

