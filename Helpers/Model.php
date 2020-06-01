<?php

class Model {

    public $queryString = "";
    public $queryParams = array();
    public $queryPrepare = null;
    public $queryReturn = true;
    public $modelString;

    public function __construct($modelString)
    {
        $this->modelString = $modelString;
    }

    public function Query()
    {
        Injector::loadClass($this->modelString);
        
        $this->queryReturn = getQueryReturn();
        $this->queryString = getQueryString();

        try
        {
            /* Use prepared statements for maximum security against injections */
            $bootStrap =  Database::Initialize();
            $this->queryPrepare = $bootStrap->prepare($this->queryString, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	        $this->queryPrepare->execute($this->queryParams);

        }
        catch (PDOException $e)
        {
            $jsonMsg = array(
                'status' => 0,
                'type' => 'Dabase Error',
                'message' => 'error: ' . $e->getMessage()
            );

            echo json_encode($jsonMsg);
            return false;
        }

        return $this->queryPrepare;
    }
}