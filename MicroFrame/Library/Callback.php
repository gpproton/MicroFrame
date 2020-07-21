<?php
/**
 * CallBack Library class
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   MicroFrame\Library
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

namespace MicroFrame\Library;

use MicroFrame\Handlers\Exception;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class Callback
 * @package MicroFrame\Library
 */
class Callback
{
    private $url;
    private $timeout = 120;
    private $request = 'GET';
    private $curl;
    private $data;

    /**
     * @param $url
     * @return Callback
     */
    public static function init($url) {
        $instance = new self();
        $instance->curl = curl_init();
        $instance->url = $url;

        return $instance;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function header($key, $value) {
        // TODO: Create array/string builder

        return $this;
    }

    /**
     * @param int $period
     * @return $this
     */
    public function timeout($period = 120) {
        $this->timeout = $period;

        return $this;
    }

    public function data($data = []) {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function request($type = 'GET') {
        $this->request = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    private function build() {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_SSL_VERIFYPEER => false,
//            CURLOPT_HTTPHEADER => array("content-type: application/json", "Accept: application/json","hash:$hash","principal:$this->principal", "credentials: $this->credential"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $this->request,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_TIMEOUT => $this->timeout
        ));

        if($this->data != null) {
            $data_string = json_encode($this->data);

            // TODO: Review from top to bottom
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,$data_string);

            return $this->curl;
        }

    }

    /**
     * @return bool|string
     */
    public function run() {

        return curl_exec($this->build());
    }

}
