<?php
/**
 * Default Index controller class
 *
 * PHP Version 7
 *
 * @category  Controller
 * @package   App\Controllers\Api
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

namespace App\Controller\Api;

defined('BASE_PATH') or exit('No direct script access allowed');

use \MicroFrame\Core\Controller as Core;

/**
 * Class IndexController
 *
 * @category Controller
 * @package  App\Controller\Api
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class IndexController extends Core
{

    /**
     * Index sample OpenAPI doc
     *
     * @OA\Info(
     *   title="Base Sample API DOC",
     *   version="0.0.1",
     * @OA\Contact(
     *     email="teamerp@tolaram.com"
     *   )
     * )
     *
     * @OA\Post(
     *   path="/api/index",
     *   summary="Index API POST placeholder",
     * @OA\Response(
     *     response=200,
     *     description="Default base POST swagger API output",
     * @OA\MediaType(
     *         mediaType="application/json"
     *     )
     *   )
     * )
     *
     * @OA\Get(
     *   path="/api/index",
     *   summary="Index API GET placeholder",
     * @OA\Response(
     *     response=200,
     *     description="Default base GET swagger API output",
     * @OA\MediaType(
     *         mediaType="application/json"
     *     )
     *   )
     * )
     *
     * @return void
     */
    public function index()
    {
    }
}
