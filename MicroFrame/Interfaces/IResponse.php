<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * App response interface
 *
 * PHP Version 5
 *
 * @category  Interfaces
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Interfaces;

interface IResponse
{
    /**
     * @param $type
     * @return self
     */
    Public function format($type = 'json');

    /**
     * @param $type
     * @return self
     */
    Public function getFormat($type);

    /**
     * @param array $selected
     * @return self
     */
    public function methods($selected = ['get']);

    /**
     * @param $array
     * @return self
     */
    Public function data($array);

    /**
     * @param $key
     * @param $value
     * @return self
     */
    Public function header($key, $value = null);

    /**
     * @param $key
     * @param $value
     * @return self
     */
    Public function cookie($key, $value);

    /**
     * @param $key
     * @param $value
     * @return self
     */
    Public function session($key, $value);

    /**
     * @param IMiddleware $middleware
     * @return self
     */
    public function middleware(IMiddleware $middleware = null);

    /**
     * @param IView|null $view
     * @param IModel|null $model
     * @param array $data
     * @return void
     */
    public function render(IView $view = null, IModel $model = null, $data = []);

    /**
     * @return void
     */
    public function send();
}

