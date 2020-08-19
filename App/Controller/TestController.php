<?php
/**
 * TestController class
 *
 * PHP Version 7
 *
 * @category  MicroFrame
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
 * TestController Class
 *
 * @category Controller
 * @package  App\Controller
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
final class TestController extends Core
{

    /**
     * Controller index method, normal.
     *
     * @return void
     */
    public function index()
    {
        /**
         * Set if controller should auto or not via it's path.
         *
         * $this->auto(false);
         */

        $this->debugX();
        
        //        $cacheInstance = $this->cache('redis');
        //        die(var_dump($cacheInstance->setMultiple(['testz' => 'yes', 'testx' => 'hmmm'])));
        //        die(var_dump($cacheInstance->set('newSamples', 45)));
        //        die(var_dump($cacheInstance->get('testz')));
        //        die(var_dump($cacheInstance->push('nq1', ['haha', 'hoho'])));
        //        die(var_dump($cacheInstance->pop('nq1')));
        //        die(var_dump($cacheInstance->getMultiple(['testz', 'nq1_queue'])));
        //        die(var_dump($cacheInstance->deleteMultiple(['testz', 'nq1_queue'])));


        $this->response
            // Optional set method
            ->methods(['get', 'post'])
            ->data(
                ['Villains' => ['OnePiece' => ['Black Beard', 'Douglass Bullet', 'D Rocks', 'Im Sama'],
                'Naruto' => ['Orochimaru', 'Danzo', 'Madara Uciha']],
                'address' => $this->request->url()]
            )
            ->send();
    }
}
