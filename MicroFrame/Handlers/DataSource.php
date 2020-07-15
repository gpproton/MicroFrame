<?php
/**
 * Strings helper class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;
defined('BASE_PATH') OR exit('No direct script access allowed');

use MicroFrame\Interfaces\IDatabase;

/**
 * Class DataSource
 * @package MicroFrame\Handlers
 */
class DataSource implements IDatabase {

    // TODO: Rewrite for more dynamic usage
    protected static $Connection;
    private $datasource = (object) SYS_DATA_SOURCE;
    private static $SLASH = '/';
    private static $COLUMN = ':';

    // echo var_dump(\MicroFrame\Helpers\Config::$DATA_SOURCE->default->host);

    //        try {
    //            throw new Exception('Divide by zero');
    //        } catch (Exception $exception) {
    //            $exception
    //                ->output();
    //        }


    /**
     * DataSource constructor.
     * @param null $type
     */
    public function __construct($type = null)
    {
        $Options = [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_TIMEOUT => 5, // PDO timeout for queries
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array,
          ];

        if(empty(self::$Connection))
        {
            try {

                switch(Config::$DATABASE_TYPE)
                {
                    case 'oracle':
                        if (self::checkPDODriver('oci'))
                        {
                            self::$Connection = new PDO(
                                self::OracleConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            ); 
                        }
                        else
                        {
                            self::$Connection = new PDOOCI\PDO(
                                self::OracleConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            );
                        }
                    break;
                    case 'postgres':
                        if (self::checkPDODriver('pgsql'))
                        {
                            self::$Connection = new PDO(
                                self::PGConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            ); 
                        }
                    break;
                    case 'mysql':
                        if (self::checkPDODriver('mysql'))
                        {
                            self::$Connection = new PDO(
                                self::MysqlConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            ); 
                        }
                    break;
                    case 'sqlite':
                        if (self::checkPDODriver('sqlite'))
                        {
                            self::$Connection = new PDO(
                                self::SQLiteConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            ); 
                        }
                    break;
                    default:
                        //self::$Connection = new PDO("", "", "", $Options);
                        return false;
                }

            } catch(PDOException $e) {
    
                $jsonMsg = array(
                    'status' => 0,
                    'type' => 'DataSource Exception',
                    'message' => 'error: ' . $e->getMessage()
                );

                if(!Utils::getLocalStatus())
                {
                    Utils::errorHandler($jsonMsg);
                }
                
            }
        }

        return self::$Connection;
    }

    /**
     * @return string
     */
    private static function SQLiteConnectionStr()
    {
        return "";
    }

    /**
     * @return string
     */
    private static function OracleConnectionStr()
    {
        // DSN Sample
        // oci:dbname=//127.0.0.1:1521/ORCL
        return "oci:dbname="
        . self::$SLASH . self::$SLASH
        . Config::$DATABASE_HOST
        . self::$COLUMN . Config::$DATABASE_PORT
        . self::$SLASH . Config::$DATABASE_EXTRA;
    }

    /**
     * @return string
     */
    private static function MysqlConnectionStr()
    {
        return "";
    }

    /**
     * @return string
     */
    private static function PGConnectionStr()
    {
        return "";
    }

    /**
     * @param $text
     */
    private static function checkPDODriver($text)
    {
        $jsonMsg = array(
            'status' => 0,
            'type' => 'DataSource Exception',
            'message' => 'error: DataSource pdo driver is not installed'
        );

        if (!in_array($text, PDO::getAvailableDrivers(),TRUE))
        {
            Utils::errorHandler($jsonMsg);
        }
    }

}