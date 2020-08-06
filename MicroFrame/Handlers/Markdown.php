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

    }

    /**
     *
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

    private function reFormatList($string) {
        if ($string == '<li>') {
            $this->html = str_replace($string, '<li style="all: revert;">', $this->html);
        } elseif ($string == '<ul>') {
            $this->html = str_replace($string, '<ul style="all: revert;">', $this->html);
        } elseif ($string == '<ol>') {
            $this->html = str_replace($string, '<ol style="all: revert;">', $this->html);
        }
    }

    private function templateBuilder() {

    }

}