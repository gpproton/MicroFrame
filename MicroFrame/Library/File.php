<?php
/**
 * File Library class
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

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function App\Controller\getRelativePath;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Class File
 *
 * @category Library
 * @package  MicroFrame\Library
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
final class File
{


    /**
     * File class static initializer
     *
     * @return File
     */
    public static function init()
    {
        return new self();
    }

    /**
     * Clears old files in a directory above the number of days specified
     *
     * @param string $path here
     * @param int    $days here
     *
     * @return void
     */
    public function clearOld($path, $days = 3)
    {
        $files = glob($path ."/*");
        $now   = time();

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= 60 * 60 * 24 * $days) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Check for files directory and recursively in child directories.
     *
     * @param string $basePath     here
     * @param string $relativeBase where relative root starts
     * @param string $contains     filter text contain
     * @param int    $filter       text ignore
     *
     * @summary While checking through directories
     * allow or disallow matching string patterns
     * also setting of preferred base path and
     *
     * @return array
     */
    public function filesInDirectory(
        $basePath = __DIR__,
        $relativeBase = __DIR__,
        $contains = ".php",
        $filter = ".ini" | ".md" | ".DS_Store"
    ) {
        $files = array();
        $dirIterator = new RecursiveDirectoryIterator($basePath);
        $fileIterator = new RecursiveIteratorIterator($dirIterator);
        foreach ($fileIterator as $filename) {
            if ($filename->isDir()) {
                continue;
            }
            $file = $this->relativePath($relativeBase, $filename);
            if (Strings::filter($file)->contains($contains)
                && !Strings::filter($file)->contains($filter)
            ) {
                $files[] = $file;
            }
        }

        return $files;
    }

    /**
     * Returns an associative array of a directory and all it contents.
     *
     * @param string $basePath here
     *
     * @return array
     */
    public function dirStructure($basePath = __DIR__)
    {
        $dirIterator = new RecursiveDirectoryIterator($basePath);
        $fileIterator = new RecursiveIteratorIterator(
            $dirIterator,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        $fileSys = array();
        $path = array();
        foreach ($fileIterator as $splFileInfo) {
            if ($splFileInfo->getFilename() !== '.'
                || $splFileInfo->getFilename() !== '..'
            ) {
                $path = $splFileInfo->isDir()
                ? array($splFileInfo->getFilename() => array())
                : array($splFileInfo->getFilename());
            }

            for ($depth = $fileIterator->getDepth() - 1; $depth >= 0; $depth--) {
                $instFile = $fileIterator
                    ->getSubIterator($depth)->current()->getFilename();

                if (!isset($path['.']) && !isset($path['..'])) {
                    $path = array($instFile => $path);
                }
            }

            $fileSys = array_merge_recursive($fileSys, $path);
            unset($fileSys['.']);
            unset($fileSys['..']);
        }

        return $fileSys;
    }

    /**
     * Returns relative path of a file from specified
     * directory
     *
     * @param string $from here
     * @param string $to   here
     *
     * @return string
     */
    public function relativePath($from, $to)
    {
        /**
         * Compatibility fixes for Windows paths
         */
        $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
        $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
        $from = str_replace('\\', '/', $from);
        $to   = str_replace('\\', '/', $to);

        $from     = explode('/', $from);
        $to       = explode('/', $to);
        $relPath  = $to;
        foreach ($from as $depth => $dir) {
            /**
             * Find first non-matching dir
             */
            if ($dir === $to[$depth]) {
                /**
                 * Ignore this directory
                 */
                array_shift($relPath);
            } else {
                /**
                 * Get number of remaining dirs to $from
                 */
                $remaining = count($from) - $depth;
                if ($remaining > 1) {
                    /**
                     * Add traversals up to first matching dir
                     */
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './' . $relPath[0];
                }
            }
        }
        return implode('/', $relPath);
    }
}
