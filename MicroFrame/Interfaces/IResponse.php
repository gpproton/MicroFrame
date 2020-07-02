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
     * @return void
     */
    Public function format($type);

    /**
     * @param $type
     * @return string
     */
    Public function getFormat($type);

    /**
     * @param array $selected
     * @return void
     */
    public function methods($selected = ['get']);

    /**
     * @param $array
     * @return void
     */
    Public function content($array);

    /**
     * @param $key
     * @param $value
     * @return void
     */
    Public function header($key, $value);

    /**
     * @param $key
     * @param $value
     * @return void
     */
    Public function cookie($key, $value);

    /**
     * @param $key
     * @param $value
     * @return void
     */
    Public function session($key, $value);

    /**
     * @param IView $view
     * @return void
     */
    public function render(IView $view);

    /**
     * @return void
     */
    public function send();
}

