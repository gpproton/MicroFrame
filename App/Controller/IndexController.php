<?php
namespace App\Controller;

defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Index Controller class
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

use MicroFrame\Core\Controller as Core;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Core {

    public function index()
    {
        if (!$this->request->browser()) {
            $this->response->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data('Welcome, please write nice codes...')
                ->send();
        } else {
            $this->response->methods(['get', 'post', 'put', 'delete', 'option'])
                ->data(array(
                    'errorText' => 'Welcome, please write nice codes...',
                    'errorTitle' => 'Welcome Page',
                    'errorImage' => 'images/welcome.svg',
                    'errorColor' => 'violet',
                    'showReturn' => false
                ))->render('sys.Default');
        }
    }

}