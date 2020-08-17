<?php
/**
 * Core Response class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Core\Request as request;
use MicroFrame\Library\Parser;
use MicroFrame\Library\Strings;
use MicroFrame\Library\Value;
use MicroFrame\Interfaces\IResponse;

// TODO: Implement all methods

/**
 * Core Response class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
final class Response implements IResponse
{
    private $_request;
    private $_view;
    private $_format;
    private $_methods;
    private $_content;
    private $_contentRaw = false;
    private $_proceed;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->_request = new request();
        $this->_proceed = true;
        $this->_content = ['status' => 1,
            'code' => 204,
            'message' => 'No content found',
            'data' => []];

        ob_start();
    }

    /**
     * Set response proceed state.
     *
     * @param bool $_proceed here
     *
     * @return void
     */
    public function setProceed(bool $_proceed): void
    {
        $this->_proceed = $_proceed;
    }

    /**
     * Compose an array based response output.
     *
     * @param int    $status  here
     * @param int    $code    here
     * @param string $message here
     * @param array  $data    here
     *
     * @return self
     */
    public function setOutput($status = 0, $code = 204, $message = "", $data = [])
    {
        $this->_content['status'] = $status;
        $this->_content['code'] = $code;
        $this->_content['message'] = $message;
        $this->_content['data'] = $data;

        return $this;
    }

    /**
     * A specialized method for triggering a 404 error
     *
     * @return mixed|void
     */
    public function notFound()
    {
        if (!$this->_request->browser()) {
            $this->methods(['get', 'post', 'put', 'delete', 'option'])
                ->setOutput(
                    0,
                    404,
                    "Requested resource '{$this->_request->url()}' not found.."
                )
                ->send();
        } else {
            $this->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data(
                    [
                    'errorText' => "Hey there, wrong room...",
                    'errorTitle' => 'Requested resource not found',
                    'errorImage' => 'images/vector/404.svg',
                    'errorColor' => 'firebrick',
                    'showReturn' => true
                    ]
                )
                ->render('sys.Default');
        }
    }

    /**
     * A method for setting an array of allowed HTTP methods
     *
     * @param array $selected here
     * @param bool  $return   here
     * @param bool  $halt     here
     *
     * @return self|bool|IResponse
     */
    public function methods($selected = ['get'], $return = false, $halt = false)
    {
        $this->_methods = $selected;
        $state = !in_array($this->_request->method(), $selected);

        if ($state) {
            $this->_proceed = false;
            $this->setOutput(0, 405, Value::init()->HttpCodes(405)->text, []);
            if ($return) {
                return false;
            }
            ($halt && is_null($this->_view)) ?
                $this->send() : $this->notFound(); // TODO: Add 404 view.
            return $this;
        } elseif (!$state && !$return && !$halt) {
            $this->_proceed = true;
            $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, []);
            if ($return) {
                return true;
            }
            if ($halt) {
                $this->send();
            }
            return $this;
        }

        return $this;
    }

    /**
     * Useful for validating and setting content type.
     *
     * @param null $format here
     *
     * @return self
     */
    public function format($format = null)
    {
        $this->_format = is_null($format) ? (is_null($format)
            ? $this->_request->format() :
            $this->_request->query('accept')) : $format;

        if (strlen($this->_format) <= 3 && $this->_format !== 'xml') {
            $this->_format = $this->_request->contentType();
            if (empty($this->_format) || $this->_format === "*/*") {
                $this->_format = 'application/json';
            }
        }

        return $this;
    }

    /**
     * Sets an array or string to output or render.
     *
     * @param null|string|array $content here
     * @param bool              $raw     here
     *
     * @return self
     */
    public function data($content = null, $raw =  false)
    {
        $this->dataRaw($raw);

        $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, $content);
        if ($this->_proceed && empty($this->_content['data'])) {
            $this->_content['status'] = 1;
            $this->_content['code'] = 204;
            $this->_content['message'] = Value::init()->HttpCodes(204)->text;
        }

        return $this;
    }

    /**
     * Sets an array or string to output or render.
     *
     * @param bool $content here
     *
     * @return self
     */
    public function dataRaw($content = true)
    {
        $this->_contentRaw = $content ? true : false;

        return $this;
    }

    /**
     * A method for setting custom header options
     *
     * @param int    $key    here
     * @param string $value  here
     * @param bool   $format here
     *
     * @return self
     */
    public function header($key = 200, $value = null, $format = false)
    {
        $charset = "charset=utf-8";
        $accessControl = strtoupper(implode(", ", $this->_methods));
        if (is_numeric($key)) {
            header(Value::init()->HttpCodes($key)->full, true);
            header("Access-Control-Allow-Methods: {$accessControl}", true);
        } elseif (!is_null($value) && $key == 'redirect') {
            header("Location: {$value}", true);
        } elseif (!is_null($value) && $key == 'content-type') {
            if (strpos($value, 'json') !== false) {
                header("Content-Type: application/json; ($charset)", true);
            } elseif (strpos($value, 'xml') !== false) {
                header("Content-Type: application/xml; ($charset)", true);
            } elseif (strpos($value, 'yaml') !== false) {
                header("Content-Type: application/x-yaml; ($charset)", true);
            } else {
                header("Content-Type: {$value}; ($charset)", true);
            }
        } elseif (!is_null($value) && $key == 'accept') {
            // header("Content-Type: {$value}; charset=utf-8", true);
        } else {
            header("{$key}: {$value}", true);
        }
        header("Access-Control-Allow-Origin: *", true);

        return $this;
    }

    /**
     * Sets response header status code
     *
     * @param null|int $value here
     *
     * @return self|mixed
     */
    public function status($value = null)
    {
        if (is_null($value)) {
            $this->_content['code'] = 200;
        }
        $this->_content['code'] = $value;

        return $this;
    }

    /**
     * Change location of current route to another.
     *
     * @param null|string $path    here
     * @param bool        $proceed here
     *
     * @return self
     */
    public function redirect($path = null, $proceed = true)
    {
        if ($proceed) {
            $this->header('redirect', $path);
        }

        return $this;
    }

    /**
     * Sets a time frame for a route to refresh.
     *
     * @param int         $time    here
     * @param null|string $path    here
     * @param bool        $proceed here
     *
     * @return self
     */
    public function refresh($time = 5, $path = null, $proceed = true)
    {
        if ($proceed) {
            $path = is_null($path) ? "" : " url={$path}";
            header("Refresh: {$time};{$path}");
        }

        return $this;
    }

    /**
     * Set a response cookie value.
     *
     * @param string $key   here
     * @param string $value here
     *
     * @return self
     */
    public function cookie($key, $value = '')
    {
        // TODO: review this

        return $this;
    }

    /**
     * Sets a session state.
     *
     * @param string $state here
     * @param string $value here
     *
     * @return self
     */
    public function session($state, $value = null)
    {
        // session_start(); started already at request session method.
        // TODO: review all these
        // Then starts.
        // Then set $_SESSION with check on
        //allowed list at the end of controller state.
        return $this;
    }

    /**
     * Inits one or more middleware
     *
     * @param string|array|null $middleware here
     *
     * @return self
     */
    public function middleware($middleware = '')
    {
        if (!is_null($middleware)) {
            /**
             * TODO: Complete implementation.
             * TODO: Switch to a dot based middleware/
             */
            //$this->proceed = $middleware->handle() && $this->proceed;
        }
        return $this;
    }

    /**
     * Send an array or string based HTTP response.
     *
     * @return void
     */
    public function send()
    {
        /**
         * Filter out unintended string output
         */
        ob_clean();
        
        if (is_null($this->_view) && gettype($this->_content) === 'array') {
            if (!$this->_proceed && ($this->_content['code'] !== 405)) {
                $this->setOutput(0, 401, Value::init()->HttpCodes(401)->text, []);
            }

            /**
             * Extra check if format is not called
             * and setting content type with requested type
             * accept header must be set or error is sent in json.
             */
            if (!isset($this->formats)) {
                $this->format();
            }

            /**
             * Extra check if methods is not called, execute.
             */
            if (!isset($this->_methods)) {
                $this->methods(['get'], true);
            }

            /**
             * If request format contains html set to JSON.
             */
            $this->_format = (strpos($this->_format, 'html') !== false)
                ? 'application/json' : $this->_format;

            $this->header('content-type', $this->_format, true);
            $this->header($this->_content['code']);

            /**
             * Output and kill running scripts.
             */

            if ($this->_contentRaw) {
                die(Parser::arrays($this->_content['data'], $this->_format));
            } else {
                die(Parser::arrays($this->_content, $this->_format));
            }
        } elseif (is_null($this->_view) && gettype($this->_content) !== 'array') {
            die($this->_content);
        } else {
            die('please use render for VIEW output.');
        }
    }

    /**
     * Renders a webview or string.
     *
     * @param null|string $view here
     * @param array       $data here
     *
     * @return $this|void
     */
    public function render($view = null, $data = [])
    {
        $currentPath = $this->_request->path(false);
        $barePath = Strings::filter($this->_request->url())
            ->replace([$currentPath, '//', ':/'], ['', '/', '://'])
            ->value();

        /**
         * Create a local variable with defined keys in data array.
         */
        $data = array_merge($data, $this->_content['data']);
        $data['url'] = $this->_request->url();
        $data['path'] = $this->_request->path(false);
        $data['root'] = $barePath . 'resources/';
        $data['base'] = $barePath;

        foreach ($data as $key => $value) {
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
                ->contains("sys.")
                ? CORE_PATH . '/Defaults/View/' : APP_PATH . '/View/';

            $view = $basePath . Strings::filter($view)
                ->replace(['app.', 'sys.', '.'], ['', '', '/'])
                ->append('View.php')
                ->value();

            if (file_exists($view)) {
                ob_start();
                include_once $view;
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
     * Send a requested file to be forcefully downloaded via HTTP.
     *
     * @param string $path here
     *
     * @return void
     */
    public function download($path)
    {
        if (Strings::filter($path)->url()) {
            $filepath = $path;
            $filename = basename($filepath);
            $filesize = filesize($filepath);
            $contentType = Value::init()->mimeType($filename);
            if (file_exists($filepath)) {
                $this->header('Content-Description', 'File Transfer');
                $this->header('content-type', $contentType);
                $this->header(
                    'Content-Disposition',
                    'attachment; filename="' . $filename . '"'
                );
                $this->header('Content-Transfer-Encoding', 'binary');
                $this->header('Expires', '0');
                $this->header('Cache-Control', 'must-revalidate');
                $this->header('Pragma', 'public');
                $this->header('Content-Length', $filesize);
                ob_clean();
                flush();
                readfile($filepath);
                $this->setOutput(1, 200, Value::init()->HttpCodes(200)->text, []);
                die(
                    Parser::arrays(
                        $this->_content,
                        $this->_request->contentType()
                    )
                );
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }

    /**
     * Send a file with no specified or forceful usage.
     *
     * @param string $path here
     *
     * @return void
     */
    public function file($path)
    {
        if (is_file($path)) {
            header('Content-Type: ' . Value::init()->mimeType($path));

            //No cache
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            //Define file size
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();

            readfile($path);
            die();
        } else {
            $this->notFound();
        }
    }
}
