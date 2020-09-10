<?php

/**
 * Core Model class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Handlers\DataSource;
use MicroFrame\Handlers\Exception;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Strings;
use PDO;

/**
 * Model class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class Model extends Core implements IModel
{
    /**
     * The internal instance of the default/requested model.
     *
     * @var IModel
     */
    private $_instance;

    /**
     * An array of query to be executed.
     *
     * @var array
     */
    private $_query = array();

    /**
     * A parameter array for requested queries.
     *
     * @var array
     */
    private $_params = array();

    /**
     * Completed result array.
     *
     * @var array
     */
    private $_result = array();

    /**
     * An indicator if all queries completed.
     *
     * @var bool
     */
    public $completed = false;

    /**
     * A string indicator of final query status.
     *
     * @var string
     */
    public $status = "Ok";

    /**
     * Model constructor.
     *
     * @param string $source here
     *
     * @comment Model constructor
     *
     * @return self
     */
    public function __construct($source = null)
    {
        $this->_instance = $this->_initialize($source);

        return $this;
    }

    /**
     * Model init method
     *
     * @param $source string here
     *
     * @return mixed|PDO
     */
    private function _initialize($source)
    {
        try {
            return DataSource::get($source);
        } catch (\Exception $e) {
            Exception::init()->output($e);
        }
    }

    /**
     * Query input method.
     *
     * @param array|string $content here
     *
     * @return self
     */
    public function query($content)
    {
        if (gettype($content) === 'string') {
            $this->_query[] = $content;
        } elseif (gettype($content) === 'array') {
            foreach ($content as $key => $value) {
                if ($key === 'instance' || $key === 'model' || $key === 'params') {
                    $this->_query[] = $content;
                    break;
                } elseif (gettype($value) === 'array') {
                    $this->_query[] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Parameter input method.
     *
     * @param array $array here
     *
     * @return self
     */
    public function params($array = [])
    {
        $this->_params[] = $array;

        return $this;
    }

    /**
     * Start actual database query for any QModel specified.
     *
     * @param string $cacheStrategy here
     *
     * @return self|void
     */
    public function execute($cacheStrategy = 'resultOnly')
    {
        $level = 0;
        $modelSrc = "select 1 from dual";
        $modelSample = array('sample' => 'dataX');

        try {
            /**
             * Call to database with current parameters and query strings
             */
            foreach ($this->_query as $value) {
                try {
                    $prepare = null;
                    if (gettype($value) === 'array' && sizeof($value) >= 3) {
                        /**
                         * Allow for multiple datasource
                         * queries in single method call.
                         */
                        if (!empty($this->_load($value['model'])['query'])) {
                            $modelSrc = $this->_load($value['model'])['query'];
                        }

                        /**
                         * Allow usage of sample data if not connection
                         */
                        if (!empty($this->_load($value['model'])['sample'])) {
                            $modelSample = $this->_load($value['model'])['sample'];
                        }
                        $prepare = $this->_initialize($value['instance'])
                            ->prepare(
                                $modelSrc,
                                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
                            );
                        $param = $value['params'];
                    } elseif (isset($this->_params[$level])) {
                        $param = $this->_params[$level];
                    } else {
                        $param = array();
                    }

                    if (gettype($value) !== 'array') {

                        /**
                         * Options for extended array instance | query | param
                         */
                        if (!empty($this->_load($value)['query'])) {
                            $modelSrc = $this->_load($value)['query'];
                        }

                        /**
                         * Allow usage of sample data if not connection
                         */
                        if (!empty($this->_load($value)['sample'])) {
                            $modelSample = $this->_load($value)['sample'];
                        }

                        $prepare = $this->_instance
                            ->prepare(
                                $modelSrc,
                                [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
                            );
                    }

                    /**
                     * General query execution.
                     */
                    // TODO: Handle cache conditions before execution.
                    $prepare->execute($param);

                    $results = array();

                    while ($row = $prepare->fetch(PDO::FETCH_ASSOC)) {
                        $results[] = array_change_key_case($row, CASE_LOWER);
                    }

                    if (gettype($value) !== 'array') {
                        if (!isset($this->_result[$value])) {
                            $this->_result[$value] = $results;
                        } else {
                            // TODO: Change from random to explicitly defined key.
                            $this->_result[$value . '-' . rand(2, 100)] = $results;
                        }
                    } else {
                        if (!isset($this->_result[$value['model']])) {
                            $this->_result[$value['model']] = $results;
                        } else {
                            // TODO: Change from random to explicitly defined key.
                            $this->_result[$value['model'] .
                            '-' . rand(2, 100)] = $results;
                        }
                    }

                    /**
                     * Increment parameters index
                     */
                    $level++;
                } catch (\Exception $e) {
                    $this->status = $e;

                    if (gettype($value) !== 'array') {
                        $this->_result[$value] = $modelSample;
                    } else {
                        $this->_result[$value['model']] = $modelSample;
                    }
                }
            }
        } catch (\Exception $exception) {
            /**
             * Set some specific query state.
             */
            $this->completed = false;
        }

        /**
         * Clear used fields.
         */
        $this->_query = array();
        $this->_params = array();
        $this->completed = true;

        return $this;
    }

    /**
     * Returns result from query.
     *
     * @return array
     */
    public function result()
    {
        return array_change_key_case($this->_result, CASE_LOWER);
    }

    /**
     * Internal Model loader
     *
     * @param $path string here
     *
     * @return string
     */
    private function _load($path)
    {
        if (!Strings::filter($path)->contains("sys.")) {
            return Reflect::check()->stateLoader(
                "app.Model." . $path,
                array()
            )->query;
        } else {
            return Reflect::check()->stateLoader($path, array())->query;
        }
    }

    /**
     * Send result then cache item.
     *
     * @return self|void
     */
    public function resultFirst()
    {
        // TODO: Implement resultFirst() method.
    }

    /**
     * Send already cached if it's not null and cache new result.
     *
     * @return self|void
     */
    public function cacheFirst()
    {
        // TODO: Implement cacheFirst() method.
    }

    /**
     * Cache only new result when null and never
     * cache new result until cache expires.
     *
     * @return self|void
     */
    public function cacheOnly()
    {
        // TODO: Implement cacheOnly() method.
    }

    /**
     * Send only result and never cache results.
     *
     * @return self|void
     */
    public function resultOnly()
    {
        // TODO: Implement resultOnly() method.
    }
}
