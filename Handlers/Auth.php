<?php

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