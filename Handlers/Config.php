<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Config {

    // Query string parameters key
    public static $BASE_REAL_PATH;
    const ALLOWED_QUERY_STRINGS_KEYS = array(
        'mode'
    );

    // Query string parameters mode values
    const ALLOWED_QUERY_STRINGS = array(
        'start',
        'list',
        'auth',
        'search',
        'error',
    );

    // Post keys
    const ALLOWED_POST_KEY = array(
        'tlr_submit_login',
        'tlr_auth_user_id',
        'tlr_auth_sec_key',
        'tlr_submit_search',
        'tlr_search_invoice'
        
    );

    public static $STORAGE_PATH;
    public static $CACHE_PATH;
    public static $PASS_KEY;
    public static $AUTH_TYPE;
    public static $AUTH_TIMEOUT;
    public static $SESSION_KEY;
    public static $UPLOAD_BASE_URL;

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
        self::$UPLOAD_BASE_URL = getenv('UPLOAD_BASE_URL');

    }
}

