<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Auth {

    public function __construct()
    { }

    public static function Verify()
    {
        Session::Boot();

        // Key validation with session or post data
        if(empty(Query::PostData('tlr_auth_sec_key')) && !empty(Session::Confirm()))
        {
            Session::$SESSION_VALUE = Session::Confirm();
        }
        else if (
            !empty(Query::PostData('tlr_auth_sec_key'))
            && Query::PostData('tlr_submit_login') !== null
            && empty(Session::Confirm())
        )
        {
            Session::$SESSION_VALUE = Query::PostData('tlr_auth_sec_key');
        }

        // 
        if(isset(Session::$SESSION_VALUE) && Session::$SESSION_VALUE !== self::Key())
        {
            return false;
        }
        else if(!Session::Status() && Session::$SESSION_VALUE === self::Key())
        {
            Session::Setup();
            return true;
        }
        else if(Session::Status() && Session::$SESSION_VALUE === self::Key())
        {
            return Session::Status();
        }
        else
        {
            return false;
        }
    }

    private static function Key()
    {
        switch(Config::$AUTH_TYPE)
        {
            case 'passkey':
                return self::PassKey();
            case 'database':
                return self::Database();
            case 'auth0':
                return self::Auth0();
            default:
                return '';
        }
    }

    // Auth JWT auth sources
    private static function PassKey()
    {
        return Config::$PASS_KEY;
    }

    private static function Database()
    {
        return '';
    }

    private static function Auth0()
    {
        return '';
    }

}