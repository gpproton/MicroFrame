<?php
/**
 * Strings Library class
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
 * Class Strings
 * @package MicroFrame\Library
 */
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
     * @param string $replace
     * @return Strings
     */
    public function replace($search = null, $replace = "") {
        if (gettype($search) === 'array' && gettype($replace) === 'array') {
            $cnt = 0;
            foreach ($search as $val) {
                $this->value = str_replace($val, $replace[$cnt], $this->value);
                $cnt++;
            }
        } else {
            $this->value = str_replace($search, $replace, $this->value);
        }

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

        if (empty($string) || $ini == 0) return $this;
        $ini += strlen($start);
        $len = strrpos($string, $end, $ini) - $ini;
        $this->value = substr($string, $ini, $len);

        return $this;
    }

    /**
     * @param null $search The string to mark as start point.
     * @param bool $startRight if true picks position last occurring character or the particular count the char repeated.
     * @param bool $leftSelect If true selects text to the left of search text.
     * @param int $length The length of string to return.
     * @return $this
     */
    public function range($search = null, $startRight = false, $leftSelect = false, $length = 0) {
        if (empty($search)) return $this;
        $string  = $this->value;
        $position = 0;
        if (gettype($startRight) === 'boolean') {
            $left = strrpos($string, $search);
            $right = strpos($string, $search);
            gettype($left) === 'boolean' ? $position = 0 : $position = $startRight ? ($left + 1) : ($right + strlen($search));
        } else if (gettype($startRight) === 'integer') {
            $position = $this->charPosition($this->value, $search, $startRight);
            $position = $position === false ? 0 : $position + 1;
        }

        if ($position !== 0) {
            $string = $leftSelect ? substr($string, 0, $position - strlen($search)) : substr($string, $position);
            $string = $length > 0 ? substr($string, 0, $length) : $string;
            $this->value = $string;
        }

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
     * Get exact position of character or words in string on the repeat instance.
     *
     * @param $haystack
     * @param $needle
     * @param $number
     * @return false|int
     */
    public function charPosition($haystack, $needle, $number) {
        if($number == '1') {
            return strpos($haystack, $needle);
        } else if($number > '1'){
            return strpos($haystack, $needle, $this->charPosition($haystack, $needle, $number - 1) + strlen($needle));
        }
        return 0;
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
     * @param bool $check
     * @return $this
     */
    public function dotted($check = true) {
        if ($check) $this->value = preg_replace('/[^A-Za-z0-9.\-]/', '',
            str_replace("/", ".", $this->value));

        return $this;
    }

    public function append($string) {
        $this->value .= $string;

        return $this;
    }

    /**
     * @param null $string
     * @return $this
     */
    public function leftTrim($string = null) {
        if (is_null($string)) {
            $this->value = ltrim($this->value);
        } else if(gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = ltrim($this->value, $val);
            }
        } else {
            $this->value = ltrim($this->value, $string);
        }

        return $this;
    }

    /**
     * @param null $string
     * @return $this
     */
    public function rightTrim($string = null) {
        if (is_null($string)) {
            $this->value = rtrim($this->value);
        } else if(gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = rtrim($this->value, $val);
            }
        } else {
            $this->value = rtrim($this->value, $string);
        }

        return $this;
    }

    public function trim($string = null) {
        if (is_null($string)) {
            $this->value = trim($this->value);
        } else if(gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = trim($this->value, $val);
            }
        } else {
            $this->value = trim($this->value, $string);
        }

        return $this;
    }

    /**
     * @return null | string | boolean
     */
    public function value() {
        return $this->value;
    }
    
}