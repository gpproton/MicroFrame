<?php
/**
 * Default controller class
 *
 * PHP Version 7
 *
 * @category  DefaultController
 * @package   MicroFrame\Defaults\Controller
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

namespace MicroFrame\Defaults\Controller;

defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Core\Controller as Core;
use MicroFrame\Handlers\Markdown;
use MicroFrame\Library\File;
use MicroFrame\Library\Strings;

class HelpController extends Core
{
    /**
     *
     * Default controller index method
     */
    public function index()
    {

        $currentPath = $this->request->path(false);
        $basePath = Strings::filter($this->request->url())->replace([$currentPath, '//', ':/'], ['', '/', '://'])->value();

        $rootPath = APP_PATH . '/Docs/';
        $reveal = '';
        $markdownString = '';
        $rootUrl = Strings::filter($basePath)
            ->append('help')
            ->value();

        $requestedDirectory = Strings::filter($this->request->url())
            ->range("help/")
            ->value();

        $requestedFile = Strings::filter($rootPath . $requestedDirectory . '.md')->replace('-', ' ')->value();

        if (file_exists($requestedFile)) {

            /**
             * Start HTML unordered parsing.
             */

            $files = File::init()->dirStructure($rootPath);
            $folderStructure = '';
            asort($files);

            /**
             * Create a structured HTML unordered list.
             *
             * @param $array
             */
            $getConstr = function ($array) use (&$reveal, &$getConstr, $rootPath, &$folderStructure, $rootUrl) {

                /**
                 * Loop through documentation directory contents.
                 */
                foreach ($array as $key => $value) {

                    /**
                     * Add a list item.
                     */
                    if (gettype($key) === 'integer' && Strings::filter($value)->contains('.md')) {
                        $currentFile = Strings::filter($value)
                            ->replace(['.md', ' '], ['', '-'])
                            ->upperCaseWords()
                            ->value();

                        /**
                         * get absolute file path for confirming existence.
                         */
                        $fileInst = Strings::filter($rootPath . $folderStructure . $value)->replace(['//', '///'], ['/', '/'])->value();

                        /**
                         * get relative path for url
                         */
                        $fileInstance = '';
                        if (file_exists($fileInst)) {
                            $fileInstance = Strings::filter($folderStructure . $currentFile)->replace(['//', '///'], ['/', '/'])->value();

                        }
                        /**
                         * A workaround to return to parent folder from a deep nesting.
                         */
                        else {
                            while(!file_exists($fileInst)) {
                                $subdir = File::init()->relativePath($rootPath, dirname(dirname($fileInst)));
                                $subdir = Strings::filter($subdir)->replace('./', '/')->value();

                                /**
                                 * get absolute file path for confirming existence.
                                 */
                                $fileInst = Strings::filter($rootPath . $subdir . $value)->replace(['//', '///'], ['/', '/'])->value();
                                if (file_exists($fileInst)) {
                                    $folderStructure = $subdir;
                                    $fileInstance = Strings::filter($folderStructure . $currentFile)->replace(['//', '///'], ['/', '/'])->value();
                                }
                            }

                        }

                        /**
                         * Final relative file path.
                         */
                        if (strpos($fileInstance, '/') === false) $fileInstance = '/' . $fileInstance;

                        /**
                         * Add list item to string.
                         */
                        $currentFile = Strings::filter($currentFile)->replace('-', ' ')->value();
                        $reveal .= <<<HTML
                    <li><div class="divider"></div></li>
                    <li><a href="{$rootUrl}{$fileInstance}">{$currentFile}</a></li>
HTML;

                    }

                    /**
                     * Add an unordered list item and it's children items.
                     */
                    if (gettype($value) === 'array' &&
                        gettype($key) !== 'integer') {
                        arsort($value);

                        /**
                         * New folder path.
                         */
                        if (is_dir($rootPath . $folderStructure . '/' . $key . '/')) {
                            $folderStructure = $folderStructure . '/' . $key . '/';
                        } else {
                            $folderStructure = '/' . $key . '/';
                        }
                        $folderStructure = Strings::filter($folderStructure)->replace(['//', '///'], ['/', '/'])->value();

                        /**
                         * Temp value for injecting items.
                         */
                        $tempKey = $key . rand(0, 100);

                        /**
                         * Start of wrapper.
                         */
                        $reveal .= <<<HTML
        <li><div class="divider"></div></li>
         <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header">{$key}</a>
                        <div class="collapsible-body">
                            <ul>
                                {$tempKey}
HTML;

                        /**
                         * Add all children items.
                         */
                        $reveal = str_replace($tempKey, $getConstr($value), $reveal);

                        /**
                         * End of wrapper
                         */
                        $reveal .= <<<HTML
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
HTML;
                    }
                }
            };
            $getConstr($files);
            $markdownString = file_get_contents($requestedFile);
        }



        $html = Markdown::translate($markdownString);

        if ($requestedDirectory === 'help'
            || $requestedDirectory === ''
        || Strings::filter($requestedDirectory)->contains('http')) {
            $pathValue = '';
        } else {
            $pathValue = Strings::filter($requestedDirectory)
                ->replace('help/', '')
                ->value();
        }
        /**
         * Default variables.
         * resources $root
         * $url
         * $path
         *
         */
        $this->response
            ->data(
                [
                    'html' => $html,
                    'menu' => $reveal,
                    'rootUrl' => $rootUrl,
                    'paths' => $pathValue
                ]
            )
            ->render('sys.help');
    }
}