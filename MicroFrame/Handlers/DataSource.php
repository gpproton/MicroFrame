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
use MicroFrame\Library\Reflect;
use PDO;
use PDOOCI\PDO as fallbackOraclePDO;

/**
 * Class DataSource
 * @package MicroFrame\Handlers
 */
class DataSource implements IDataSource {

    private $source;
    private $options;
    private $connection;

    /**
     * DataSource constructor and data source connection initializer.
     * @param string $string
     *
     * @return mixed
     */
    public function __construct($string = "default") {

        $this->source = $this->config("data.{$string}");
        $connectStringParams = array(
            'config' => $this->source
        );

        if (isset($this->source) && is_null($this->connection)) {

            $timeout = isset($this->source['timeout']) ? $this->source['timeout'] : 150;

            $this->options = [
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
                $connectionString = Reflect::check()->methodLoader($this, $this->source['type'], $connectStringParams);

                /**
                 * Circumvent issues if OCI PDO driver is not available.
                 */
                if (!$this->validate($this->source['type'], true) && $this->source['type'] === "oracle") {
                    $this->connection = new fallbackOraclePDO($connectionString, $this->source['user'], $this->source['password']);
                }

                else if ($this->validate($this->source['type'])) {
                    /**
                     * Initialize standard PDO connection.
                     */

                    if (($this->source['type'] === 'sqlite')) {
                        $this->connection = new PDO($connectionString);
                    } else {
                        $this->connection = new PDO($connectionString, $this->source['user'], $this->source['password']);

                    }
                }
            } catch (\Exception $exception) {
                /**
                 * handle all data source exceptions...
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
     * @param $name
     * @return array|mixed|null
     */
    public function config($name)
    {
        return Config::fetch($name);
    }

    /**
     * @param null $string
     * @param bool $cache
     * @param bool $status
     * @return PDO | mixed
     */
    public static function get($string = null, $cache = false, $status = false) {
        if (!$status) {
            return empty($string) ? (new self())->connection : (new self($string))->connection;
        } else {
            return empty($string) ? (new self())->source : (new self($string))->source;
        }

    }

    /**
     * @param null $config
     * @param bool $cache
     * @return string
     */
    public function sqlite($config = null, $cache = false)
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
    public function oracle($config = null)
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
    public function mssql($config = null)
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
    public function mysql($config = null)
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
    public function postgres($config = null)
    {
        /**
         * pgsql:host=hostname;port=5432;dbname=testdb
         */
        if (!is_null($config)) return "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        return null;
    }

    /**
     * Check if specified datasource type is supported.
     *
     * @param $text
     * @param bool $checkOnly
     * @return bool
     */
    private function validate($text, $checkOnly = false)
    {
        $drivers = array(
            'sqlite' => 'sqlite',
            'mysql' => 'mysql',
            'mssql' => 'mssql',
            'postgres' => 'pgsql',
            'oracle' => 'oci'
        );

        if(!in_array($drivers[$text], PDO::getAvailableDrivers(), TRUE) && $checkOnly) return false;
        else {
            return true;
        }
    }

}