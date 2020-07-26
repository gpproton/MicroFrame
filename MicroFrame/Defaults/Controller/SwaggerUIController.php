<?php
namespace MicroFrame\Defaults\Controller;

defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Swagger UI controller class
 *
 * PHP Version 7
 *
 * @category  Controller
 * @package   MicroFrame\Defaults\Controller
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

use \MicroFrame\Core\Controller as Core;

/**
 * Class SwaggerUIController
 *
 * For rendering the swagger UI for the project
 *
 * @package MicroFrame\Defaults\Controller
 */
class SwaggerUIController extends Core
{

    // TODO: Implement UI
    // Resources: https://medium.com/@tatianaensslin/how-to-add-swagger-ui-to-php-server-code-f1610c01dc03
    public function index()
    {
        $getTest =  require_once (__DIR__ . "/../View/SwaggerUIView.php");
        echo $getTest;
        die();
    }

}