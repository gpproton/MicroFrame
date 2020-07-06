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
use MicroFrame\Helpers\Value;
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

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->request = new request();
        $this->proceed = false;
        $this->content = array('status' => 1, 'code' => 204, 'message' => 'No content found', 'data' => array());
    }

    private function setOutput($status = 0, $code = 204, $message = "", $data = []) {
        $this->content['status'] = $status;
        $this->content['code'] = $code;
        $this->content['message'] = $message;
        $this->content['data'] = $data;
    }

    /**
     * @param array $selected
     * @param bool $return
     * @return $this|bool|IResponse
     */
    public function methods($selected = ['get'], $return = false)
    {
        $this->methods = $selected;
        $state = !in_array($this->request->method(), $selected);

        if($state) {
            $this->proceed = false;
            $this->setOutput(0, 405, Value::get()->HttpCodes(405)->text, []);
            if($return) return false;
            return $this;
        } else if (!$state && !$return) {
            $this->proceed = true;
            $this->setOutput(1, 200, Value::get()->HttpCodes(200)->text, []);
            if($return) return true;
            return $this;
        }

    }

    /**
     * @param null $format
     * @param array $types
     * @return $this|IResponse
     */
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
            $this->setOutput(0, 401, Value::get()->HttpCodes(401)->text, []);
            $this->proceed = false;
        }
        return $this;
    }

    /**
     * @param null $content
     * @return $this|IResponse
     */
    Public function data($content = null)
    {
        $this->setOutput(1, 200, Value::get()->HttpCodes(200)->text, $content);
        if ($this->proceed && empty($this->content['data'])) {
            $this->content['status'] = 1;
            $this->content['code'] = 204;
            $this->content['message'] = Value::get()->HttpCodes(204)->text;
        }
        return $this;
    }

    /**
     * @param int $key
     * @param null $value
     * @param bool $format
     * @return $this|IResponse
     */
    Public function header($key = 200, $value = null, $format = false)
    {
        $charset = "charset=utf-8";
        $accessControl = strtoupper(implode(", ", $this->methods));
        if (is_numeric($key)) {
            header(Value::get()->HttpCodes($key)->full, true);
            header("Access-Control-Allow-Methods: {$accessControl}", true);
        } else if(!is_null($value) && $key == 'redirect') {
            header("Location: {$value}", true);
        } else if(!is_null($value) && $key == 'content-type') {

            if (strpos($value, 'json') !== false) {
                header("Content-Type: text/json; ($charset)", true);
            } else if (strpos($value, 'xml') !== false) {
                header("Content-Type: text/xml; ($charset)", true);
            } else {
                header("Content-Type: text/json}; ($charset)", true);
            }

        } else if(!is_null($value) && $key == 'accept') {
            // header("Content-Type: {$value}; charset=utf-8", true);
        } else {
            header("{$key}: {$value}", true);
        }
        header("Access-Control-Allow-Origin: *", true);
        return $this;
    }

    /**
     * @param null $value
     * @return $this|mixed
     */
    Public function status($value = null)
    {
        if(is_null($value)) $this->content['code'] = 200;
        $this->content['code'] = $value;
        return $this;
    }

    /**
     * @param null $path
     * @return mixed|void
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

    /**
     * @param $key
     * @param $value
     * @return $this|IResponse
     */
    Public function cookie($key, $value)
    {
        return $this;
    }

    /**
     * @param $state
     * @param null $value
     * @return $this|IResponse
     */
    Public function session($state, $value = null)
    {
        // session_start(); started already at request session method.
        // TODO: review all these
        // Then starts.
        // Then set $_SESSION with check on allowed list at the end of controller state.
        return $this;
    }

    /**
     * @param IView|null $view
     * @param IModel|null $model
     * @param array $data
     * @return $this|void
     */
    public function render(IView $view = null, IModel $model = null, $data = [])
    {
        // TODO: create view loader
        return $this;
    }

    /**
     * @param IMiddleware|null $middleware
     * @return $this|IResponse
     */
    public function middleware(IMiddleware $middleware = null)
    {
        if (!is_null($middleware)) {
            $this->proceed = $middleware->handle() && $this->proceed;
        }
        return $this;
    }

    /**
     *
     */
    public function send()
    {
        if (is_null($this->view) && gettype($this->content) === 'array') {

            if (!$this->proceed && ($this->content['code'] !== 405)) {
                $this->setOutput(0, 401, Value::get()->HttpCodes(401)->text, []);
            }

            /**
             * Extra check if format is not called
             * and setting content type with requested type
             * accept header must be set or error is sent in json.
             */
            if (!isset($this->formats)) $this->format();
            $contentType = $this->request->contentType();

            /**
             * Extra check if methods is not called, execute.
             */
            if (!isset($this->methods)) $this->methods(['get'], true);

            /** @var void $this */
            $this->header('content-type', $contentType, true);
            $this->header($this->content['code']);

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
     * @param $path
     * @return mixed|void
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
