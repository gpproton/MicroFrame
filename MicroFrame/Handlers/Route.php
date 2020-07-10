<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * Route Handlers class
 * 
 * PHP Version 7
 * 
 * @category  Handlers
 * @package   MicroFrame
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

namespace MicroFrame\Handlers;

use MicroFrame\Core\Request;
use MicroFrame\Core\Response;
use Microframe\Defaults\Middleware\DefaultMiddleware;
use MicroFrame\Helpers\Utils;


final class Route
{

    public function __construct()
    {

    }

    public static function Boot()
    {
        // TODO: Include conditions based on the route and request state.
        Utils::stateLoader('SYSController', 'Default', array(new Response(), new Request()))
        ->middleware(new DefaultMiddleware)
            ->start();
    }

}


