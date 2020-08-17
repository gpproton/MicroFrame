<?php
/**
 * Console Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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
 * Console class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
class Console
{
    /**
     * Console arg all in an array.
     *
     * @var array
     */
    private $_raw;

    /**
     * Static init for console class.
     *
     * @return self
     */
    public static function init()
    {
        return new self();
    }

    /**
     * Process all console input.
     *
     * @return void
     */
    private function _getRaws()
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

        $this->_raw = getopt($shortInput, $longInput);
    }

    /**
     * A placeholder
     *
     * @return void
     */
    private function _formatList()
    {
        // TODO: Format comma separated values
    }

    /**
     * A placeholder
     *
     * @return void
     */
    private function _formatArray()
    {
        // TODO: Format string defined key array separated values
    }

    /**
     * A placeholder
     *
     * @return void
     */
    public function getFormatted()
    {
    }

    /**
     * A placeholder
     *
     * @return void
     */
    private function _response()
    {
        // TODO: Defines response for commands that
        // require no task calls or are not variables
    }

    /**
     * A placeholder
     *
     * @return void
     */
    private function _state()
    {
        // TODO: Set
    }

    /**
     * A placeholder
     *
     * @return void
     */
    public function execute()
    {
        $this->_getRaws();

        // TODO: Set what's neXt
        var_dump($this->_raw);
    }
}
