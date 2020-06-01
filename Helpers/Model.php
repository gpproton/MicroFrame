<?php

class Model {

    public $queryString;
    public $queryParams;
    public $queryPrepare;
    public $queryReturn;

    public function __construct($modelString)
    {
        Injector::loadClass($modelString);

        try
        {
            /* Use prepared statements for maximum security against injections */
            $bootStrap =  Database::Initialize();
            $this->queryPrepare = $bootStrap->query($this->queryString);
            
            $this->queryString = "SELECT * FROM
            (SELECT oft.FT_TXN_NO, oft.FT_NEW_VEHICLE_NUMBER
            FROM OT_FLEET_TIME oft)
            WHERE ROWNUM <= 5";
            
            while ($row = $this->queryPrepare->fetch(PDO::FETCH_ASSOC))
            {
                echo var_dump($row) . '<br>';
            }
    
            // $this->queryPrepare->execute($this->queryParams);
        }
        catch (PDOException $e)
        {
            $jsonMsg = array(
                'status' => 0,
                'type' => 'Dabase Error',
                'message' => 'error: ' . $e->getMessage()
            );

            echo json_encode($jsonMsg);

            exit();
            // return false;
        }

        if($this->queryReturn)
        {
            // return $this->queryPrepare;
        }

        // return false;
    }
}