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

    Public function format($format = null, $types = array('application/json', 'application/xml', 'text/plain'))
    {
        $this->formats = $types;
        $format = is_null($format) ? $this->request->format() : $this->request->query('accept');
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

    Public function header($key = 200, $value = null, $format = false)
    {
        if (is_numeric(gettype($key))) {
            http_response_code($key);
        } else if(!is_null($value) && $key == 'redirect') {
            header("Location: {$value}", true);
        } else if(!is_null($value) && $key == 'content-type') {

            if(!$format) {
                header("Content-Type: {$value}; charset=utf-8", true);
            }

            if (strpos($value, 'json') !== false) {
                header("Content-Type: text/json; charset=utf-8", true);
            } else if (strpos($value, 'xml') !== false) {
                header("Content-Type: text/xml; charset=utf-8", true);
            } else {
                header("Content-Type: text/json}; charset=utf-8", true);
            }

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
     * @param int $time
     * @param null $path
     * @return $this
     */
    Public function refresh($time = 5, $path = null)
    {
        $path = is_null($path) ? "" : " url={$path}";
        header("Refresh: {$time};{$path}");
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

            $contentType = $this->request->contentType();

            /** @var void $this */
            $this->header('content-type', $contentType, true);

            /**
             * Extra check if methods is not called, execute.
             */
            if (!isset($this->methods)) $this->methods();

            /**
             * Output and kill running scripts.
             */
            die(Convert::arrays($this->content, $contentType));
        } else if (is_null($this->view) && gettype($this->content) !== 'array') {
            die($this->content);
        }
        return;
    }

    /**
     * @inheritDoc
     */
    Public function download($path)
    {
        // TODO: Implement download() method.

        //     if(Utils::urlIllegalCheckr(Path::$filePath)){
        //         $filepath = Path::$filePath;
        //         $filename = basename($filepath);
        //         $filesize = filesize($filepath);

        //         // Process download
        //         if(file_exists($filepath)) {
        //             header('Content-Description: File Transfer');
        //             header('Content-Type: ' . Utils::mimeType($filename));
        //             header('Content-Disposition: attachment; filename="'. $filename .'"');
        //             header('Content-Transfer-Encoding: binary');
        //             header('Expires: 0');
        //             header('Cache-Control: must-revalidate');
        //             header('Pragma: public');
        //             header('Content-Length: ' . $filesize);

        //             ob_clean();
        //             flush();
        //             readfile($filepath);
        //             die();
        //         } else {
        //             http_response_code(404);
        //             die();
        //         }
        //     } else {
        //         die("Invalid file name!");
        //     }
    }

}
