<?php
/**
 * Markdown Handlers class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;

defined('BASE_PATH') OR exit('No direct script access allowed');

use cebe\markdown\MarkdownExtra;
use MicroFrame\Library\Config;
use MicroFrame\Library\Strings;

/**
 * Class Markdown
 * @package MicroFrame\Handlers
 */
class Markdown extends MarkdownExtra
{

    private $html;

    public static function translate($markdownString = "") {
        $instance = new self();
        $instance->html5 = true;

        return $instance->parse($markdownString);
    }

    public function parse($text)
    {
        $this->html = parent::parse($text);

        /**
         * Make additional markup changes.
         */
        $this->modifyMarkup();

        return $this->html;
    }

    /**
     * Sort markdown for a strike through
     *
     * @marker ~~
     * @param $markdown
     * @return array
     */
    protected function parseStrike($markdown)
    {
        /**
         * check whether the marker really represents a strikethrough (i.e. there is a closing ~~)
         */
        if (preg_match('/^~~(.+?)~~/', $markdown, $matches)) {
            return [
                ['strike', $this->parseInline($matches[1])],
                /**
                 * return the offset of the parsed text
                 */
                strlen($matches[0])
            ];
        }
        /**
         * in case we did not find a closing ~~ we just return the marker and skip 2 characters
         */
        return [['text', '~~'], 2];
    }

    /**
     * rendering is the same as for block elements, we turn the abstract syntax array into a string.
     *
     * @param $element
     * @return string
     */
    protected function renderStrike($element)
    {
        return '<del>' . $this->renderAbsy($element[1]) . '</del>';
    }

    private function modifyMarkup() {

        /**
         * Apply character replacement with private
         * methods executed here.
         *
         */

        /**
         * Render checked input in place.
         */
        $this->translateTodo('[X]');

        /**
         * Render unchecked input in place
         */
        $this->translateTodo('[ ]');

        /**
         * Fix any previous css library modification on lists elements.
         */
        $this->reFormatList('<li>');
        $this->reFormatList('<ul>');
        $this->reFormatList('<ol>');

        /**
         * Changes github icon markdowns to HTML markup.
         */
        $this->parseIcons();

    }

    /**
     * Change check annotations and convert to html
     *
     * @param $string
     */
    private function translateTodo($string) {

        if ($string == '[X]') {
            $this->html = str_replace($string, '<input type="checkbox" style="all: revert;" checked onclick="return false">', $this->html);
        } elseif ($string == '[ ]') {
            $this->html = str_replace($string, '<input type="checkbox" style="all: revert;" onclick="return false">', $this->html);
        }

    }

    /**
     * Fix any external CSS library effect on core elements.
     *
     * @param $string
     */
    private function reFormatList($string) {
        if ($string == '<li>') {
            $this->html = str_replace($string, '<li style="all: revert;">', $this->html);
        } elseif ($string == '<ul>') {
            $this->html = str_replace($string, '<ul style="all: revert;">', $this->html);
        } elseif ($string == '<ol>') {
            $this->html = str_replace($string, '<ol style="all: revert;">', $this->html);
        }
    }

    /**
     * Changes github icon markdowns to HTML markup.
     */
    private function parseIcons() {
        $requestedAnnotation = Strings::filter($this->html)->between(':', ':', false, true, false, 30);

        if (sizeof($requestedAnnotation) > 0) {
            $emoji = DATA_PATH . Config::fetch('system.path.emoji');
            $emoji = file_get_contents($emoji);
            $emoji = json_decode($emoji, true);
            foreach ($requestedAnnotation as $iconKey) {
                if (isset($emoji[$iconKey])) {
                    $realKey = ':' . $iconKey . ':';
                    $iconUrl = $emoji[$iconKey];
                    $newMarkup = "<img class='markdown-emoji' title='{$iconKey}' alt='{$iconKey}' src='{$iconUrl}' align='absmiddle'>";
                    $this->html = str_replace($realKey, $newMarkup, $this->html);
                }
            }
        }
    }


}