<?php

require 'vendor/autoload.php';

final class Main {

    private $HandlersConfig = 'Handlers_Config';
    private $HandlersDatabase = 'Handlers_Database';
    private $HandlersQuery = 'Handlers_Query';
    private $HandlersRoutes = 'Handlers_Routes';

    private $HelpersUtils = 'Helpers_Utils';
    private $HandlersSession = 'Handlers_Session';
    private $HandlersAuth = 'Handlers_Auth';

    public function __construct()
    {
        ////////
        // Class Injections..
        ///////

        // Priority
        Injector::loadClass($this->HandlersConfig);
        Injector::loadClass($this->HandlersDatabase);

        Injector::loadClass($this->HandlersQuery);
        Injector::loadClass($this->HandlersRoutes);

        // Auto loads required classes
        Config::Load();

    }

    public function Run()
    {
        // Boot up..
        Injector::loadClass($this->HelpersUtils);
        Injector::loadClass($this->HandlersSession);
        Injector::loadClass($this->HandlersAuth);

        // Boot Database
        if(Database::Initialize())
        {
            Routes::Initialize();
        }

    }
}
