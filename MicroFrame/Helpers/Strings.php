<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Strings helper class
 * 
 * PHP Version 7
 * 
 * @category  Helpers
 * @package   MicroFrame
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

namespace MicroFrame\Helpers;

final class Strings
{

    private $value;

    /**
     * Strings constructor.
     * @param null $string
     */
    public function __construct($string = null)
    {
        $this->value = $string;
    }

    /**
     * @return bool
     */
    private function validate() {
        return (getType($this->value) === 'string');
    }

    /**
     * @return int|void
     */
    private function count() {
        return strlen($this->value);
    }

    /**
     * @param string $string
     * @return Strings
     */
    public static function filter($string = null) {

        return new self($string);
    }

    /**
     * @param null $search
     * @param null $replace
     * @return Strings
     */
    public function replace($search = null, $replace = null) {
        $this->value = str_replace($search, $replace, $this->value);
        return $this;
    }

    /**
     * @param null $string
     * @return boolean|$this
     */
    public function contains($string = null) {
        if (!$this->validate()) return $this;

        return strpos($this->value, $string) !== false;
    }

    /**
     * @param null $start
     * @param null $end
     * @return $this
     */
    public function between($start = null, $end = null) {
        $string  = $this->value;
        $ini = strpos($string, $start);
        echo $ini;
        if (empty($string) || $ini == 0) return $this;
        $ini += strlen($start);
        $len = strrpos($string, $end, $ini) - $ini;
        $this->value = substr($string, $ini, $len);

        return $this;
    }

    /**
     * @param null $search
     * @param bool $startRight
     * @param bool $leftTrim
     * @param int $length
     * @return $this
     */
    public function range($search = null, $leftTrim = false, $startRight = false, $length = 0) {
        if (empty($search)) return $this;
        $string  = $this->value;
        /** @var boolean $startRight */
        $position = $startRight ? strrpos($string, $search) : strpos($string, $search) + strlen($search);
        $string = $leftTrim ? substr($string, (strlen($string) - $position)) : substr($string, $position);
        $string = $length > 0 ? substr($string, 0, $length) : $string;
        $this->value = $string;

        return $this;
    }

    /**
     * @param bool $all
     * @return $this
     */
    public function upperCaseWords($all = true) {
        $string = $this->value;
        $string = $all ? ucwords($string) : ucfirst($string);
        $this->value = $string;

        return $this;
    }

    /**
     * @return $this
     */
    public function upperCaseAll() {
        $this->value = strtoupper($this->value);

        return $this;
    }

    /**
     * @param bool $first
     * @return $this
     */
    public function lowerCase($first = false) {

        $this->value = $first ? lcfirst($this->value) : strtolower($this->value);

        return $this;
    }

    /**
     * Filters url contents.
     *
     * @return bool|$this|null
     */
    public function url()
    {
        if (!$this->validate()) return $this;

        $this->value = preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i',
                $this->value) == 0;
        return $this->value;
    }

    /**
     * @return $this
     */
    public function dotted()
    {
        $this->value = preg_replace('/[^A-Za-z.\-]/', '',
            str_replace("/", ".", $this->value));
        return $this;
    }

    /**
     * @return null | string | boolean
     */
    public function value() {
        return $this->value;
    }
    
}