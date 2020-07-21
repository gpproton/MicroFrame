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
defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Class Convert
 * @package MicroFrame\Library
 */
class Convert
{
    /**
     * @param $array
     * @return false|string
     */
    private static function arrayJson($array) {
        return json_encode($array);
    }

    /**
     * @param $array
     * @return mixed
     */
    private static function arrayXml($array) {
        function xmlParser($array, &$xmlElement) {
            foreach($array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xmlElement->addChild("$key");
                        xmlParser($value, $subnode);
                    }else{
                        $subnode = $xmlElement->addChild("item$key");
                        xmlParser($value, $subnode);
                    }
                }else {
                    $xmlElement->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }
        $xmlElement = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><root></root>");
        xmlParser($array,$xmlElement);
        return $xmlElement->asXML();
    }

    /**
     * @param $array
     * @param string $type
     * @return false|mixed|string
     */
    public static function arrays($array, $type = 'json') {
        if (strpos($type, 'xml') !== false) {
            return self::arrayXml($array);
        } else {
            return self::arrayJson($array);
        }
    }
}