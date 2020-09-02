<?php
/**
 * CallBack Library class
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   MicroFrame\Library
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

namespace MicroFrame\Library;

use MicroFrame\Core\Core;
use MicroFrame\Handlers\Exception;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Callback Class
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Callback extends Core
{
    /**
     * Requested uri in callback instance.
     *
     * @var string
     */
    private $_url;

    /**
     * Specified timeout for callback.
     *
     * @var int
     */
    private $_timeout = 120;

    /**
     * Callback request method.
     *
     * @var string
     */
    private $_request = 'GET';

    /**
     * The final curl instance after build.
     *
     * @var mixed
     */
    private $_curl;

    /**
     * An array of header key and values.
     *
     * @var array
     */
    private $_header = array();

    /**
     * A key => value array for data to send.
     *
     * @var array
     */
    private $_data = array();

    /**
     * Callback static initializer.
     *
     * @param string $url here
     *
     * @return Callback
     */
    public static function init($url)
    {
        $instance = new self();
        $instance->_curl = curl_init();
        $instance->_url = $url;

        return $instance;
    }

    /**
     * Allowing setting of headers with key value array.
     *
     * @param array $headerArray here
     *
     * @return self
     */
    public function header($headerArray = array())
    {
        $this->_header = $headerArray;

        return $this;
    }

    /**
     * Set an HTTP timeout for callback instance.
     *
     * @param int $period here
     *
     * @return self
     */
    public function timeout($period = 120)
    {
        $this->_timeout = $period;

        return $this;
    }

    /**
     * Inject a key value array to post
     *
     * @param array $data a key => value array
     *
     * @return self
     */
    public function data($data = array())
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * A method to specify request type.
     *
     * @param string $type Request type.
     *
     * @return self
     */
    public function request($type = 'GET')
    {
        $this->_request = $type;

        return $this;
    }

    /**
     * Complete PHP curl setup.
     *
     * @return mixed
     */
    private function _build()
    {
        curl_setopt_array(
            $this->_curl,
            array(
            CURLOPT_URL => $this->_url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $this->_header,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $this->_request,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_CONNECTTIMEOUT => $this->_timeout,
            CURLOPT_TIMEOUT => $this->_timeout
            )
        );

        if ($this->_data != null) {
            $data_string = json_encode($this->_data);
            // TODO: Review from top to bottom
            curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $data_string);

            return $this->_curl;
        }
    }

    /**
     * Public method to execute HTTP callback.
     *
     * @return bool|string|array
     */
    public function run()
    {
        return curl_exec($this->_build());
    }
}
