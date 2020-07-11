<?php

/**
 * Bootstrapping class
 * 
 * PHP Version 7
 * 
 * @category  Bootstrap
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

require '../vendor/autoload.php';
require_once '../MicroFrame/Core.php';

// Initialize processes..
$baseApp = new MicroFrame\Core;
$baseApp->Run();
