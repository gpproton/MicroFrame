<?php

require_once 'vendor/autoload.php';

class Test {

    public static function Run()
    {
        try {
            $conn = new PDOOCI\PDO("oci:dbname=//192.168.77.4:1521/ORCL", "orbhn", "orbhn");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            echo "Hahahahaha";
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

    }
}

Test::Run();

