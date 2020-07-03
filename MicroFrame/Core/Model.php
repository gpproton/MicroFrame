<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Model abstract class
 *
 * PHP Version 5
 *
 * @category  Core
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Core;

use MicroFrame\Interfaces\IDatabase;
use MicroFrame\Interfaces\IModel;

final class Model implements IModel
{

    /**
     * @inheritDoc
     */
    public function initialize(IDatabase $database)
    {
        // TODO: Implement initialize() method.
    }

    /**
     * @inheritDoc
     */
    public function params($array = [])
    {
        // TODO: Implement params() method.
    }

    /**
     * @inheritDoc
     */
    public function query($string)
    {
        // TODO: Implement query() method.
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }

    /**
     * @inheritDoc
     */
    public function result()
    {
        // TODO: Implement result() method.
    }

    /**
     * @inheritDoc
     */
    public function loader()
    {
        // TODO: Implement loader() method.
    }
}