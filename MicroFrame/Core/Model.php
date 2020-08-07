<?php
/**
 * Model Core class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
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

namespace MicroFrame\Core;

defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Handlers\DataSource;
use MicroFrame\Handlers\Exception;
use MicroFrame\Interfaces\IModel;
use MicroFrame\Library\Reflect;
use MicroFrame\Library\Strings;

/**
 * Class Model
 * @package MicroFrame\Core
 */
final class Model implements IModel
{
    private $instance;
    private $query = array();
    private $params = array();
    private $result = array();
    public $completed = false;
    public $status = "Ok";

    /**
     * Model constructor.
     * @param string $source
     */
    public function __construct($source = null)
    {
        $this->instance = $this->initialize($source);

        return $this;
    }

    /**
     * @param array|string $content
     * @return $this
     *
     */
    public function query($content)
    {
        if (gettype($content) === 'string') {
            $this->query[] = $content;
        } else if (gettype($content) === 'array') {
            foreach ($content as $key => $value) {
                if ($key === 'instance' || $key === 'model' || $key === 'params') {
                    $this->query[] = $content;
                    break;
                } elseif(gettype($value) === 'array') {
                    $this->query[] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function params($array = [])
    {
        $this->params[] = $array;

        return $this;
    }

    /**
     * Start actual database query for any QModel specified.
     *
     * @return $this|void
     */
    public function execute()
    {
        $level = 0;
        $modelSrc = "select 1 from dual";
        $modelSample = array('sample' => 'dataX');

        try {
            /**
             * Call to database with current parameters and query strings
             */
            foreach ($this->query as $value) {

                try {
                    $prepare = null;
                    if (gettype($value) === 'array' && sizeof($value) >= 3) {
                        /**
                         * Allow for multiple datasource queries in single method call.
                         */
                        if (!empty($this->load($value['model'])['query'])) {
                            $modelSrc = $this->load($value['model'])['query'];
                        }

                        /**
                         * Allow usage of sample data if not connection
                         */
                        if (!empty($this->load($value['model'])['sample'])) {
                            $modelSample = $this->load($value['model'])['sample'];
                        }
                        $prepare = $this->initialize($value['instance'])
                            ->prepare($modelSrc, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                        $param = $value['params'];

                    } elseif (isset($this->params[$level])) {
                        $param = $this->params[$level];
                    } else {
                        $param = array();
                    }

                    if (gettype($value) !== 'array') {

                        /**
                         * Options for extended array instance | query | param
                         */
                        if (!empty($this->load($value)['query'])) {
                            $modelSrc = $this->load($value)['query'];
                        }

                        /**
                         * Allow usage of sample data if not connection
                         */
                        if (!empty($this->load($value)['sample'])) {
                            $modelSample = $this->load($value)['sample'];
                        }

                        $prepare = $this->instance->prepare($modelSrc, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                    }

                    /**
                     * General query execution.
                     */
                    $prepare->execute($param);

                    $results = array();

                    while ($row = $prepare->fetch(\PDO::FETCH_ASSOC)) {
                        $results[] = array_change_key_case($row, CASE_LOWER);
                    }

                    if (gettype($value) !== 'array') {
                        if (!isset($this->result[$value])) {
                            $this->result[$value] = $results;
                        } else {
                            $this->result[$value . '-' . rand(2, 100)] = $results;
                        }

                    } else {
                        if (!isset($this->result[$value['model']])) {
                            $this->result[$value['model']] = $results;
                        } else {
                            $this->result[$value['model'] . '-' . rand(2, 100)] = $results;
                        }

                    }

                    /**
                     * increment parameters index
                     */
                    $level++;
                } catch (\Exception $e) {
                    $this->status = $e;

                    if (gettype($value) !== 'array') {
                        $this->result[$value] = $modelSample;
                    } else {
                        $this->result[$value['model']] = $modelSample;
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
        $this->query = array();
        $this->params = array();
        $this->completed = true;

        return $this;
    }

    /**
     * @return array
     */
    public function result()
    {
        return array_change_key_case($this->result, CASE_LOWER);
    }

    /**
     *
     *
     * @param $path
     *
     * @return string
     */
    private function load($path)
    {
        if (!Strings::filter($path)->contains("sys.")) {
            return Reflect::check()->stateLoader("app.Model." . $path, array())->query;
        } else {
            return Reflect::check()->stateLoader($path, array())->query;
        }

    }

    /**
     * @param $source
     * @return mixed|\PDO
     */
    private function initialize($source) {
        try {
            return DataSource::get($source, false);
        } catch (\Exception $e) {
            Exception::init()->output($e);
        }
    }
}