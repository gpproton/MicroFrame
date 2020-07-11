<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Logger Handlers class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame
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

use MicroFrame\Helpers\Reflect;
use MicroFrame\Helpers\Utils;

final class Logger {

    private $source;
    private $text;

    public function __construct($text = null, $source = null) {
        
        $this->text = $text;
        $this->source = $source;
    }

    public static function set($text = null, $source = null) {
        
        return new self($text, $source);
    }

    public function info()
    {
        $this->output(__FUNCTION__);
    }

    public function warn()
    {
        $this->output(__FUNCTION__);
    }

    public function error()
    {
        return $this->output(__FUNCTION__);
    }

    public function debug()
    {
        $this->output(__FUNCTION__);
    }

    public function fatal()
    {
        return $this->output(__FUNCTION__);
    }

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
                $this->console($output);
                break;
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

    private function console($string =  null) {
        Utils::console($string);
    }

    private function web($string =  null) {
        return $string;
    }

    private function file($string =  null, $path = null) {

        if (is_null($path)) $path = SYS_LOG_PATH .'/App.log';
        $oldDate =  date("d-m-Y", filemtime($path));
        $oldFile = SYS_LOG_PATH ."/{$oldDate}.app.log";

        // TODO: Maintenance for an auto delete for logs.

        if (date("d-m-Y") > $oldDate) rename($path, $oldFile);
        file_put_contents($path, $string, FILE_APPEND);

    }

    /**
     * TODO: Future use case
     * @param null $string
     */
    private function email($string =  null) {

    }



}
