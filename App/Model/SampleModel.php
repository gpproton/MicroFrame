<?php
/**
 * Sample Model class
 *
 * PHP Version 7
 *
 * @category  Model
 * @package   App\Model
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

namespace App\Model;

use MicroFrame\Core\ModelQuery;

defined('BASE_PATH') or exit('No direct script access allowed');

/**
 * Class SampleModel
 * @package App\Model
 */
class SampleModel extends ModelQuery
{

    /**
     * Default for classes extending
     *
     * @return array
     */
    public function default()
    {
        $query = <<<SQL

            SELECT 1 FROM DUAL
            
SQL;

        $sample = array();

        return array( 'query' => $query, 'sample' => $sample);
    }

    /**
     * Test case
     *
     * @return array
     */
    public function sample()
    {
        $query = <<<SQL

            SELECT 'TEST' FROM DUAL
            
SQL;

        $sample = array();

        return array( 'query' => $query, 'sample' => $sample);
    }
}
