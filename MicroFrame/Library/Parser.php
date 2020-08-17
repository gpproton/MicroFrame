<?php
/**
 * Parser Library class
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

namespace MicroFrame\Library;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Yaml\Yaml as YamlEncoder;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Class Parser
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
class Parser
{

    /**
     * The array parser method
     *
     * @param array  $array array to be parsed.
     * @param string $type  format to be parsed into.
     *
     * @return false|mixed|string
     */
    public static function arrays($array, $type = 'json')
    {

        /**
         * Reformat array to fix object issues.
         */
        $array = json_decode(json_encode($array), true);

        if (strpos($type, 'xml') !== false) {
            $encoder = new XmlEncoder();
            return $encoder->encode($array, 'xml');
        } elseif (strpos($type, 'yaml') !== false) {
            return YamlEncoder::dump($array, 4);
        } else {
            $encoder = new JsonEncoder();
            return $encoder->encode($array, 'json');
        }
    }
}
