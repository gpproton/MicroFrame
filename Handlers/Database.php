<?php

class Database {

    protected static $Connection;
    private static $SLASH = '/';
    private static $COLUMN = ':';

    public function __construct()
    { }

    public static function Initialize()
    {
        $Options = [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array,
          ];

        if(empty(self::$Connection))
        {
            try {

                if(Config::$DATABASE_TYPE == 'oracle')
                {
                    self::$Connection = new PDOOCI\PDO(
                        self::OracleConnectionStr(),
                        Config::$DATABASE_USER,
                        Config::$DATABASE_PASS,
                        $Options
                    );
                    
                }
                else
                {
                    // For others
                    self::$Connection = new PDO("", "", "", $Options);
                }
            } catch(PDOException $e) {
    
                $jsonMsg = array(
                    'status' => 0,
                    'type' => 'Dabase Error',
                    'message' => 'error: ' . $e->getMessage()
                );
    
                echo json_encode($jsonMsg);
                return false;
            }
        }

        return self::$Connection;
    }



    private static function OracleConnectionStr()
    {
        // DSN Sample
        // oci:dbname=//127.0.0.1:1521/ORCL
        return "oci:dbname="
        . self::$SLASH . self::$SLASH
        . Config::$DATABASE_HOST
        . self::$COLUMN . Config::$DATABASE_PORT
        . self::$SLASH . Config::$DATABASE_EXTRA;
    }

    private static function MysqlConnectionStr()
    {
        return "";
    }

    private static function PGConnectionStr()
    {
        return "";
    }

}