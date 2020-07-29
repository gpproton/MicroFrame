<?php
/**
 * Logger Handlers class
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

use MicroFrame\Library\Config;
use MicroFrame\Library\File;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Utils;

/**
 * Class Logger
 * @package MicroFrame\Handlers
 */
final class Logger {

    private $source;
    private $text;
    private $config;

    /**
     * Logger constructor.
     * @param null $text
     * @param null $source
     */
    public function __construct($text = null, $source = null) {
        
        $this->text = $text;
        $this->source = $source;
    }

    /**
     * @param null $text
     * @param null $class
     * @return Logger
     */
    public static function set($text = null, $class = null) {
        $instance = new self($text, $class);
        $instance->config = Config::fetch();

        return $instance;
    }

    /**
     *
     */
    public function info()
    {
        $this->output(__FUNCTION__);
    }

    /**
     *
     */
    public function warn()
    {
        $this->output(__FUNCTION__);
    }

    /**
     * @return false|string|null
     */
    public function error()
    {
        return $this->output(__FUNCTION__);
    }

    /**
     *
     */
    public function debug()
    {
        $this->output(__FUNCTION__);
    }

    /**
     * @return false|string|null
     */
    public function fatal()
    {
        return $this->output(__FUNCTION__);
    }

    /**
     * @param $type
     * @return false|string|null
     */
    private function output($type)
    {
        if (!isset($this->source)) $this->source = Reflect::check()->getClassFullNameFromFile(debug_backtrace()[1]['file']);
        $output = $this->text;

        switch (gettype($output)) {
            case 'array':
                $output =  json_encode($output);
                break;
            case 'null':
                $output =  "Nothing to output here!!";
                break;
            case 'integer':
                $output =  "{$output}";
                break;
            default:
                break;
        }
        $output = date("[Y-m-d H:i:s]") . "\t[". $type
            ."]\t[". $this->source ."]\t"
            . $output ."\n";

        switch ($type) {
            case 'info':
            case 'warn':
                $this->console($output);
                $this->file($output);
                break;
            case 'error':
                $this->console($output);
                $this->file($output);
                return $this->web();
            case 'debug':
                $this->console($output);
                return $output;
            default:
                $this->console($output);
                $this->file($output);
                $this->email($output);
                return $this->web();
        }

    }

    /**
     * @param null $string
     */
    private function console($string =  null) {
        Utils::get()->console($string);
    }

    /**
     * @param null $string
     * @return null
     */
    private function web($string =  null) {
        return $string;
    }

    /**
     * @param null $string
     * @param null $path
     */
    private function file($string =  null, $path = null) {

        $logPath = $this->config['system']['path']['logs'];

        if (is_null($path)) $path = $logPath . '/app.log';

        if (is_file($path)) {
            $oldDate =  date("d-m-Y", filemtime($path));
            $oldFile = $logPath . "/{$oldDate}.app.log";

            /**
             * Move old logs file
             */
            if (date("d-m-Y") > $oldDate) rename($path, $oldFile);

            /**
             * Discard log files above retention period
             */
            File::init()->clearOld($logPath, $this->config['system']['retention']['logs']);
        }

        file_put_contents($path, $string, FILE_APPEND);

    }

    /**
     * TODO: Future use case for email error log
     * @param null $string
     */
    private function email($string =  null) {

    }



}
