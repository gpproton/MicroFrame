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
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Interfaces\IView;

final class Response implements IResponse
{
    private $request;
    private $view;
    public $proceed;
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

    Public function format($type = 'json')
    {
        return $this;
    }

    Public function getFormat($type)
    {
        return $this;
    }

    public function methods($selected = ['get'])
    {
        if(in_array($this->request->method(), $selected)) {
            $this->proceed = true;
            $this->header(201);
            return $this;
        }
        $this->header(405);
        $this->content($this->Errors['405']);
        $this->proceed = false;
        return $this;
    }

    Public function data($array = null)
    {
        $this->contentArray = $array;
        return $this;
    }

    Public function header($key = 200, $value = null)
    {
        if (gettype($key) == 'integer') {
            http_response_code($key);
            return;
        } else if(!is_null($value)) {

        }
        return $this;
    }

    Public function cookie($key, $value)
    {
        return $this;
    }

    Public function session($key, $value)
    {
        return $this;
    }

    public function render(IView $view, IModel $model = null, $data = [])
    {
        // TODO: create view loader
        return $this;
    }

    public function send()
    {
        if (is_null($this->view)) echo json_encode($this->contentArray);
        return;
    }

}
