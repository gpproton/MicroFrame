<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */


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
            PDO::ATTR_TIMEOUT => 5, // PDO timeout for queries
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array,
          ];

        if(empty(self::$Connection))
        {
            try {

                switch(Config::$DATABASE_TYPE)
                {
                    case 'oracle':
                        if (in_array("oci",PDO::getAvailableDrivers(),TRUE))
                        {
                            self::$Connection = new PDO(
                                self::OracleConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            ); 
                        }
                        else
                        {
                            self::$Connection = new PDOOCI\PDO(
                                self::OracleConnectionStr(),
                                Config::$DATABASE_USER,
                                Config::$DATABASE_PASS,
                                $Options
                            );
                        }
                        break;
                    default:
                        //self::$Connection = new PDO("", "", "", $Options);
                        return false;
                }

            } catch(PDOException $e) {
    
                $jsonMsg = array(
                    'status' => 0,
                    'type' => 'Dabase Error',
                    'message' => 'error: ' . $e->getMessage()
                );

                if(!Utils::getLocalStatus())
                {
                    Utils::errorHandler($jsonMsg);
                }
                
            }
        }

        return self::$Connection;
    }

    private static function SQLiteConnectionStr()
    {
        return "";
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