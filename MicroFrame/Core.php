<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Core class
 *
 * PHP Version 5
 *
 * @category  MicroFrame
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

namespace MicroFrame;

use MicroFrame\Core\Request as request;
use MicroFrame\Helpers\Config as config;
use MicroFrame\Handlers\Routes as route;

final class Core {

    public function __construct()
    {
        // Auto loader class injection.
        spl_autoload_register(function ($class)
        {
            $nameSpacePath = str_replace('\\', '/', $class) . '.php';
            if(is_file($nameSpacePath))
            {
                /** @var string $nameSpacePath */
                require_once $nameSpacePath;
            }
        });
    }

    public function Run()
    {
        // Bootstrap all defined configurations
        if (!request::initializeGlobals()) die('Request can bot be routed!');
        else {
            config::Load();
            // Trigger actions and filters on HTTP request
            route::Boot();
        }
    }
}
