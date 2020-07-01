<?php

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

use \MicroFrame\Helpers\Config;
use \MicroFrame\Handlers\Routes;

final class Core {

    public function __construct()
    {
        // Auto loader class injection.
        spl_autoload_register(function ($class)
        {
            $nameSpacePath = str_replace('\\', '/', $class) . '.php';
            if(is_file($nameSpacePath))
            {
                require_once $nameSpacePath;
            }
        });
    }

    public function Run()
    {
        Config::Load();
        Routes::Boot();
    }
}
