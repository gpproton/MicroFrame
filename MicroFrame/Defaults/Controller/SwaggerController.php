<?php

namespace MicroFrame\Defaults\Controller;

defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Swagger.json controller class
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
use MicroFrame\Handlers\Exception;
use MicroFrame\Library\Strings;
use \OpenApi\Annotations as OA;
use function OpenApi\scan;

/**
 * Class SwaggerController
 * @package MicroFrame\Defaults\Controller
 */
class SwaggerController extends Core
{
    /**
     *
     * @OA\Info(
     *   title="Microframe OpenAPI documetation",
     *   version="0.0.1",
     *   @OA\Contact(
     *     email="teamerp@tolaram.com"
     *   )
     * )
     *
     * @OA\Get(
     *   path="/api/swagger/*",
     *   summary="Swagger Index API placeholder",
     *   @OA\Response(
     *     response=200,
     *     description="Default base swagger API output & handling docs routing, if you're here check your code tags then ensure you're requesting for the right resource path e.g url.com/api/swagger/{api/index} or your corresponding controller base path.",
     *     @OA\MediaType(
     *         mediaType="application/json"
     *     )
     *   )
     * )
     *
     */
    public function index()
    {
        $apiPath = Strings::filter($this->request->path())
            ->range(".", true, true)
            ->replace(["swagger.api", "."], ["", "/"])
            ->upperCaseWords()
            ->value();

        $apiPath = BASE_PATH . "/App/Controller/" . $apiPath;
        $openApi = array();
        try {
            if (is_dir($apiPath)) {
                $openApi = scan($apiPath);
            } else {
                throw new Exception("Directory does not exits...");
            }
        } catch (\Exception $exception) {
            $openApi = scan(__DIR__);
        } catch (Exception $exception) {
            $exception->log($exception->message);
        }

        $this->response
            ->methods(['get', 'post', 'put', 'delete', 'option'])
            ->data($openApi)
            ->send();
    }
}