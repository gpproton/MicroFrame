<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Strings helper class
 *
 * PHP Version 5
 *
 * @category  Core
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

namespace MicroFrame\Core;

use MicroFrame\Core\Request as request;

final class Response
{
    private $request;
    private $proceed;
    private $contentArray;
    public $formats = array('json', 'xml', 'txt', 'html');
    public $format = 'json';
    public $Errors = [
        '200' => array('status' => 1, 'code' => 200, 'message' => 'Completed Successfully'),
        '204' => array('status' => 0, 'code' => 204, 'message' => 'No content found'),
        '401' => array('status' => 0, 'code' => 401, 'message' => 'Request unauthorised'),
        '405' => array('status' => 0, 'code' => 405, 'message' => 'HTTP method not allowed'),
        '404' => array('status' => 0, 'code' => 404, 'message' => 'Requested resource not found'),
        '500' => array('status' => 0, 'code' => 500, 'message' => 'Some magic error occurred')
    ];


    public function __construct()
    {
        $this->request = new request();
        $this->proceed = false;
        $this->contentArray = $this->Errors['204'];
    }

    Public function format($formatType)
    {

    }

    Public function getFormat($formatType)
    {

    }

    public function methods($selected = ['get'])
    {
        if(in_array($this->request->method(), $selected))
        {
            $this->proceed = true;
            return;
        }
        $this->content($this->Errors['405']);
//        http_response_code($this->Errors['405']['code']);
        $this->proceed = false;
    }

    Public function content($contentArray)
    {
        $this->contentArray = $contentArray;
    }

    Public function header($key, $value)
    {

    }

    Public function cookie($key, $value)
    {

    }

    Public function session($key, $value)
    {

    }

    public function render($viewClass)
    {

    }

    public function send()
    {

    }

}
