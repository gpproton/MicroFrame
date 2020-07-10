<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Model helper class
 *
 * PHP Version 7
 *
 * @category  Helpers
 * @package   MicroFrame
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

namespace MicroFrame\Helpers;

class Model {

    public $queryString = "";
    public $queryParams = array();
    public $queryPrepare = null;
    public $queryReturn = true;
    public $modelString;

    public function __construct($modelString)
    {
        $this->modelString = $modelString;
    }

    public function Query()
    {
        Injector::loadClass($this->modelString);
        
        $this->queryReturn = getQueryReturn();
        $this->queryString = getQueryString();

        try
        {
            /* Use prepared statements for maximum security against injections */
            $bootStrap =  Database::Initialize();
            $this->queryPrepare = $bootStrap->prepare($this->queryString, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	        $this->queryPrepare->execute($this->queryParams);

        }
        catch (PDOException $e)
        {
            $jsonMsg = array(
                'status' => 0,
                'type' => 'Dabase Exception',
                'message' => 'error: ' . $e->getMessage()
            );

            if(!Utils::getLocalStatus())
            {
                Utils::errorHandler($jsonMsg);
            }
        }

        return $this->queryPrepare;
    }
}