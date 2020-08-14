<?php
/**
 * Console Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Class Console
 * @package MicroFrame\Core
 */
class Console
{
    private $raw;

    public static function init()
    {
        return new self();
    }

    private function getRaws()
    {
        /**
         * Allowed short keys
         */
        $shortInput = "t:";
        $shortInput .= "c::";
        $shortInput .= "v::";
        $shortInput .= "phq";

        /**
         * Allowed long keys
         */
        $longInput  = array(
            "task:",
            "timeout::",
            "variables::",
            "persist",
            "help",
            "quiet",
            "verbose"
        );

        $this->raw = getopt($shortInput, $longInput);
    }

    private function formatList()
    {
        // TODO: Format comma separated values
    }

    private function formatArray()
    {
        // TODO: Format string defined key array separated values
    }

    public function getFormatted()
    {
    }

    /**
     *
     */
    private function response()
    {
        // TODO: Defines response for commands that require no task calls or are not variables
    }

    private function state()
    {
        // TODO: Set
    }

    public function execute()
    {
        $this->getRaws();

        // TODO: Set what's neXt
        var_dump($this->raw);
    }
}
