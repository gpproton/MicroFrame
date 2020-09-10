<?php

/**
 * Exception Handlers  class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

defined('BASE_PATH') or exit('No direct script access allowed');

use Exception as stockError;
use MicroFrame\Core\Request as request;
use MicroFrame\Core\Response as response;
use MicroFrame\Interfaces\IRequest;
use MicroFrame\Interfaces\IResponse;
use MicroFrame\Library\Reflect;

/**
 * Exception class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Exception extends stockError implements \Throwable
{
    /**
     * A request instance.
     *
     * @var IRequest
     */
    public $request;

    /**
     * An object instance of IResponse
     *
     * @var IResponse
     */
    public $response;

    /**
     * Error/Exception code
     *
     * @var int
     */
    public $errorCode;

    /**
     * Exception message.
     *
     * @var string
     */
    public $message;

    /**
     * Class path for the exception source.
     *
     * @var string
     */
    private $_source;

    /**
     * Exception constructor for initialization.
     *
     * @param string    $message  here
     * @param int       $code     here
     * @param Exception $previous here
     *
     * @return void
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $this->request = new request();
        $this->response = new response();
        $this->errorCode = 500;
        $this->_source = Reflect::check()
            ->getClassFullNameFromFile(debug_backtrace()[0]['file']);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns class path
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Log to console and file with no output to response
     *
     * @param null $message here
     *
     * @return void
     */
    public function log($message = null)
    {
        if (is_null($message)) {
            $message = self::getMessage();
        }

        Logger::set($message, $this->_source)->warn();
    }

    /**
     * Execption static initializer
     *
     * @param string $message here
     *
     * @return Exception
     */
    public static function init($message = "")
    {
        return new self($message);
    }

    /**
     * Returns a standard out put for clearer debugging.
     *
     * @param null $message here
     *
     * @return void
     */
    public function output($message = null)
    {
        if (is_null($message)) {
            $message = self::getMessage();
        }

        Logger::set($message, $this->_source)->error();
        $this->response->methods(['get', 'post', 'put', 'delete', 'options']);
        $this->response->setOutput(0, $this->errorCode, $message);
        $this->response->send();
    }

    /**
     * Render an error view for 500 error.
     *
     * @param null $message here
     *
     * @return void
     */
    public function render($message = null)
    {
        // TODO: Write error type to default error data array
        if (is_null($message)) {
            $message = self::getMessage();
        }

        Logger::set($message, $this->_source)->error();
        $this->response->setOutput(0, $this->errorCode, $message);
        $this->response->data(
            [
            'errorText' => "Looks like we can't now.",
            'errorTitle' => 'Some error occurred (500)',
            'errorImage' => 'images/vector/cream.svg',
            'errorColor' => 'firebrick',
            'showReturn' => true
            ]
        )->render('sys.Default');
    }
}
