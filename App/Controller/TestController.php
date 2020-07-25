<?php
namespace App\Controller;

defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Test Controller class
 *
 * PHP Version 7
 *
 * @category  Controller
 * @package   App\Controllers
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
 * Class TestController
 * @package App\Controller
 */
class TestController extends Core {

    /**
     * Controller index method, normal.
     */
    public function index()
    {
        /**
         * Set if controller should auto or not via it's path.
         *
         * $this->auto(false);
         */

        $this->response
            // Optional set method
            ->methods(['get', 'post'])
            ->data(['OnePieceVillains' => ['Black Beard', 'Douglass Bullet', 'D Rocks', 'Im Sama'],
            'address' => $this->request->url()])
            ->send();
    }
}