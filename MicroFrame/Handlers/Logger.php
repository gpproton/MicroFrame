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

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Core\Core;
use MicroFrame\Library\Config;
use MicroFrame\Library\File;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Utils;

/**
 * Logger class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Logger extends Core
{

    /**
     * Class path of requested log.
     *
     * @var string
     */
    private $_source;

    /**
     * String to be processed by logger.
     *
     * @var string
     */
    private $_text;

    /**
     * Configurations for logger.
     *
     * @var string|array
     */
    private $_config;

    /**
     * Logger constructor.
     *
     * @param null $text   here
     * @param null $source here
     *
     * @return void|self
     */
    public function __construct($text = null, $source = null)
    {
        $this->_text = $text;
        $this->_source = $source;
    }

    /**
     * The logger static initializer
     *
     * @param null $text  here
     * @param null $class here
     *
     * @return Logger
     */
    public static function set($text = null, $class = null)
    {
        $instance = new self($text, $class);
        $instance->_config = Config::fetch();

        return $instance;
    }

    /**
     * Output an info to logger.
     *
     * @return void
     */
    public function info()
    {
        $this->_output(__FUNCTION__);
    }

    /**
     * Output a warning error to logger.
     *
     * @return void
     */
    public function warn()
    {
        $this->_output(__FUNCTION__);
    }

    /**
     * Output or returns an error message to logger.
     *
     * @return false|string|null
     */
    public function error()
    {
        return $this->_output(__FUNCTION__);
    }

    /**
     * Output or debugging message to logger and web view.
     *
     * @return false|string|null
     */
    public function debug()
    {
        $this->_output(__FUNCTION__);
    }

    /**
     * Output a fatal error and returns message to all medium.
     *
     * @return false|string|null
     */
    public function fatal()
    {
        return $this->_output(__FUNCTION__);
    }

    /**
     * The generalized output method.
     *
     * @param string $type here
     *
     * @return false|string|null
     */
    private function _output($type)
    {
        if (!isset($this->_source)) {
            $this->_source = Reflect::check()
                ->getClassFullNameFromFile(debug_backtrace()[1]['file']);
        }
        $output = $this->_text;

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
            ."]\t[". $this->_source ."]\t"
            . $output ."\n";

        switch ($type) {
        case 'info':
        case 'warn':
            $this->_console($output);
            $this->_file($output);
            break;
        case 'error':
            $this->_console($output);
            $this->_file($output);
            return $this->_web();
        case 'debug':
            $this->_console($output);
            return $output;
        default:
            $this->_console($output);
            $this->_file($output);
            $this->_email($output);
            return $this->_web();
        }
    }

    /**
     * Output log content to console.
     *
     * @param null $string here
     *
     * @return void
     */
    private function _console($string =  null)
    {
        Utils::get()->console($string);
    }

    /**
     * Render log content to web view.
     *
     * @param null $string here
     *
     * @return null|string
     */
    private function _web($string =  null)
    {
        return $string;
    }

    /**
     * Add log content to file.
     *
     * @param null $string here
     * @param null $path   here
     *
     * @return void
     */
    private function _file($string =  null, $path = null)
    {
        $logPath = $this->_config['system']['path']['logs'];

        if (is_null($path)) {
            $path = $logPath . '/app.log';
        }

        if (is_file($path)) {
            $oldDate =  date("d-m-Y", filemtime($path));
            $oldFile = $logPath . "/{$oldDate}.app.log";

            /**
             * Move old logs file
             */
            if (date("d-m-Y") > $oldDate) {
                rename($path, $oldFile);
            }

            /**
             * Discard log files above retention period
             */
            File::init()
                ->clearOld($logPath, $this->_config['system']['retention']['logs']);
        }

        file_put_contents($path, $string, FILE_APPEND);
    }

    /**
     * Allow sending logs as email.
     * TODO: Future use case for email error log
     *
     * @param null $string here
     *
     * @return void
     */
    private function _email($string =  null)
    {
    }
}
