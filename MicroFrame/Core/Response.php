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
use MicroFrame\Helpers\Convert;
use MicroFrame\Interfaces\IMiddleware;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Interfaces\IView;
// TODO: Implement all methods
final class Response implements IResponse
{
    private $request;
    private $view;
    private $content;
    private $format;
    public $proceed;
    public $Errors = [
        '200' => array('status' => 1, 'code' => 200, 'message' => 'Completed Successfully', 'data' => array()),
        '204' => array('status' => 1, 'code' => 204, 'message' => 'No content found', 'data' => array()),
        '401' => array('status' => 0, 'code' => 401, 'message' => 'Request unauthorised', 'data' => array()),
        '405' => array('status' => 0, 'code' => 405, 'message' => 'HTTP method not allowed', 'data' => array()),
        '404' => array('status' => 0, 'code' => 404, 'message' => 'Requested resource not found', 'data' => array()),
        '500' => array('status' => 0, 'code' => 500, 'message' => 'Some magic error occurred', 'data' => array())
    ];

    public function __construct()
    {
        $this->request = new request();
        $this->proceed = false;
        $this->format = 'json';
        $this->content = $this->Errors['204'];
    }

    public function methods($selected = ['get'])
    {
        if(in_array($this->request->method(), $selected)) {
            $this->proceed = true;
            $this->header(200);
            return $this;
        }
        $this->header(405);
        $this->data($this->Errors['405']);
        $this->proceed = false;
        return $this;
    }

    Public function format($types = array('json', 'xml', 'text'))
    {
        $this->format = $this->request->format();
        if (in_array($this->format, $types)) {
            $this->proceed = true;
        } else {
            $this->proceed = false;
        }
        return $this;
    }

    Public function getFormat($type)
    {
        return $this;
    }

    Public function data($array = null)
    {
        $this->content = $array;
        return $this;
    }

    Public function header($key = 200, $value = null)
    {
        if (gettype($key) == 'integer') {
            http_response_code($key);
            return $this;
        } else if(!is_null($value)) {
            return $this;
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

    public function render(IView $view = null, IModel $model = null, $data = [])
    {
        // TODO: create view loader
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function middleware(IMiddleware $middleware = null)
    {
        if (!is_null($middleware)) {
            $this->proceed = $middleware->handle() && $this->proceed;
        }
        return $this;
    }

    public function send()
    {
        if (is_null($this->view)) {
            if ($this->content['data'])
            if (!$this->proceed && $this->content['code'] !== 405) {
                $this->header(401);
                $this->data($this->Errors['401']);
            }

            if ($this->format === 'json') $this->format();
            echo Convert::arrays($this->content, $this->format);
        }
        return;
    }

}
