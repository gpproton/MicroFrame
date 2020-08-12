<?php
/**
 * App model interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

namespace MicroFrame\Interfaces;

defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Interface IModel
 * @package MicroFrame\Interfaces
 */
interface IModel
{
    /**
     * IModel constructor.
     * @param string $source
     */
    public function __construct($source = null);

    /**
     * @param array $array
     * @return IModel
     */
    public function params($array = []);

    /**
     * @param $string
     * @return IModel
     */
    public function query($string);

    /**
     * @param string $cacheStrategy
     * @return IModel
     */
    public function execute($cacheStrategy = 'resultOnly');

    /**
     * @return array
     */
    public function result();

    /**
     * @return IModel
     */
    public function resultFirst();

    /**
     * @return IModel
     */
    public function cacheFirst();

    /**
     * @return IModel
     */
    public function cacheOnly();

    /**
     * @return IModel
     */
    public function resultOnly();

}

