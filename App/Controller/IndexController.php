<?php

/**
 * Index Controller class
 *
 * PHP Version 7
 *
 * @category  Controller
 * @package   App\Controller
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

namespace App\Controller;

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Core\Controller as Core;

/**
 * Class IndexController
 *
 * @category Controller
 * @package  App\Controller
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
class IndexController extends Core
{
    /**
     * Root controller for showcase.
     *
     * @return void
     */
    public function index()
    {
        if (!$this->request->browser()) {
            $this->response->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data('Welcome, please write nice codes...')
                ->send();
        } else {
            $this->response->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data(
                    [
                    'errorText' => 'You\'re at a crossroad, 
                     choose your destination..',
                    'errorTitle' => 'Welcome Page',
                    'errorImage' => 'images/vector/welcome.svg',
                    'errorColor' => 'violet',
                    'showReturn' => false
                    ]
                )->render('sys.Default');
        }
    }
}
