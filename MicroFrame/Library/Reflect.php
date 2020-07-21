<?php
/**
 * Reflect Library class
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

use MicroFrame\Handlers\Exception;
use MicroFrame\Handlers\Logger;
use ReflectionClass;

/**
 * Class Reflect
 * @package MicroFrame\Library
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
     * Dynamically get classes and method based on filtered strings
     *
     * @param $type
     * @param $path
     * @param array $args
     * @param bool $checkMethod
     * @return mixed
     */
    public function stateLoader($type, $path, $args = array(), $checkMethod = false) {

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
            return "$base{$core}\\{$path}";
        };

        if (Strings::filter($type)->contains("sys")) $path = $pathHandler(self::$sysPath);
        else if ((Strings::filter($type)->contains("app"))) {
            $path = $pathHandler(self::$appPath);
        }

        $classDirect = Strings::filter($path)
            ->append($core)
            ->upperCaseWords()
            ->value();

        $classUpper = Strings::filter($path)
            ->range("\\", true, true)
            ->append($core)
            ->upperCaseWords()
            ->value();

        $classMethod = Strings::filter($path)
            ->range("\\", true, false)
            ->upperCaseWords()
            ->value();

        if (class_exists($classDirect)) {
            $path = $classDirect;
        } else if (class_exists($classUpper)) {
            $path = $classUpper;
        }

        switch ($core) {
            case 'Controller':
                if (class_exists($classUpper) && gettype($args) === 'array') $args[2] = $classMethod;
                break;
            default:
                break;
        }

        if (gettype($args) !== 'array' && class_exists($path)) return true;
        if ($checkMethod && class_exists($path)) return $classMethod;
        if (class_exists($path)) {
            try {
                $classBuilder = new ReflectionClass($path);
            } catch (\ReflectionException $e) {
                Logger::set($e->getMessage())->error();
            }
            /** @var ReflectionClass $classBuilder */
            return $classBuilder->newInstanceArgs($args);
        } else {
            return false;
        }


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