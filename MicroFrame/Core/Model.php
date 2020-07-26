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
    // TODO: Placeholder for possible future requirements
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
            foreach ($content as $value) {
                $this->query[] = $value;
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
        try {
            /**
             * Call to database with current parameters and query strings
             */
            foreach ($this->query as $value) {
                $prepare = null;
                if (sizeof($value) === 3) {
                    /**
                     * Allow for multiple datasource queries in single method call.
                     */
                    $prepare = $this->initialize($value['instance'])
                        ->prepare($this->load($value['model']), array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                    $param = $value['params'];

                } elseif (isset($this->params[$level])) {
                    $param = $this->params[$level];
                } else {
                    $param = array();
                }

                /**
                 * Options for extended array instance | query | param
                 */

                if(sizeof($value) !== 3) $prepare = $this->instance->prepare($this->load($value), array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
                $prepare->execute($param);

                $results = array();
                while ($row =  $prepare->fetch(\PDO::FETCH_ASSOC)) {
                    $results[] = $row;
                }

                $this->result[$value] = $results;

                // increment parameters index
                $level++;
            }
        } catch (\Exception $exception) {
            $this->completed = false;
            $this->status = $exception;
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
        return $this->result;
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