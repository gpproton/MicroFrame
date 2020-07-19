<?php
/**
 * View Core class
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

use MicroFrame\Interfaces\IModel;
use MicroFrame\Interfaces\IView;

/**
 * Class View
 * @package MicroFrame\Core
 */
class View implements IView
{

    protected $request;
    protected $response;
    protected $model;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->model = new Model();
    }

    /**
     *
     * @summary Model static instance initializer.
     *
     * @param null $source
     * @return Model|IModel
     */
    public function model($source =  null)
    {
        if (is_null($source)) return new Model();
        return new Model($source);
    }

    /**
     * @inheritDoc
     */
    public function loader($source = null)
    {
        // TODO: Implement loader() method.
    }
}