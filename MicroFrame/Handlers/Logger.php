<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Logger Handlers class
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

final class Logger {

    public function __construct()
    {

    }

    public static function info($output = null)
    {
        self::output("info", $output);
    }

    public static function error($output = null)
    {
        self::output("error", $output);
    }

    public static function warn($output = null)
    {
        self::output("warn", $output);
    }

    public static function debug($output = null)
    {
        self::output("debug", $output);
    }

    private static function output($type, $output)
    {
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
                $output .= $output;
                break;
        }

        switch ($type) {
            case 'info':
                $type = "Info";
                break;
            case 'error':
                $type = "Error";
                break;
            case 'warn':
                $type = "Warn";
                break;
            case 'debug':
                $type = "Debug";
                break;
            default:
                $type = "Unknown";
                break;
        }

        $output = date("Y-m-d h:i:sa") . " {$type}: " . $output;

        // TODO: Plan output methods

    }

    private static function console() {

    }

    private static function web() {

    }

    private static function file() {

    }

    /**
     * TODO: Future use case
     */
    private static function email() {

    }



}
