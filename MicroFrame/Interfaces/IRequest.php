<?php
/**
 * App request interface
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
 * IRequest Interface
 *
 * @category Interface
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
interface IRequest extends ICore
{

    /**
     * Get request method type in plain string
     *
     * @return mixed
     */
    public function method();

    /**
     * Retrieve requested format information.
     *
     * @return string
     */
    public function format();

    /**
     * Extra format/content type information
     *
     * @return array|false|mixed|string|null
     */
    public function contentType();

    /**
     * Get all request variable values
     *
     * @return array
     */
    public function all();

    /**
     * Get all query parameters
     *
     * @param null $string   filter for desired get value
     * @param bool $multiple option for return an array
     *
     * @return array|mixed|null
     */
    public function query($string = null, $multiple = false);

    /**
     * Get posted data
     *
     * @param null $string filter for desired post value
     *
     * @return mixed|null
     */
    public function post($string = null);

    /**
     * Get raw data posted
     *
     * @return false|string
     */
    public function raw();

    /**
     * Get sent header data
     *
     * @param null $string filter for desired header value
     *
     * @return array|false|mixed|null
     */
    public function header($string = null);

    /**
     * Get if current session is browser.
     *
     * @return bool
     */
    public function browser();

    /**
     * Get form encoded data.
     *
     * @return bool
     */
    public function formEncoded();

    /**
     * Get all request information.
     *
     * @param null $string here
     *
     * @return mixed|null
     */
    public function server($string = null);

    /**
     * Get all session info.
     *
     * @param null $string here
     *
     * @return mixed
     */
    public function session($string = null);

    /**
     * Start a basic auth request and retrieve entered valued.
     *
     * @param null $option here
     *
     * @return mixed|void
     */
    public function auth($option = null);

    /**
     * Get sent cookie info.
     *
     * @param null $string here
     *
     * @return mixed
     */
    public function cookie($string = null);

    /**
     * Returns request path information with required formatting.
     *
     * @param bool $dotted here
     *
     * @return string
     */
    public function path($dotted = true);

    /**
     * Get current request URL actual address
     *
     * @param bool $full here
     *
     * @return string
     */
    public function url($full = false);
}
