<?php

final class Auth {

    public function __construct()
    { }

    public static function Verify()
    {
        Config::Load();
        Session::Boot();

        Session::$SESSION_VALUE = Query::PostData('tlr_passkey');

        if(isset(Session::$SESSION_VALUE) && Session::$SESSION_VALUE !== self::Key())
        {
            return false;
        }
        else if(!Session::Status() && Session::$SESSION_VALUE=== self::Key())
        {
            Session::Setup();
            return Session::Status();
        }
        else
        {
            return true;
        }
    }

    private function Key()
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
    private function PassKey()
    {
        return Config::$PASS_KEY;
    }

    private function Database()
    {
        return '';
    }

    private function Auth0()
    {
        return '';
    }

}