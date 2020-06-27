<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace App\Helpers;

final class Config {

    // Query string parameters key
    public static $BASE_REAL_PATH;
    public static $PRODUCTION_MODE;
    public static $SITE_TITLE;
    public static $STORAGE_PATH;
    public static $CACHE_PATH;
    public static $PASS_KEY;
    public static $AUTH_TYPE;
    public static $AUTH_TIMEOUT;
    public static $SESSION_KEY;
    public static $UPLOAD_BASE_URL;

    // Databse keys
    public static $DATA_SOURCE;

    public static $DATABASE_TYPE;
    public static $DATABASE_HOST;
    public static $DATABASE_PORT;
    public static $DATABASE_USER;
    public static $DATABASE_PASS;
    public static $DATABASE_EXTRA;

    public static function Load()
    {
        // Load env file on project path..
        $BASE_REAL_PATH = realpath(__DIR__ . '/../..');
        $dotenv = \Dotenv\Dotenv::createImmutable($BASE_REAL_PATH);
        $dotenv->load();

        ///// Variable configurations
        //
        self::$PRODUCTION_MODE = getenv('PRODUCTION_MODE') === 'true';
        self::$SITE_TITLE = getenv('SITE_TITLE');
        self::$STORAGE_PATH = getenv('STORAGE_PATH');
        self::$CACHE_PATH = getenv('CACHE_PATH');
        self::$PASS_KEY = getenv('PASS_KEY');
        self::$AUTH_TYPE = getenv('AUTH_TYPE');
        self::$AUTH_TIMEOUT = getenv('AUTH_TIMEOUT');
        self::$SESSION_KEY = getenv('SESSION_KEY');

        self::$DATA_SOURCE = json_decode(getenv('DATA_SOURCE'), FALSE);

        self::$DATABASE_TYPE = getenv('DATABASE_TYPE');
        self::$DATABASE_HOST = getenv('DATABASE_HOST');
        self::$DATABASE_PORT = getenv('DATABASE_PORT');
        self::$DATABASE_USER = getenv('DATABASE_USER');
        self::$DATABASE_PASS = getenv('DATABASE_PASS');
        self::$DATABASE_EXTRA = getenv('DATABASE_EXTRA');
        self::$UPLOAD_BASE_URL = getenv('UPLOAD_BASE_URL');

    }
}

