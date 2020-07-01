<?php

/**
 * Set default PHP configurations.
 */
ini_set("short_open_tag", 1);
ini_set("default_socket_timeout", 900);
ini_set("max_execution_time", 900);
ini_set("max_input_time", 600);
ini_set("max_input_vars", 250);
ini_set("memory_limit", -1);
ini_set("post_max_size", "256M");
ini_set("upload_max_filesize", "256M");
ini_set("max_file_uploads", 300);


/**
 * Bootstrap
 * 
 * PHP Version 5
 * 
 * @category  Bootstrap
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

define('BASE_PATH', __DIR__);

require 'vendor/autoload.php';
require_once './MicroFrame/Core.php';

// Initialize processes..
$baseApp = new MicroFrame\Core;
$baseApp->Run();
