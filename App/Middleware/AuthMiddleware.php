<?php
/**
 * Test Middleware class
 *
 * PHP Version 7
 *
 * @category  Middleware
 * @package   App\Middleware
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

namespace App\Middleware;

defined('BASE_PATH') or exit('No direct script access allowed');

use \Microframe\Core\Middleware;

/**
 * AuthMiddleware Class
 *
 * @category Middleware
 * @package  App\Middleware
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class AuthMiddleware extends Middleware
{
    /**
     * Handle the validation return state.
     *
     * @return bool|mixed
     */
    public function handle()
    {
        /**
         * All available request methods are accessible through this
         * $this->request;
         */


        /**
         * Sample auth call for
         * $this->request->auth();
         */

        /**
         * Sample data call with default instance
         *
         * $data = $this->model->query('select 1 from dual')
         * ->execute()
         * ->result();
         */

        /**
         * Sample data call with custom database instance
         *
         * $data = parent::model('oracle2x')->query('select 1 from dual')
         * ->execute()
         * ->result();
         */

        // Cache tests
        //        $cacheInstance = $this->cache('redis');
        //        die(var_dump($cacheInstance->setMultiple(['testz' => 'yes', 'testx' => 'hmmm'])));
        //        die(var_dump($cacheInstance->set('newSamples', 45)));
        //        die(var_dump($cacheInstance->get('testz')));
        //        die(var_dump($cacheInstance->push('nq1', ['haha', 'hoho'])));
        //        die(var_dump($cacheInstance->pop('nq1')));
        //        die(var_dump($cacheInstance->getMultiple(['testz', 'nq1_queue'])));
        //        die(var_dump($cacheInstance->deleteMultiple(['testz', 'nq1_queue'])));

        return true;
    }
}
