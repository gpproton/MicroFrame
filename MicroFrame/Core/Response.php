<?php
/**
 * Response Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;
defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Core\Request as request;
use MicroFrame\Library\Convert;
use MicroFrame\Library\Strings;
use MicroFrame\Library\Utils;
use MicroFrame\Library\Value;
use MicroFrame\Interfaces\IMiddleware;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Interfaces\IView;

// TODO: Implement all methods

/**
 * Class Response
 * @package MicroFrame\Core
 */
final class Response implements IResponse
{
    private $request;
    private $view;
    private $format;
    private $methods;
    public $content;
    private $contentRaw = false;
    public $proceed;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->request = new request();
        $this->proceed = true;
        $this->content = array('status' => 1, 'code' => 204, 'message' => 'No content found', 'data' => array());

        ob_start();
    }

    /**
     * @param int $status
     * @param int $code
     * @param string $message
     * @param array $data
     * @return $this
     */
    public function setOutput($status = 0, $code = 204, $message = "", $data = []) {
        $this->content['status'] = $status;
        $this->content['code'] = $code;
        $this->content['message'] = $message;
        $this->content['data'] = $data;
        return $this;
    }

    public function notFound() {
        if (!$this->request->browser()) {
            $this->methods(['get', 'post', 'put', 'delete', 'option'])
                ->setOutput(0, 404, "Requested resource '{$this->request->url()}' not found..")
                ->send();
        } else {
            $this->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data(array('errorText' => "Requested resource '{$this->request->url()}' not found.."))
                ->render('sys.404');
        }

    }

    /**
     * @param array $selected
     * @param bool $return
     * @param bool $halt
     * @return $this|bool|IResponse
     */
    public function methods($selected = ['get'], $return = false, $halt = false)
    {
        $this->methods = $selected;
        $state = !in_array($this->request->method(), $selected);

        if($state) {
            $this->proceed = false;
            $this->setOutput(0, 405, Value::init()->HttpCodes(405)->text, []);
            if($return) return false;
            $halt && is_null($this->view) ? $this->send() : $this->render(); // TODO: Add 404 view.
            return $this;
        } else if (!$state && !$return && !$halt) {
            $this->proceed = true;
            $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, []);
            if($return) return true;
            if ($halt) $this->send();
            return $this;
        }

        return $this;

    }

    /**
     * @param null $format
     * @return $this
     */
    Public function format($format = null)
    {
        $this->format = is_null($format) ? (is_null($format) ? $this->request->format() : $this->request->query('accept')) : $format;

            if (strlen($this->format) <= 3) {
                $this->format = $this->request->contentType();
                if (empty($this->format) || $this->format === "*/*") {
                    $this->format = 'application/json';
                }
            }

            return $this;

    }

    /**
     * @param null $content
     * @param bool $raw
     * @return $this|IResponse
     */
    Public function data($content = null, $raw =  false)
    {
        $this->dataRaw($raw);

        $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, $content);
        if ($this->proceed && empty($this->content['data'])) {
            $this->content['status'] = 1;
            $this->content['code'] = 204;
            $this->content['message'] = Value::init()->HttpCodes(204)->text;
        }

        return $this;
    }

    Public function dataRaw($content = true) {

        $this->contentRaw = $content ? true : false;

        return $this;
    }

    /**
     * @param int $key
     * @param null $value
     * @param bool $format
     * @return $this
     */
    Public function header($key = 200, $value = null, $format = false)
    {
        $charset = "charset=utf-8";
        $accessControl = strtoupper(implode(", ", $this->methods));
        if (is_numeric($key)) {
            header(Value::init()->HttpCodes($key)->full, true);
            header("Access-Control-Allow-Methods: {$accessControl}", true);
        } else if(!is_null($value) && $key == 'redirect') {
            header("Location: {$value}", true);
        } else if(!is_null($value) && $key == 'content-type') {

            if (strpos($value, 'json') !== false) {
                header("Content-Type: application/json; ($charset)", true);
            } else if (strpos($value, 'xml') !== false) {
                header("Content-Type: application/xml; ($charset)", true);
            } else if (strpos($value, 'yaml') !== false) {
                header("Content-Type: application/x-yaml; ($charset)", true);
            } else {
                header("Content-Type: {$value}; ($charset)", true);
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
     * @param bool $proceed
     * @return self
     */
    Public function redirect($path = null, $proceed = true)
    {
        if ($proceed) {
            $this->header('redirect', $path);
        }

        return $this;
    }

    /**
     * @param int $time
     * @param null $path
     * @param bool $proceed
     * @return self
     */
    Public function refresh($time = 5, $path = null, $proceed = true)
    {
        if ($proceed) {
            $path = is_null($path) ? "" : " url={$path}";
            header("Refresh: {$time};{$path}");
        }

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
     * @param int | string | array $middleware
     * @return $this|IResponse
     *
     * TODO: Switch to a dot based middleware/
     */
    public function middleware($middleware = null | '' | [])
    {
        if (!is_null($middleware)) {
            /**
             * TODO: Complete implementation.
             */
//            $this->proceed = $middleware->handle() && $this->proceed;
        }
        return $this;
    }

    /**
     *
     */
    public function send()
    {
        /**
         * Filter out unintended string output
         */
        ob_clean();
        
        if (is_null($this->view) && gettype($this->content) === 'array') {

            if (!$this->proceed && ($this->content['code'] !== 405)) {
                $this->setOutput(0, 401, Value::init()->HttpCodes(401)->text, []);
            }

            /**
             * Extra check if format is not called
             * and setting content type with requested type
             * accept header must be set or error is sent in json.
             */
            if (!isset($this->formats)) $this->format();

            /**
             * Extra check if methods is not called, execute.
             */
            if (!isset($this->methods)) $this->methods(['get'], true);

            /** @var void $this */
            $this->header('content-type', $this->format, true);
            $this->header($this->content['code']);

            /**
             * Output and kill running scripts.
             */

            if ($this->contentRaw) {
                die(Convert::arrays($this->content['data'], $this->format));
            } else {
                die(Convert::arrays($this->content, $this->format));
            }

        } else if (is_null($this->view) && gettype($this->content) !== 'array') {
            die($this->content);
        } else {
            die('please use render for VIEW output.');
        }
    }

    /**
     * @param null | string $view
     * @param array $data
     * @return $this|void
     */
    public function render($view = null, $data = [])
    {
        $currentPath = $this->request->path(false);
        $barePath = Strings::filter($this->request->url())->replace([$currentPath, '//', ':/'], ['', '/', '://'])->value();

        /**
         * Create a local variable with defined keys in data array.
         */
        $data = array_merge($data, $this->content['data']);
        $data['url'] = $this->request->url();
        $data['path'] = $this->request->path(false);
        $data['root'] = $barePath . 'resources/';
        $data['base'] = $barePath;

        foreach($data as $key => $value)
        {
            ${$key} = $value;
        }

        /**
         * Filter out unintended string output
         */
        ob_clean();
        /**
         * Basic Implementation without the templating and module merging yet.
         */
        if (!empty($view)) {
            $basePath = Strings::filter($view)
                ->contains("sys.") ? CORE_PATH . '/Defaults/View/' : APP_PATH . '/View/';

            $view = $basePath . Strings::filter($view)
                    ->replace(['app.', 'sys.', '.'], ['', '', '/'])
                    ->append('View.php')
                    ->value();

            if (file_exists($view)) {
                ob_start();
                include_once ($view);
                $vals = ob_get_contents();
                ob_clean();
                die($vals);
            } else {
                die('Request view does not exist...');
            }

        } else {
            die('No view specified...');
        }

    }

    /**
     * @param $path
     * @return void
     */
    Public function download($path)
    {
        /** @var string $path */
        if(Strings::filter($path)->url()){
                 $filepath = $path;
                 $filename = basename($filepath);
                 $filesize = filesize($filepath);
                 $contentType = Value::init()->mimeType($filename);
                 if(file_exists($filepath)) {
                     $this->header('Content-Description', 'File Transfer');
                     $this->header('content-type', $contentType);
                     $this->header('Content-Disposition', 'attachment; filename="'. $filename .'"');
                     $this->header('Content-Transfer-Encoding', 'binary');
                     $this->header('Expires', '0');
                     $this->header('Cache-Control', 'must-revalidate');
                     $this->header('Pragma', 'public');
                     $this->header('Content-Length', $filesize);
                     ob_clean();
                     flush();
                     readfile($filepath);
                     $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, []);
                     die(Convert::arrays($this->content, $this->request->contentType()));
                 } else {
                     $this->notFound();
                 }
             } else {
                $this->notFound();
             }
    }

    /**
     * @param $path
     * @return void
     */
    Public function file($path) {
        if (is_file($path)) {
            $this->header('content-type', Value::init()->mimeType($path));
            readfile($path);
            die();
        } else {
            $this->notFound();
        }
    }

}
