<?php

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