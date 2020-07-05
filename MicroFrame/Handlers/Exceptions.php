<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Exception Handlers  class
 *
 * PHP Version 5
 *
 * @category  Handlers
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

namespace MicroFrame\Handlers;

use \Exception as stockException;
use MicroFrame\Core\Request as request;
use MicroFrame\Core\Response as response;

class Exceptions extends  stockException
{

    public $request;
    public $response;

    /**
     * Exception constructor.
     * @param $message
     * @param int $code
     * @param Exceptions $previous
     */
    public function __construct($message, $code = 0, Exceptions $previous = null) {

        $this->request = request::class;
        $this->response = response::class;
        parent::__construct($message, $code, $previous);

    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * @param null $message
     */
    public function log($message = null) {

        // TODO: Console error output
    }

    /**
     * @param null $message
     */
    public function output($message = null) {

        // TODO: Generalized error output

    }

    /**
     * @param null $message
     */
    public function send($message = null) {

        // TODO: API type error output
    }

    /**
     * @param null $message
     */
    public function render($message = null) {

        // TODO: HTML or view based error output
    }

    /**
     * @param null $message
     */
    private function format($message = null) {

        // TODO: Error type formatter between string and arrays
    }

}