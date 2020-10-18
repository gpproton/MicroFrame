<?php

/**
 * Modes Validator class
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

namespace MicroFrame\Library\Validator;

/**
 * Modes Validator class
 *
 * @category Validator
 * @package  MicroFrame\Library\Validator
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Modes extends Validator
{
    /**
     * Check if script is running in CLI mode.
     *
     * @return bool
     */
    public function isCli(): bool
    {
        if (defined('STDIN')) {
            return true;
        }

        if (
            empty($_SERVER['REMOTE_ADDR'])
            && !isset($_SERVER['HTTP_USER_AGENT'])
            && count($_SERVER['argv']) > 0
        ) {
            return true;
        }

        return false;
    }
}
