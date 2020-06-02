<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Session {

    private static $SESSION_KEY = '';
    public static $SESSION_VALUE = '';
    private static $SESSION_TIMEOUT = 0;

    public function __construct()
    {

    }

    public static function Boot()
    {
        self::$SESSION_KEY = Config::$SESSION_KEY;
        self::$SESSION_TIMEOUT = Config::$AUTH_TIMEOUT;
    }

    public static function Confirm()
    {
        if(isset($_COOKIE[self::$SESSION_KEY]))
        {
            return $_COOKIE[self::$SESSION_KEY];
        }
        else
        {
            return null;
        }
    }

    public static function Status()
    {
        return isset($_COOKIE[self::$SESSION_KEY]);
    }

    public static function Setup()
    {
        if(!isset($_COOKIE[self::$SESSION_KEY]))
        {
            setcookie(self::$SESSION_KEY, self::$SESSION_VALUE, time() + self::$SESSION_TIMEOUT * 1, "/");
        }
    }
    
}