<?php
/**
 * Datasource Handler class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

defined('BASE_PATH') or exit('No direct script access allowed');

use MicroFrame\Interfaces\IDataSource;
use MicroFrame\Library\Config;
use MicroFrame\Library\Reflect;
use PDO;
use PDOOCI\PDO as fallbackOraclePDO;

/**
 * DataSource class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class DataSource implements IDataSource
{
    /**
     * A string for requesting for specific datasource config.
     *
     * @var string
     */
    private $_source;

    /**
     * An array of PDO connection options.
     *
     * @var array
     */
    private $_options;

    /**
     * An instance of datasource connection.
     *
     * @var IDataSource
     */
    private $_connection;

    /**
     * DataSource constructor and data source connection initializer.
     *
     * @param string $string here
     *
     * @return self|IDataSource
     */
    public function __construct($string = "default")
    {
        $this->_source = $this->config("dataSource.{$string}");
        $connectStringParams = array(
            'config' => $this->_source
        );

        if (isset($this->_source) && is_null($this->_connection)) {
            $timeout = isset($this->_source['timeout'])
                ? $this->_source['timeout'] : 150;

            $this->_options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => $timeout,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                /**
                 * Reflect method for connection string generation.
                 */
                $connectionString = Reflect::check()
                    ->methodLoader(
                        $this,
                        $this->_source['type'],
                        $connectStringParams
                    );

                /**
                 * Circumvent issues if OCI PDO driver is not available.
                 */
                if (!$this->_validate(
                    $this->_source['type'],
                    true
                ) && $this->_source['type'] === "oracle"
                ) {
                    $this->_connection = new fallbackOraclePDO(
                        $connectionString,
                        $this->_source['user'],
                        $this->_source['password']
                    );
                } elseif ($this->_validate($this->_source['type'])) {
                    /**
                     * Initialize standard PDO connection.
                     */

                    if (($this->_source['type'] === 'sqlite')) {
                        $this->_connection = new PDO($connectionString);
                    } else {
                        $this->_connection = new PDO(
                            $connectionString,
                            $this->_source['user'],
                            $this->_source['password']
                        );
                    }
                }
            } catch (\Exception $exception) {
                /**
                 * Handle all data source exceptions...
                 */
                Exception::init()->output($exception->getMessage());
            }

            return $this;
        } else {
            /**
             * Manually throw exception...
             */
            try {
                throw new Exception("Requested data source does not exist...");
            } catch (Exception $exception) {
                $exception->output();
            }
        }
    }

    /**
     * Retrieves configuration.
     *
     * @param string $name here
     *
     * @return mixed
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * DataSource static initializer.
     *
     * @param null $string here
     * @param bool $cache  here
     * @param bool $status here
     *
     * @return PDO|mixed
     */
    public static function get($string = null, $cache = false, $status = false)
    {
        if (!$status) {
            return empty($string) ?
                (new self())->_connection : (new self($string))->_connection;
        } else {
            return empty($string) ?
                (new self())->_source : (new self($string))->_source;
        }
    }

    /**
     * Sqlite config string builder.
     *
     * @param array $config here
     *
     * @return string
     */
    public function sqlite($config = null)
    {
        /**
         * Sqlite:/path/to/sqlite/file.sq3
         */
        if (is_file($config['dbname'])) {
            $filePath = $config['dbname'];
        } else {
            $filePath = DATA_PATH . "/Local/" . $config['dbname'];
        }
        if (!is_null($config)) {
            return "sqlite:{$filePath}";
        }

        return null;
    }

    /**
     * Oracle config string builder.
     *
     * @param array $config here
     *
     * @return string
     */
    public function oracle($config = null)
    {
        /**
         * Oci:dbname=//hostname:port/ORCL
         */
        if (!is_null($config)) {
            return "oci:dbname=//" . $config['host'] .
                ":" . $config['port'] . "/" . $config['dbname'];
        }

        return null;
    }

    /**
     * MSSQL config string builder.
     *
     * @param array $config here
     *
     * @return string
     */
    public function mssql($config = null)
    {
        /**
         * Mssql:host=hostname:port;dbname=database
         */
        if (!is_null($config)) {
            return "mssql:host=" . $config['host'] . ":" .
                $config['port'] . ";dbname=" . $config['dbname'];
        }

        return null;
    }

    /**
     * Mysql config string builder.
     *
     * @param array $config here
     *
     * @return string
     */
    public function mysql($config = null)
    {
        /**
         * Mysql:host=hostname;port=3306;dbname=dbname
         */
        if (!is_null($config)) {
            return "mysql:host=" . $config['host'] . ";port=" .
                $config['port'] . ";dbname=" . $config['dbname'];
        }

        return null;
    }

    /**
     * Postgres config string builder.
     *
     * @param array $config here
     *
     * @return string
     */
    public function postgres($config = null)
    {
        /**
         * Pgsql:host=hostname;port=5432;dbname=testdb
         */
        if (!is_null($config)) {
            return "pgsql:host=" . $config['host'] . ";port=" .
                $config['port'] . ";dbname=" . $config['dbname'];
        }

        return null;
    }

    /**
     * Check if specified datasource type is supported.
     *
     * @param string $text      here
     * @param bool   $checkOnly here
     *
     * @return bool
     */
    private function _validate($text, $checkOnly = false)
    {
        $drivers = array(
            'sqlite' => 'sqlite',
            'mysql' => 'mysql',
            'mssql' => 'mssql',
            'postgres' => 'pgsql',
            'oracle' => 'oci'
        );

        if (!in_array(
            $drivers[$text],
            PDO::getAvailableDrivers(),
            true
        ) && $checkOnly
        ) {
            return false;
        } else {
            return true;
        }
    }
}
