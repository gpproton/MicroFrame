<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Config helper class
 * 
 * PHP Version 5
 * 
 * @category  Helpers
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to 
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Helpers;

final class Config {

    // Query string parameters key
    public static $PRODUCTION_MODE;
    public static $ROUTE_MODE;
    public static $SITE_TITLE;
    public static $PASS_KEY;
    public static $AUTH_TYPE;
    public static $AUTH_TIMEOUT;
    public static $SESSION_KEY;

    public static $DATA_SOURCE;
    public static $STORAGE_PATH;
    public static $CACHE_PATH;

    /**
     * Initialize configurations values
     */
    public static function Load()
    {
        // Load env file on project path..
        $BASE_REAL_PATH = BASE_PATH;
        $dotEnv = \Dotenv\Dotenv::createImmutable($BASE_REAL_PATH);
        $dotEnv->load();

        /**
         * Variable configurations
         */
        self::$PRODUCTION_MODE = getenv('PRODUCTION_MODE') === 'true';

        self::$ROUTE_MODE = getenv('ROUTE_MODE');

        self::$SITE_TITLE = getenv('SITE_TITLE');

        self::$PASS_KEY = getenv('PASS_KEY');

        self::$AUTH_TYPE = getenv('AUTH_TYPE');

        self::$AUTH_TIMEOUT = getenv('AUTH_TIMEOUT');

        self::$SESSION_KEY = getenv('SESSION_KEY');


        self::$DATA_SOURCE = json_decode(str_replace("'", "\"", getenv('DATA_SOURCE')), false);

        self::$STORAGE_PATH = getenv('STORAGE_PATH');

        self::$CACHE_PATH = getenv('CACHE_PATH');

    }
}

