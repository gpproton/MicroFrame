<?php

/**
 * Markdown Handlers class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;

defined('BASE_PATH') or exit('No direct script access allowed');

use cebe\markdown\MarkdownExtra;
use MicroFrame\Library\Config;
use MicroFrame\Library\Strings;

/**
 * Markdown class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Markdown extends MarkdownExtra
{
    /**
     * Hold the HTML contents to output.
     *
     * @var string
     */
    private $_html;

    /**
     * Static method to handles conversion.
     *
     * @param string $markdownString here
     *
     * @return string
     */
    public static function translate($markdownString = "")
    {
        $instance = new self();
        $instance->html5 = true;

        return $instance->parse($markdownString);
    }

    /**
     * Static init for markdown class.
     *
     * @return Markdown
     */
    public static function init()
    {
        return new self();
    }

    /**
     * Internal text parsing.
     *
     * @param string $text here
     *
     * @return string
     */
    public function parse($text)
    {
        $this->_html = parent::parse($text);

        /**
         * Make additional markup changes.
         */
        $this->_modifyMarkup();

        return $this->_html;
    }

    /**
     * Sort markdown for a strike through
     *
     * @param string $markdown here
     *
     * @marker ~~
     *
     * @return array
     */
    protected function parseStrike($markdown)
    {
        /**
         * Check whether the marker really represents a
         * strikethrough (i.e. there is a closing ~~)
         */
        if (preg_match('/^~~(.+?)~~/', $markdown, $matches)) {
            return [
                ['strike', $this->parseInline($matches[1])],
                /**
                 * Return the offset of the parsed text
                 */
                strlen($matches[0])
            ];
        }
        /**
         * In case we did not find a closing ~~ we
         * just return the marker and skip 2 characters
         */
        return [['text', '~~'], 2];
    }

    /**
     * Rendering is the same as for block elements,
     * we turn the abstract syntax array into a string.
     *
     * @param string $element here
     *
     * @return string
     */
    protected function renderStrike($element)
    {
        return '<del>' . $this->renderAbsy($element[1]) . '</del>';
    }

    /**
     * Method to handle a modification of a markdown string.
     *
     * @return void
     */
    private function _modifyMarkup()
    {

        /**
         * Apply character replacement with private
         * methods executed here.
         */

        /**
         * Render checked input in place.
         */
        $this->_translateTodo('[X]');

        /**
         * Render unchecked input in place
         */
        $this->_translateTodo('[ ]');

        /**
         * Fix any previous css library modification on lists elements.
         */
        $this->_reFormatList('<li>');
        $this->_reFormatList('<ul>');
        $this->_reFormatList('<ol>');

        /**
         * Changes github icon markdowns to HTML markup.
         */
        $this->parseIcons();
    }

    /**
     * Change check annotations and convert to html
     *
     * @param string $string here
     *
     * @return string
     */
    private function _translateTodo($string)
    {
        if ($string == '[X]') {
            $this->_html = str_replace($string, '<input type="checkbox" style="all: revert;" checked onclick="return false">', $this->_html);
        } elseif ($string == '[ ]') {
            $this->_html = str_replace($string, '<input type="checkbox" style="all: revert;" onclick="return false">', $this->_html);
        }
    }

    /**
     * Fix any external CSS library effect on core elements.
     *
     * @param string $string here
     *
     * @return string
     */
    private function _reFormatList($string)
    {
        if ($string == '<li>') {
            $this->_html = str_replace($string, '<li style="all: revert;">', $this->_html);
        } elseif ($string == '<ul>') {
            $this->_html = str_replace($string, '<ul style="all: revert;">', $this->_html);
        } elseif ($string == '<ol>') {
            $this->_html = str_replace($string, '<ol style="all: revert;">', $this->_html);
        }
    }

    /**
     * Changes github icon markdowns to HTML markup.
     *
     * @param null $string here
     *
     * @return string|string[]|null
     */
    public function parseIcons($string = null)
    {
        $return = false;
        if (is_null($string)) {
            $string = $this->_html;
        } else {
            $return = true;
        }

        $requestedAnnotation = Strings::filter($string)->between(':', ':', false, true, false, 30);

        if (sizeof($requestedAnnotation) > 0) {
            $emoji = DATA_PATH . Config::fetch('system.path.emoji.path');
            $emoji = file_get_contents($emoji);
            $emoji = json_decode($emoji, true);
            foreach ($requestedAnnotation as $iconKey) {
                if (isset($emoji[$iconKey])) {
                    $realKey = ':' . $iconKey . ':';
                    $iconUrl = $emoji[$iconKey];
                    $newMarkup = "<img class='markdown-emoji' title='{$iconKey}' alt='{$iconKey}' src='{$iconUrl}' align='absmiddle'>";
                    $string = str_replace($realKey, $newMarkup, $string);
                }
            }
            if ($return) {
                return $string;
            }
            $this->_html = $string;
        }
    }
}
