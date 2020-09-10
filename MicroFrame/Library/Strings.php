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

use MicroFrame\Core\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Strings Class
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Strings extends Core
{
    /**
     * String entered for modification.
     *
     * @var string
     */
    private $_value;

    /**
     * Strings constructor.
     *
     * @param null $string here
     *
     * @return void|self
     */
    public function __construct($string = null)
    {
        $this->_value = $string;
    }

    /**
     * Validates in value is a string.
     *
     * @return bool
     */
    private function _validate()
    {
        return (getType($this->_value) === 'string');
    }

    /**
     * Allow to return character counts in a string.
     *
     * @return int|void
     */
    private function _count()
    {
        return strlen($this->_value);
    }

    /**
     * The string helper static initializer.
     *
     * @param string $string here
     *
     * @return Strings
     */
    public static function filter($string = null)
    {
        return new self($string);
    }

    /**
     * A method to replace strings with multiple replacement option available.
     *
     * @param null   $search  here
     * @param string $replace here
     *
     * @return self
     */
    public function replace($search = null, $replace = "")
    {
        if (gettype($search) === 'array' && gettype($replace) === 'array') {
            $cnt = 0;
            foreach ($search as $val) {
                $this->_value = str_replace($val, $replace[$cnt], $this->_value);
                $cnt++;
            }
        } else {
            $this->_value = str_replace($search, $replace, $this->_value);
        }

        return $this;
    }

    /**
     * An integrated method to check if sub string existing main string.
     *
     * @param null $string here
     *
     * @return boolean|self
     */
    public function contains($string = null)
    {
        if (!$this->_validate()) {
            return $this;
        }

        if (!empty($string)) {
            return strpos($this->_value, $string) !== false;
        }

        return false;
    }

    /**
     * Cut string between two different characters.
     *
     * No value method required, if the 4th & 5th are true, false an array of string
     * is returned that matched the conditions.
     * The 3rd parameter specifies if the that start
     * and end delimiter will be included in result
     * The 6th parameter specify the max string length that will be returned.
     *
     * @param null $start             here
     * @param null $end               here
     * @param bool $includeDelimiters here
     * @param bool $array             here
     * @param bool $forceString       here
     * @param int  $count             here
     * @param int  $offset            here
     *
     * @return self|array
     */
    public function between(
        $start = null,
        $end = null,
        $includeDelimiters = false,
        $array = false,
        $forceString = true,
        $count = -1,
        int &$offset = 0
    ) {
        $string  = $this->_value;

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
            $length = $endPos - $startPos + ($includeDelimiters
                    ? $endLength : -$startLength);
            if (!$length) {
                return $this;
            }
            $offset = $startPos + ($includeDelimiters ? 0 : $startLength);
            $result = substr($string, $offset, $length);

            $this->_value = ($result !== false ? $result : null);

            return $this;
        } else {
            $strings = [];
            $length = strlen($string);
            while ($offset < $length) {
                $found = self::filter($string)->between(
                    $start,
                    $end,
                    $includeDelimiters,
                    false,
                    true,
                    $count,
                    $offset
                )->value();
                if ($found === null) {
                    break;
                }
                $strings[] = $found;
                $offset += strlen(
                    $includeDelimiters
                    ? $found : $start . $found . $end
                );
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
     * Enable splitting as string based on a character and cutting
     * it by direction or string position equivalent to another direction.
     *
     * @param null $search     The string to mark as start point.
     * @param bool $startRight if true picks position last occurring
     *                         character or the particular count the char repeated.
     * @param bool $leftSelect If true selects text to the left of search text.
     * @param int  $length     The length of string to return.
     *
     * @return self
     */
    public function range(
        $search = null,
        $startRight = false,
        $leftSelect = false,
        $length = 0
    ) {
        if (empty($search)) {
            return $this;
        }
        $string  = $this->_value;
        $position = 0;
        if (gettype($startRight) === 'boolean') {
            $left = strrpos($string, $search);
            $right = strpos($string, $search);
            gettype($left) === 'boolean'
                ? $position = 0 : $position = $startRight
                ? ($left + 1) : ($right + strlen($search));
        } elseif (gettype($startRight) === 'integer') {
            $position = $this->charPosition($this->_value, $search, $startRight);
            $position = $position === false ? 0 : $position + 1;
        }

        if ($position !== 0) {
            $string = $leftSelect
                ? substr($string, 0, $position - strlen($search))
                : substr($string, $position);
            $string = $length > 0 ? substr($string, 0, $length) : $string;
            $this->_value = $string;
        }

        return $this;
    }

    /**
     * Change either the first word or all words fir character to upper case
     *
     * @param bool $all here
     *
     * @return self
     */
    public function upperCaseWords($all = true)
    {
        $string = $this->_value;
        $string = $all ? ucwords($string) : ucfirst($string);
        $this->_value = $string;

        return $this;
    }

    /**
     * Change a text to upper case
     *
     * @return self
     */
    public function upperCaseAll()
    {
        $this->_value = strtoupper($this->_value);

        return $this;
    }

    /**
     * Change a text to lower case
     *
     * @param bool $first here
     *
     * @return self
     */
    public function lowerCase($first = false)
    {
        $this->_value = $first ? lcfirst($this->_value) : strtolower($this->_value);

        return $this;
    }

    /**
     * Get exact position of character or words in string on the repeat instance.
     *
     * @param string $haystack here
     * @param string $needle   here
     * @param int    $number   here
     *
     * @return false|int
     */
    public function charPosition($haystack, $needle, $number)
    {
        if ($number == '1') {
            return strpos($haystack, $needle);
        } elseif ($number > '1') {
            return strpos(
                $haystack,
                $needle,
                $this->charPosition(
                    $haystack,
                    $needle,
                    $number - 1
                ) + strlen($needle)
            );
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
        if (!$this->_validate()) {
            return $this;
        }

        $this->_value = preg_match(
            '/^[^.][-a-z0-9_.]+[a-z]$/i',
            $this->_value
        ) == 0;
        return $this->_value;
    }

    /**
     * Change a slashed string to dot and all some characters
     *
     * @param bool $check here
     *
     * @return self
     */
    public function dotted($check = true)
    {
        if ($check) {
            $this->_value = preg_replace(
                '/[^A-Za-z0-9.\-]/',
                '',
                str_replace("/", ".", $this->_value)
            );
        }

        return $this;
    }

    /**
     * Allow append to string
     *
     * @param string $string here
     *
     * @return self
     */
    public function append($string)
    {
        if (!empty($string)) {
            $this->_value .= $string;
        }

        return $this;
    }

    /**
     * Allow pre append to string.
     *
     * @param string $string here
     *
     * @return self
     */
    public function preAppend($string)
    {
        if (!empty($string)) {
            $this->_value = $string . $this->_value;
        }

        return $this;
    }

    /**
     * Use to left trim a character from a string.
     *
     * @param null $string here
     *
     * @return self
     */
    public function leftTrim($string = null)
    {
        if (is_null($string)) {
            $this->_value = ltrim($this->_value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->_value = ltrim($this->_value, $val);
            }
        } else {
            $this->_value = ltrim($this->_value, $string);
        }

        return $this;
    }

    /**
     * Use to right trim a character from a string.
     *
     * @param null $string here
     *
     * @return self
     */
    public function rightTrim($string = null)
    {
        if (is_null($string)) {
            $this->_value = rtrim($this->_value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->_value = rtrim($this->_value, $val);
            }
        } else {
            $this->_value = rtrim($this->_value, $string);
        }

        return $this;
    }

    /**
     * Use to trim a character from a string from any direction.
     *
     * @param null $string here
     *
     * @return self
     */
    public function trim($string = null)
    {
        if (is_null($string)) {
            $this->_value = trim($this->_value);
        } elseif (gettype($string) === 'array') {
            foreach ($string as $val) {
                $this->_value = trim($this->_value, $val);
            }
        } else {
            $this->_value = trim($this->_value, $string);
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
        return $this->_value;
    }
}
