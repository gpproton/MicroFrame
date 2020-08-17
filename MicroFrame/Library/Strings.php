<?php
/**
 * Strings Library class
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

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Class Strings
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
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
     * validates in value is a string.
     *
     * @return bool
     */
    private function validate()
    {
        return (getType($this->value) === 'string');
    }

    /**
     * Allow to return character counts in a string.
     *
     * @return int|void
     */
    private function count()
    {
        return strlen($this->value);
    }

    /**
     * The string helper static initializer.
     *
     * @param string $string
     * @return Strings
     */
    public static function filter($string = null)
    {
        return new self($string);
    }

    /**
     * A method to replace strings with multiple replacement option available.
     *
     * @param null $search
     * @param string $replace
     * @return Strings
     */
    public function replace($search = null, $replace = "")
    {
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
     * An integrated method to check if sub string existing main string.
     *
     * @param null $string
     * @return boolean|$this
     */
    public function contains($string = null)
    {
        if (!$this->validate()) {
            return $this;
        }

        if (!empty($string)) {
            return strpos($this->value, $string) !== false;
        }

        return false;
    }

    /**
     * Cut string between two different characters.
     *
     * No value method required, if the 4th & 5th are true, false an array of string
     * is returned that matched the conditions.
     * The 3rd parameter specifies if the that start and end delimiter will be included in result
     * The 6th parameter specify the max string length that will be returned.
     *
     * @param null $start
     * @param null $end
     * @param bool $includeDelimiters
     * @param int $offset
     * @param bool $array
     * @param bool $forceString
     * @param int $count
     * @return $this | array
     */
    public function between($start = null, $end = null, $includeDelimiters = false, $array = false, $forceString = true, $count = -1, int &$offset = 0)
    {
        $string  = $this->value;

        if ($string === '' || $start === '' || $end === '') {
            return $this;
        }

        if (!$array && $forceString) {
            $startLength = strlen($start);
            $endLength = strlen($end);
            $startPos = strpos($string, $start, $offset);
            if ($startPos === false) {
                return $this;
            }
            $endPos = strpos($string, $end, $startPos + $startLength);
            if ($endPos === false) {
                return $this;
            }
            $length = $endPos - $startPos + ($includeDelimiters ? $endLength : -$startLength);
            if (!$length) {
                return $this;
            }
            $offset = $startPos + ($includeDelimiters ? 0 : $startLength);
            $result = substr($string, $offset, $length);

            $this->value = ($result !== false ? $result : null);

            return $this;
        } else {
            $strings = [];
            $length = strlen($string);
            while ($offset < $length) {
                $found = self::filter($string)->between($start, $end, $includeDelimiters, false, true, $count, $offset)->value();
                if ($found === null) {
                    break;
                }
                $strings[] = $found;
                $offset += strlen($includeDelimiters ? $found : $start . $found . $end);
            }

            if ($count >= 1) {
                $newStringArray = array();
                foreach ($strings as $stringValue) {
                    if (strlen($stringValue) <= $count) {
                        $newStringArray[] = $stringValue;
                    }
                }
                return $newStringArray;
            }
            return $strings;
        }
    }

    /**
     * Enable splitting as string based on a character and cutting it by direction or string position equivalent to another direction.
     *
     * @param null $search The string to mark as start point.
     * @param bool $startRight if true picks position last occurring character or the particular count the char repeated.
     * @param bool $leftSelect If true selects text to the left of search text.
     * @param int $length The length of string to return.
     * @return $this
     */
    public function range($search = null, $startRight = false, $leftSelect = false, $length = 0)
    {
        if (empty($search)) {
            return $this;
        }
        $string  = $this->value;
        $position = 0;
        if (gettype($startRight) === 'boolean') {
            $left = strrpos($string, $search);
            $right = strpos($string, $search);
            gettype($left) === 'boolean' ? $position = 0 : $position = $startRight ? ($left + 1) : ($right + strlen($search));
        } elseif (gettype($startRight) === 'integer') {
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
     * Change either the first word or all words fir character to upper case
     *
     * @param bool $all
     * @return $this
     */
    public function upperCaseWords($all = true)
    {
        $string = $this->value;
        $string = $all ? ucwords($string) : ucfirst($string);
        $this->value = $string;

        return $this;
    }

    /**
     * Change a text to upper case
     *
     * @return $this
     */
    public function upperCaseAll()
    {
        $this->value = strtoupper($this->value);

        return $this;
    }

    /**
     * Change a text to lower case
     *
     * @param bool $first
     * @return $this
     */
    public function lowerCase($first = false)
    {
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
    public function charPosition($haystack, $needle, $number)
    {
        if ($number == '1') {
            return strpos($haystack, $needle);
        } elseif ($number > '1') {
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
        if (!$this->validate()) {
            return $this;
        }

        $this->value = preg_match(
            '/^[^.][-a-z0-9_.]+[a-z]$/i',
            $this->value
        ) == 0;
        return $this->value;
    }

    /**
     * Change a slashed string to dot and all some characters
     *
     * @param bool $check
     * @return $this
     */
    public function dotted($check = true)
    {
        if ($check) {
            $this->value = preg_replace(
                '/[^A-Za-z0-9.\-]/',
                '',
                str_replace("/", ".", $this->value)
            );
        }

        return $this;
    }

    /**
     * Allow append to string
     *
     * @param $string
     * @return $this
     */
    public function append($string)
    {
        if (!empty($string)) {
            $this->value .= $string;
        }

        return $this;
    }

    /**
     * Allow pre append to string.
     *
     * @param $string
     * @return $this
     */
    public function preAppend($string)
    {
        if (!empty($string)) {
            $this->value = $string . $this->value;
        }

        return $this;
    }

    /**
     * Use to left trim a character from a string.
     *
     * @param null $string
     * @return $this
     */
    public function leftTrim($string = null)
    {
        if (is_null($string)) {
            $this->value = ltrim($this->value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = ltrim($this->value, $val);
            }
        } else {
            $this->value = ltrim($this->value, $string);
        }

        return $this;
    }

    /**
     * Use to right trim a character from a string.
     *
     * @param null $string
     * @return $this
     */
    public function rightTrim($string = null)
    {
        if (is_null($string)) {
            $this->value = rtrim($this->value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = rtrim($this->value, $val);
            }
        } else {
            $this->value = rtrim($this->value, $string);
        }

        return $this;
    }

    /**
     * Use to trim a character from a string from any direction.
     *
     * @param null $string
     * @return $this
     */
    public function trim($string = null)
    {
        if (is_null($string)) {
            $this->value = trim($this->value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->value = trim($this->value, $val);
            }
        } else {
            $this->value = trim($this->value, $string);
        }

        return $this;
    }

    /**
     * Get the resulting string.
     *
     * @return null | string | boolean
     */
    public function value()
    {
        return $this->value;
    }
}
