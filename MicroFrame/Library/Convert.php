<?php
/**
 * Conversion Library class
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   MicroFrame\Library
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

namespace MicroFrame\Library;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class Convert
 * @package MicroFrame\Library
 */
class Convert
{

    /**
     * @param $array
     * @param string $type
     * @return false|mixed|string
     */
    public static function arrays($array, $type = 'json') {

        /**
         * Reformat array to fix object issues.
         */
        $array = json_decode(json_encode($array), true);

        if (strpos($type, 'xml') !== false) {
            $encoder = new XmlEncoder();
            return $encoder->encode($array, 'xml');
        } elseif (strpos($type, 'yaml') !== false) {
            $encoder = new YamlEncoder();
            return $encoder->encode($array, 'yaml');
        } else {
            $encoder = new JsonEncoder();
            return $encoder->encode($array, 'json');
        }
    }
}