<?php
/**
 * App request interface
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

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Interface IRequest
 * @package MicroFrame\Interfaces
 */
interface IRequest
{

    /**
     * @return string
     */
    public function method();

    /**
     * @return string
     */
    public function format();

    /**
     * @return string
     */
    public function contentType();

    /**
     * @return array
     */
    public function all();

    /**
     * @param null $string
     * @param bool $multiple
     * @return mixed
     */
    public function query($string = null, $multiple = false);

    /**
     * @param null $string
     * @return mixed
     */
    public function post($string = null);

    /**
     * @return string
     */
    public function raw();

    /**
     * @return bool
     */
    public function browser();

    /**
     * @return bool
     */
    public function formEncoded();

    /**
     * @param null $string
     * @return mixed
     */
    public function server($string = null);

    /**
     * @param null $string
     * @return mixed
     */
    public function header($string = null);

    /**
     * @param null $string
     * @return mixed
     */
    public function session($string = null);

    /**
     * @param null $option
     * @return mixed
     */
    public function auth($option = null);

    /**
     * @param null $string
     * @return mixed
     */
    public function cookie($string = null);

    /**
     * @param bool $dotted
     * @return string
     */
    public function path($dotted = true);

    /**
     * Get current request URL actual address
     *
     * @param bool $full
     * @return string
     */
    public function url($full = false);
}
