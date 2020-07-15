<?php
/**
 * Reflect helper class
 *
 * PHP Version 7
 *
 * @category  Helpers
 * @package   MicroFrame\Helpers
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

defined('BASE_PATH') OR exit('No direct script access allowed');

use ReflectionClass;

/**
 * Class Reflect
 * @package MicroFrame\Helpers
 */
class Reflect
{

    private static $sysPath = "MicroFrame\Defaults\\";
    private static $appPath = "App\\";
    /**
     * Reflect constructor.
     */
    public function __construct()
    {

    }

    /**
     * @summary Statically initialize class object
     */
    public static function check() {
        return new self();
    }

    /**
     * @param $type
     * @param $path
     * @param $args
     * @return bool|object
     * @throws ReflectionException
     */
    public function stateLoader($type, $path, $args = array()) {

        // TODO: Implement class and method filtering here.
        $base = "";
        $path = Strings::filter($path)
            ->dotted()
            ->replace(".", "\\")
            ->value();

        $core = Strings::filter($type)
            ->replace("sys.")
            ->replace("app.")
            ->value();

        $pathHandler = function ($base) use ($core, $path) {
            return "$base{$core}\\{$path}{$core}";
        };

        if (Strings::filter($type)->contains("sys")) {
            $path = $pathHandler(self::$sysPath);

        } else if ((Strings::filter($type)->contains("app"))) {
            $path = $pathHandler(self::$appPath);

        }

        if (!class_exists($path)) {
            // TODO: Implement method calling here, with a class a step down.
        }
        try {
            $classBuilder = new ReflectionClass($path);
        } catch (\ReflectionException $e) {
        }
        /** @var ReflectionClass $classBuilder */
        return $classBuilder->newInstanceArgs($args);
    }

    /**
     * @param $classInstance
     * @param $methodName
     * @param $paramArrays
     * @return mixed
     */
    public function methodLoader($classInstance, $methodName, $paramArrays = array()) {
        return call_user_func_array(
            array($classInstance, $methodName)
            , $paramArrays
        );
    }


    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class"
     *
     * @param $filePathName
     *
     * @return  string
     */
    public function getClassFullNameFromFile($filePathName)
    {
        return $this->getClassNamespaceFromFile($filePathName) . '\\' . $this->getClassNameFromFile($filePathName);
    }


    /**
     * build and return an object of a class from its file path
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    public function getClassObjectFromFile($filePathName)
    {
        $classString = $this->getClassFullNameFromFile($filePathName);
        return new $classString;
    }

    /**
     * get the class namespace form file path using token
     *
     * @param $filePathName
     *
     * @return  null|string
     */
    public function getClassNamespaceFromFile($filePathName)
    {
        $src = file_get_contents($filePathName);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }
        if (!$namespace_ok) {
            return null;
        } else {
            return $namespace;
        }
    }

    /**
     * get the class name form file path using token
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    protected function getClassNameFromFile($filePathName)
    {
        $php_code = file_get_contents($filePathName);

        $classes = array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING
            ) {

                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }

        return $classes[0];
    }

}