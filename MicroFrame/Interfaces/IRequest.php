<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * App request interface
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

interface IRequest
{

    public function method();

    Public function all();

    Public function get($string = null, $multiple = false);

    Public function post($string = null);

    Public function header($string = null);

    Public function session($string = null);

    Public function cookie($string = null);

}
