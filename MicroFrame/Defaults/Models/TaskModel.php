<?php

/**
 * Default Task Model class
 *
 * PHP Version 7
 *
 * @category  Model
 * @package   MicroFrame\Defaults\Model
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

namespace MicroFrame\Defaults\Models;

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Core\ModelQuery;

/**
 * Class TaskModel
 * @package MicroFrame\Defaults\Models
 */
class TaskModel extends ModelQuery
{
    public function default()
    {
        return parent::default();
    }

    /**
     * Create a required table for cache DB.
     *
     * @return array
     */
    public function createTable()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Delete an undesired table from the cache DB.
     *
     * @return array
     */
    public function deleteTable()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Create a new key in key value store table.
     *
     * @return array
     */
    public function createKey()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Delete an new key in from the value store table.
     *
     * @return array
     */
    public function deleteKey()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Update a new or old key in key value store table.
     *
     * @return array
     */
    public function setKey()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Retrieve an existing key value.
     *
     * @return array
     */
    public function getKey()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    /**
     * Add an item to a table based list
     *
     * @return array
     */
    public function listPush()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }

    public function listPop()
    {
        $query = <<<SQL
            SELECT 1 FROM DUAL
SQL;
        return array( 'query' => $query, 'sample' => []);
    }
}
