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

use Noodlehaus\Config;
use Noodlehaus\Parser\Yaml;

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
        $rootIterateCheck = false;

        $requestedPath = Strings::filter($this->request->url())
            ->range("help/")
            ->value();

        if (empty($requestedPath) || Strings::filter($requestedPath)->contains('http')) {
            $requestedFile = CORE_PATH . '/Defaults/Markdown/Default.md';
        } else {
            $requestedFile = Strings::filter($rootPath . $requestedPath . '.md')->replace('-', ' ')->value();
        }

        if (file_exists($requestedFile)) {

            /**
             * Start HTML unordered parsing.
             */

            $folderStructure = '';

            /**
             * Create a structured HTML unordered list.
             *
             * @param $array
             * @param $rootPath
             */
            $getConstr = function ($array, $rootPath) use (&$reveal, &$getConstr, &$folderStructure, $rootUrl, $rootIterateCheck) {

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
                        if (empty($folderStructure)) $folderStructure = '/';
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

                        if ($rootPath === CORE_PATH . '/Defaults/Markdown') {
                            $rootUrl = '#';
                        } elseif ($rootPath !== APP_PATH . '/Docs/') {
                            /**
                             * Change root path
                             */
                            $requestLoc = '/' . Strings::filter($rootPath)->replace(APP_PATH . '/Docs/')->value();
                            if (!Strings::filter($rootUrl)->contains($requestLoc) && !$rootIterateCheck) {
                                $rootIterateCheck = true;
                                $rootUrl .= $requestLoc;
                            }

                        }

                        $reveal .= <<<HTML
                    <li><div class="divider divider-restyle"></div></li>
                    <li class="list-restyle"><a class="link-restyle" href="{$rootUrl}{$fileInstance}">{$currentFile}</a></li>
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
        <li><div class="divider divider-restyle"></div></li>
         <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="">
                        <a class="collapsible-header link-restyle">{$key} &nbsp;&nbsp;&nbsp; <span style="color: indianred">&nbsp;></span></a>
                        <div class="collapsible-body">
                            <ul>
                                {$tempKey}
HTML;

                        /**
                         * Add all children items.
                         */
                        $reveal = str_replace($tempKey, $getConstr($value, $rootPath), $reveal);

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

            $markdownString = file_get_contents($requestedFile);
        }

        if ($requestedPath === 'help'
            || $requestedPath === ''
        || Strings::filter($requestedPath)->contains('http')) {
            $pathValue = '';
            $markdownString = file_get_contents(CORE_PATH . '/Defaults/Markdown/Default.md');
        } else {
            $pathValue = Strings::filter($requestedPath)
                ->replace('help/', '')
                ->value();
        }

        /**
         * Get options start and end substr positions.
         */
        $startPos = Strings::filter($markdownString)
            ->charPosition($markdownString, '---', 1);

        if ($startPos === 0) {
            $endPos = Strings::filter($markdownString)
                ->charPosition($markdownString, '---', 2);


            $options = substr($markdownString, $startPos, $endPos);
            $options = new Config($options, new Yaml, true);
            $options = $options->all();
        } else {
            $options = [];
            $endPos = 0;
        }

        $rootSetup = '';
        if (isset($options['root'])) {
            $rootSetup = $options['root'];
            if (strpos($rootSetup, '/') === 0 && $rootSetup !== '/') {
                $rootSetup = Strings::filter($rootSetup)->range('/', false)->value();
            }
        }


        /**
         * Check for config, if not available use requested file path as menu root.
         */

        if ($rootSetup === '/') {
            $rootPath = $rootPath . '';
        } elseif (!empty($rootSetup) && is_dir($rootPath . $rootSetup)) {
            $rootPath = $rootPath . $rootSetup;
        } else {
            $rootPath = dirname($requestedFile);
        }

        /**
         * Initialize menu builder.
         */
        if (is_dir($rootPath)) {
            $files = File::init()->dirStructure($rootPath);
            asort($files);
            /**
             * Call menu builder function.
             */
            if (isset($getConstr)) $getConstr($files, $rootPath);

        }

        /**
         * Remove options only if configuration details are present.
         */
        $markdownString = $startPos !== 0 ? $markdownString : str_replace(substr($markdownString, $startPos, $endPos + 3), '', $markdownString);

        /**
         * Convert markdown to HTML
         */
        $html = Markdown::translate($markdownString);

        /**
         * Default variables.
         * resources $root
         * $url
         * $path
         * $base Base url for site.
         *
         */
        $this->response
            ->data(
                [
                    'html' => $html,
                    'menu' => $reveal,
                    'rootUrl' => $rootUrl,
                    'paths' => $pathValue,
                    'options' => $options
                ]
            )
            ->middleware(isset($options['middleware']) ? $options['middleware'] : 'default')
            ->render('sys.help');
    }
}