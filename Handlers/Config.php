<?php

final class Config {

    // Parameters
    public static $BASE_REAL_PATH;
    public static $STORAGE_PATH;
    public static $CACHE_PATH;
    public static $PASS_KEY;
    public static $AUTH_TYPE;
    public static $AUTH_TIMEOUT;
    public static $SESSION_KEY;

    // Databse keys

    public static $DATABASE_TYPE;
    public static $DATABASE_HOST;
    public static $DATABASE_PORT;
    public static $DATABASE_USER;
    public static $DATABASE_PASS;
    public static $DATABASE_EXTRA;

    public static function Load()
    {
        // Load env file on project path..
        $BASE_REAL_PATH = realpath(__DIR__ . '/..');
        $dotenv = Dotenv\Dotenv::createImmutable($BASE_REAL_PATH);
        $dotenv->load();

        ///// Variable configurations
        //
        self::$STORAGE_PATH = getenv('STORAGE_PATH');
        self::$CACHE_PATH = getenv('CACHE_PATH');
        self::$PASS_KEY = getenv('PASS_KEY');
        self::$AUTH_TYPE = getenv('AUTH_TYPE');
        self::$AUTH_TIMEOUT = getenv('AUTH_TIMEOUT');
        self::$SESSION_KEY = getenv('SESSION_KEY');

        self::$DATABASE_TYPE = getenv('DATABASE_TYPE');
        self::$DATABASE_HOST = getenv('DATABASE_HOST');
        self::$DATABASE_PORT = getenv('DATABASE_PORT');
        self::$DATABASE_USER = getenv('DATABASE_USER');
        self::$DATABASE_PASS = getenv('DATABASE_PASS');
        self::$DATABASE_EXTRA = getenv('DATABASE_EXTRA');

    }
}

