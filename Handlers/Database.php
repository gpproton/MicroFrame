<?php

class Database {

    private static $Connection;
    private static $SLASH = '/';
    private static $COLUMN = ':';

    public static function Initialize()
    {
        try {
            if(Config::$DATABASE_TYPE == 'oracle')
            {
                self::$Connection = new PDOOCI\PDO(
                    self::OracleConnectionStr(),
                    Config::$DATABASE_USER,
                    Config::$DATABASE_PASS
                );
                
                self::$Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            else
            {

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

        return true;
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

    }

    private static function PGConnectionStr()
    {

    }

}