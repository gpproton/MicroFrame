<?php
/**
 * ResponseTest class
 *
 * PHP Version 7
 *
 * @category  MicroFrame
 * @package   Test\Core
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

namespace Tests\Core;

use MicroFrame\Core\Request;
use MicroFrame\Core\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 * @package Tests\Core
 */
class ResponseTest extends TestCase
{

    private $_response;

    public function testMethods()
    {
        define('BASE_PATH', __DIR__);

        $this->_response = new Response();
        $newReq = new Request();
//        die(var_dump($newReq->query()));
//        $this->_response->methods(['get', 'post']);
//        $this->assertEquals(true, $this->_response->proceed);

        return;
    }

    public function testStatus()
    {

    }

    public function testSend()
    {

    }
}
