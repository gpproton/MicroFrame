<?php
/**
 * Datasource Handler class
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

use MicroFrame\Interfaces\IDataSource;
use MicroFrame\Library\Config;
use PDO;

/**
 * Class DataSource
 * @package MicroFrame\Handlers
 */
class DataSource implements IDataSource {

    private $source = SYS_DATA_SOURCE;
    private $options;

    /**
     * DataSource constructor.
     * @param string $string
     */
    public function __construct($string = "default")
    {

        if (!empty($this->source) && isset($this->source[$string])) {
            $this->source = (object) $this->source[$string];

            $timeout = isset($this->source->timeout) ? $this->source->timeout : 250;
            $this->options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => $timeout,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

        }
    }

    /**
     * @param $name
     * @return array|mixed|null
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    public static function get($string = null) {
        return is_null($string) ? new self() : new self($string);
    }

//    public function __construct($type = null)
//    {
//
//        if(empty(self::$Connection))
//        {
//            try {
//
//                switch(Config::$DATABASE_TYPE)
//                {
//                    case 'oracle':
//                        if (self::checkPDODriver('oci'))
//                        {
//                            self::$Connection = new PDO(
//                                self::OracleConnectionStr(),
//                                Config::$DATABASE_USER,
//                                Config::$DATABASE_PASS,
//                                $Options
//                            );
//                        }
//                        else
//                        {
//                            self::$Connection = new PDOOCI\PDO(
//                                self::OracleConnectionStr(),
//                                Config::$DATABASE_USER,
//                                Config::$DATABASE_PASS,
//                                $Options
//                            );
//                        }
//                    break;
//                    case 'postgres':
//                        if (self::checkPDODriver('pgsql'))
//                        {
//                            self::$Connection = new PDO(
//                                self::PGConnectionStr(),
//                                Config::$DATABASE_USER,
//                                Config::$DATABASE_PASS,
//                                $Options
//                            );
//                        }
//                    break;
//                    case 'mysql':
//                        if (self::checkPDODriver('mysql'))
//                        {
//                            self::$Connection = new PDO(
//                                self::MysqlConnectionStr(),
//                                Config::$DATABASE_USER,
//                                Config::$DATABASE_PASS,
//                                $Options
//                            );
//                        }
//                    break;
//                    case 'sqlite':
//                        if (self::checkPDODriver('sqlite'))
//                        {
//                            self::$Connection = new PDO(
//                                self::SQLiteConnectionStr(),
//                                Config::$DATABASE_USER,
//                                Config::$DATABASE_PASS,
//                                $Options
//                            );
//                        }
//                    break;
//                    default:
//                        //self::$Connection = new PDO("", "", "", $Options);
//                        return false;
//                }
//
//            } catch(PDOException $e) {
//
//                $jsonMsg = array(
//                    'status' => 0,
//                    'type' => 'DataSource Exception',
//                    'message' => 'error: ' . $e->getMessage()
//                );
//
//                if(!Utils::getLocalStatus())
//                {
//                    Utils::errorHandler($jsonMsg);
//                }
//
//            }
//        }
//
//        return self::$Connection;
//    }
//

    /**
     * @param null $config
     * @param bool $cache
     * @return string
     */
    private function sqlite($config = null, $cache = false)
    {
        /**
         * sqlite:/path/to/sqlite/file.sq3
         */
        if (is_file($config['dbname'])) {
            $filePath = $config['dbname'];
        } else {
            $filePath = $cache ? DATA_PATH . "/Cache/" . $config['dbname'] : DATA_PATH . "/Local/" . $config['dbname'];
        }
        if (!is_null($config)) return "sqlite:{$filePath}";

        return null;
    }

    /**
     * @param null $config
     * @return string
     */
    private function oracle($config = null)
    {
        /**
         * oci:dbname=//hostname:port/ORCL
         */
        if (!is_null($config)) return "oci:dbname=//{$config['host']}:{$config['port']}/{$config['dbname']}";

        return null;
    }

    /**
     * @param null $config
     * @return string
     */
    private function mssql($config = null)
    {
        /**
         * mssql:host=hostname:port;dbname=database
         */
        if (!is_null($config)) return "mssql:host={$config['host']}:{$config['port']};dbname={$config['dbname']}";

        return null;
    }

    /**
     * @param null $config
     * @return string
     */
    private function mysql($config = null)
    {
        /**
         * mysql:host=hostname;port=3306;dbname=dbname
         */
        if (!is_null($config)) return "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        return null;
    }

    /**
     * @param null $config
     * @return string
     */
    private function postgres($config = null)
    {
        /**
         * pgsql:host=hostname;port=5432;dbname=testdb
         */
        if (!is_null($config)) return "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        return null;
    }

    /**
     * @param null $config
     * @return string
     */
    private function redis($config = null)
    {
        /**
         *
         */

        return null;
    }

    /**
     * @param $text
     * @throws Exception
     */
    private function checkPDO($text)
    {
        if (!in_array($text, PDO::getAvailableDrivers(),TRUE))
        {
            throw new Exception("PDO driver is missing");
        }
    }

}