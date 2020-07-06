<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Conversion helper class
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

class Convert
{

    private static function arrayJson($array) {
        return json_encode($array);
    }

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

    public static function arrays($array, $type = 'json') {
        if (strpos($type, 'xml') !== false) {
            return self::arrayXml($array);
        } else {
            return self::arrayJson($array);
        }
    }
}