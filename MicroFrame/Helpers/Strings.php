<?php

/**
 * Strings helper class
 * 
 * PHP Version 5
 * 
 * @category  Helpers
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

namespace MicroFrame\Helpers;

final class Strings
{
    /**
     * Registers stuffs.
     *
     * @param string $urlPath Get current full URL path
     * 
     * @return string
     */
    public static function urlIllegalCheckr($urlPath)
    {
        return preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $urlPath) == 0;
    }
    
}