<?php
/**
 * Exception Handlers  class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;
defined('BASE_PATH') OR exit('No direct script access allowed');

use \Exception as stockError;
use MicroFrame\Core\Request as request;
use MicroFrame\Core\Response as response;
use MicroFrame\Helpers\Reflect;

/**
 * Class Exception
 * @package MicroFrame\Handlers
 */
class Exception extends  stockError implements \Throwable
{

    public $request;
    public $response;
    public $errorCode;
    public $message;
    private $source;

    /**
     * Exception constructor.
     * @param $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null) {
        $this->request = new request();
        $this->response = new response();
        $this->errorCode = 500;
        $this->source = Reflect::check()->getClassFullNameFromFile(debug_backtrace()[0]['file']);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Log to console and file with no output to response
     *
     * @param null $message
     */
    public function log($message = null) {
        if(is_null($message)) $message = self::getMessage();
//        Logger::warn($message, $this->source);
        Logger::set($message, $this->source)->warn();
    }

    /**
     * @param null $message
     * @return void
     */
    public function output($message = null) {
        if(is_null($message)) $message = self::getMessage();
//        Logger::error($message, $this->source);
        Logger::set($message, $this->source)->error();
        $this->response->methods(['get', 'post', 'put', 'delete', 'options']);
        $this->response->setOutput(0, $this->errorCode, $message);
        $this->response->send();
    }

    /**
     * @param null $message
     */
    public function render($message = null) {
        // TODO: Write error type to default error data array
        if(is_null($message)) $message = self::getMessage();
//        Logger::error($message, $this->source);
        Logger::set($message, $this->source)->error();
        $this->response->setOutput(0, $this->errorCode, $message);
        $this->response->render();
    }

}