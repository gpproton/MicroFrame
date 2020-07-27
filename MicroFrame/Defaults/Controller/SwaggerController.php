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
     *
     *   title="Microframe OpenAPI documetation",
     *
     *   version="0.0.1",
     *
     *   x={
     *     "some-name": "a-value",
     *     "another": 2,
     *     "complex-type": {
     *       "supported":{
     *         {"version": "1.0", "level": "baseapi"},
     *         {"version": "2.1", "level": "fullapi"},
     *       }
     *     }
     *   },
     *
     *   @OA\Contact(
     *     name="Tolaram ERP",
     *     email="teamerp@tolaram.com"
     *   ),
     *
     *   @OA\License(
     *     name="MIT",
     *     url="https://mit.license"
     *   )
     *
     * )
     *
     * @OA\Server(url=API_HOST)
     *
     * @OA\Tag(name="Defaults",
     *     description="Just to check tags..."
     *   )
     *
     * @OA\PathItem(
     *     path="/yield/",
     *     @OA\Post(
     *      summary="Test Grouped POST paths placeholder",
     *      @OA\Response(
     *      response=200,
     *      description="POST swagger API output",
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *                 @OA\Schema(ref="#/components/schemas/combined"),
     *                 example={"id": 10, "name": "Jessica Smith", "check": "yes"}
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Get(
     *      summary="Test Grouped GET paths placeholder",
     *      @OA\Response(
     *      response=200,
     *      description="POST swagger API output",
     *      @OA\MediaType(
     *         mediaType="application/json",
     *     @OA\Schema(
     *                 @OA\Schema(ref="#/components/schemas/combined"),
     *                 example={"id": 10, "name": "Jessica Smith", "check": "yes"}
     *                  )
     *              )
     *          )
     *      ),
     *
     *     @OA\Put(
     *      summary="Test Grouped PUT paths placeholder",
     *      @OA\Response(
     *      response=200,
     *      description="POST swagger API output",
     *      @OA\MediaType(
     *         mediaType="application/json",
     *     @OA\Schema(
     *                 @OA\Schema(ref="#/components/schemas/combined"),
     *                 example={"id": 10, "name": "Jessica Smith", "check": "yes"}
     *                  )
     *              )
     *          )
     *      )
     *   )
     *
     *
     * @OA\Get(path="/api/swagger/*",
     *   summary="Swagger Index API placeholder",
     *   security={
     *         {"api_key": {}}
     *     },
     *
     *   @OA\Parameter(name="id",
     *     description="Content id",
     *     required=false,
     *     in="header",
     *     @OA\Schema(ref="#/components/schemas/id")
     *   ),
     *
     *   @OA\Parameter(name="name",
     *     description="Content name",
     *     required=false,
     *     in="query",
     *     @OA\Schema(ref="#/components/schemas/name")
     *   ),
     *
     *  @OA\Parameter(name="check",
     *     description="Content check mark",
     *     required=false,
     *     in="query",
     *     @OA\Schema(ref="#/components/schemas/check")
     *   ),
     *
     *  @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Schema(ref="#/components/schemas/combined"),
     *                 example={"id": 10, "name": "Jessica Smith", "check": "yes"}
     *             )
     *         )
     *     ),
     *
     *   @OA\Response(response=200,
     *     description="Default base swagger API output & handling docs routing, if you're here check your code tags then ensure you're requesting for the right resource path e.g url.com/api/swagger/{api/index} or your corresponding controller base path.",
     *
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *                 @OA\Schema(ref="#/components/schemas/combined"),
     *                 example={"id": 10, "name": "Jessica Smith", "check": "yes"}
     *             )
     *     ),
     *     @OA\MediaType(
     *         mediaType="application/xml",
     *         @OA\Schema(ref="#/components/schemas/combined")
     *     )
     *   ),
     *   @OA\Response(response="500",
     *     description="A required property is not defined...",
     *     @OA\JsonContent(ref="#/components/schemas/combined")
     *   ),
     *   @OA\Response(response="default",
     *     description="an ""unexpected"" error",
     *     @OA\XmlContent(ref="#/components/schemas/combined")
     *   )
     * )
     *
     * @OA\Post(path="/api/swagger/*",
     *   summary="Index API POST placeholder",
     *   @OA\Response(
     *     response=200,
     *     description="Default base POST swagger API output",
     *     @OA\MediaType(
     *         mediaType="application/json"
     *     )
     *   )
     * )
     *
     * @OA\Post(path="/test/{testId}/uploadImage",
     *     tags={"Defaults"},
     *     summary="uploads an image",
     *     operationId="uploadFile",
     *     @OA\Parameter(
     *         name="testId",
     *         in="path",
     *         description="ID of test to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/combined")
     *     ),
     *     security={
     *         {"default_auth": {"write:Defaults", "read:Defaults"}}
     *     },
     *     @OA\RequestBody(description="Upload images request body",
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *             @OA\Schema(
     *                 type="string",
     *                 format="binary"
     *             )
     *         )
     *     )
     * )
     *
     * ## Schema definition for later reuse.
     *
     * @OA\Schema(
     *      schema="id",
     *      type="integer",
     *      format="int64",
     *      description="The unique identifier of an item"
     * )
     *
     *
     * @OA\Schema(
     *      schema="check",
     *      type="string",
     *      format="string",
     *      description="Check status for placeholder..."
     * )
     *
     * @OA\Schema(
     *      schema="name",
     *      type="string",
     *      format="string",
     *      description="The intem names requested..."
     * )
     *
     *
     * @OA\Schema(
     *   schema="combined",
     *   allOf={
     *     @OA\Schema(ref="#/components/schemas/id"),
     *     @OA\Schema(ref="#/components/schemas/name"),
     *     @OA\Schema(ref="#/components/schemas/check")
     *   }
     * )
     *
     * @OA\Example(
     *  example="test",
     *  sammary="This and that and others",
     *  value={"id": 10, "name": "Jessica Smith", "check": "yes"}
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
                throw new Exception("Requested API directory does not exits...");
            }
        } catch (\Exception $exception) {
            $openApi = scan(__DIR__);
            Exception::init()->log($exception->getMessage());
        } catch (Exception $exception) {
            $exception->log($exception->message);
        }

        $this->response
            ->methods(['get', 'post', 'put', 'delete', 'option'])
            ->data($openApi)
            ->send();
    }
}