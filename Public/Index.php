<?php
/**
 * Bootstrapping core
 *
 * PHP Version 7
 *
 * @category  Bootstrap
 * @package   MicroFrame
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

/**
 * Set default PHP configurations.
 * TODO: Move to final location...
 */
ini_set("default_socket_timeout", 900);
ini_set("max_execution_time", 900);
ini_set("max_input_time", 600);
ini_set("max_input_vars", 250);
ini_set("memory_limit", -1);
ini_set("post_max_size", "256M");
ini_set("upload_max_filesize", "256M");
ini_set("max_file_uploads", 300);

require_once __DIR__ . '/../vendor/autoload.php';


$app = new MicroFrame\Core;

/**
 * Bootstrap application with error handling..
 */
$app->run(new MicroFrame\Handlers\ErrorHandler());
