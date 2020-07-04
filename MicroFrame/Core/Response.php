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
use MicroFrame\Helpers\Utils;
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
    private $formats;
    private $methods;
    public $proceed;
    public $States = [
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
        $this->content = $this->States['204'];
    }

    public function methods($selected = ['get'], $return = null)
    {
        $this->methods = $selected;

        if(in_array($this->request->method(), $selected)) {
            $this->proceed = true;
            $this->header(200);
            if(!is_null($return)) return true;
            return $this;
        }
        $this->header(405);
        $this->data($this->States['405']);
        $this->proceed = false;
        if(!is_null($return)) return false;
        return $this;
    }

    Public function format($types = array('application/json', 'application/xml', 'text/plain'))
    {
        $this->formats = $types;
        $format = $this->request->format();
        $found = function() use ($types, $format) {
            $count = 0;
            foreach ($types as $type) {
                $count++;
                if (strpos($type, $format) !== false) {
                    return true;
                } else if($count === count($types) - 1) {
                    return false;
                }
            }
        };
        if ($found()) {
            $this->proceed = true;
        } else {
            $this->content = $this->States['401'];
            $this->content['message'] = $this->content['message'] . ' | Accept header not set';
            $this->proceed = false;
        }
        return $this;
    }

    Public function data($content = null)
    {
        $this->content = $this->States['200'];
        $this->content['data'] = $content;
        if ($this->proceed && !empty($this->content['data'])) {
            $this->header(200);
        }
        return $this;
    }

    Public function header($key = 200, $value = null)
    {
        if (is_numeric(gettype($key))) {
            http_response_code($key);
        } else if(!is_null($value) && $key == 'redirect') {
            header("Location: {$value}", true);
        } else if(!is_null($value) && $key == 'content-type') {
            header("Content-Type: {$value}; charset=utf-8", true);
        } else if(!is_null($value) && $key == 'accept') {
            // header("Content-Type: {$value}; charset=utf-8", true);
        } else {
            header("{$key}: {$value}", true);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    Public function status($value = null)
    {
        if(is_null($value)) $this->header(200);
        $this->header($value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    Public function redirect($path = null)
    {
        $this->header('redirect', $path);
        return;
    }

    /**
     * @inheritDoc
     */
    Public function refresh($path = 5, $time = null)
    {
        header("Refresh: {$time}; url={$path}");
        return $this;
    }

    Public function cookie($key, $value)
    {
        return $this;
    }

    Public function session($state, $value = null)
    {
        // session_start(); started already at request session method.
        // TODO: review all these
        // Then starts.
        // Then set $_SESSION with check on allowed list at the end of controller state.
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
        if (is_null($this->view) && gettype($this->content) === 'array') {
            if (!$this->proceed && $this->content['code'] !== 405) {
                $this->header(401);
                $this->data($this->States['401']);
            }

            /**
             * Extra check if format is not called
             * and setting content type with requested type
             * accept header must be set or error is sent in json.
             */
            if (!isset($this->formats)) $this->format();
            $queryFormat = $this->request->query('format');
            if (!is_null($queryFormat)) {
                $contentType = $queryFormat;
            } else {
                $contentType = $this->request->contentType();
            }


            $multipart = strpos($contentType, 'multi') !== false;
            $reqFormat = $this->request->format();
            if (strlen($contentType) <= 5 || $multipart) {
                if ($multipart) $contentType = $reqFormat;
                if (!$multipart) $contentType = $reqFormat == '*/*' ? 'application/json' : $reqFormat;
            }

            /**
             * Handle browsers request
             */
            if (strpos($contentType, 'signed') !== false) $contentType = '*/*';
            $this->header('content-type', $contentType);

            /**
             * Extra check if methods is not called.
             */
            if (!isset($this->methods)) $this->methods();

            /**
             * Only echo to allow for destructor use for after operations.
             */
            echo(Convert::arrays($this->content, $contentType));
        } else if (is_null($this->view) && gettype($this->content) !== 'array') {
            echo($this->content);
        }
        return;
    }

    /**
     * @inheritDoc
     */
    Public function download($path)
    {
        // TODO: Implement download() method.
    }

}
