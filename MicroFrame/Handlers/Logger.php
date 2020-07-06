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

use MicroFrame\Helpers\Utils;

final class Logger {

    public function __construct()
    {

    }

    public static function info($output = null, $classPath = __CLASS__)
    {
        self::output("Info", $output, $classPath);
    }

    public static function warn($output = null, $classPath = __CLASS__)
    {
        self::output("Warn", $output, $classPath);
    }

    public static function error($output = null, $classPath = __CLASS__)
    {
        return self::output("Error", $output, $classPath);
    }

    public static function debug($output = null, $classPath = __CLASS__)
    {
        self::output("Debug", $output, $classPath);
    }

    public static function fatal($output = null, $classPath = __CLASS__)
    {
        return self::output("Fatal", $output, $classPath);
    }

    private static function output($type, $output, $classExec)
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
                break;
        }
        $output = date("[Y-m-d H:i:s]") . "\t[". $type
            ."]\t[". $classExec ."]\t"
            . $output ."\n";

        switch ($type) {
            case 'Info':
                self::console($output);
                break;
            case 'Warn':
                self::console($output);
                self::file($output);
                break;
            case 'Error':
                self::console($output);
                self::file($output);
                return self::web();
            case 'Debug':
                self::console($output);
                return $output;
            default:
                self::console($output);
                self::file($output);
                self::email($output);
                return self::web();
        }

    }

    private static function console($string =  null) {
        Utils::console($string);
    }

    private static function web($string =  null) {
        return $string;
    }

    private static function file($string =  null, $path = null) {

        if (is_null($path)) $path = SYS_LOG_PATH .'/App.log';
        $oldDate =  date("d-m-Y", filemtime($path));
        $oldFile = SYS_LOG_PATH ."/{$oldDate}.app.log";

        if (date("d-m-Y") > $oldDate) rename($path, $oldFile);
        file_put_contents($path, $string, FILE_APPEND);

    }

    /**
     * TODO: Future use case
     * @param null $string
     */
    private static function email($string =  null) {

    }



}
