<?php
/**
 * App Model interface
 *
 * PHP Version 7
 *
 * @category  Interfaces
 * @package   MicroFrame\Interfaces
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

use MicroFrame\Interfaces\Core\ICore;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Interface IModel
 *
 * @category Interface
 * @package  MicroFrame\Interfaces
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
interface IModel extends ICore
{
    /**
     * Model constructor.
     *
     * @param string $source here
     *
     * @comment Model constructor
     *
     * @return self
     */
    public function __construct($source = null);

    /**
     * Query input method.
     *
     * @param string $string here
     *
     * @return self
     */
    public function query($string);

    /**
     * Parameter input method.
     *
     * @param array $array here
     *
     * @return self
     */
    public function params($array = []);

    /**
     * Start actual database query for any QModel specified.
     *
     * @param string $cacheStrategy here
     *
     * @return self|void
     */
    public function execute($cacheStrategy = 'resultOnly');

    /**
     * Returns result from query.
     *
     * @return array
     */
    public function result();

    /**
     * Send result then cache item.
     *
     * @return self|void
     */
    public function resultFirst();

    /**
     * Send already cached if it's not null and cache new result.
     *
     * @return self|void
     */
    public function cacheFirst();

    /**
     * Cache only new result when null and never
     * cache new result until cache expires.
     *
     * @return self|void
     */
    public function cacheOnly();

    /**
     * Send only result and never cache results.
     *
     * @return self|void
     */
    public function resultOnly();
}
