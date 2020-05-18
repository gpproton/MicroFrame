<?php

require 'vendor/autoload.php';

final class Main {

    private $HandlerConfig = 'Handlers_Config';
    private $HandlersQuery = 'Handlers_Query';
    private $HandlerRoutes = 'Handlers_Routes';

    private $HelpersUtils = 'Helpers_Utils';
    private $HandlersSession = 'Handlers_Session';
    private $HandlersAuth = 'Handlers_Auth';

    public function __construct()
    {
        // Class Injections..

        Injector::loadClass($this->HandlerConfig);
        Injector::loadClass($this->HandlersQuery);
        Injector::loadClass($this->HandlerStream);
        Injector::loadClass($this->HelpersPath);
        Injector::loadClass($this->HandlerRoutes);

        // Auto loads required classes
        Config::Load();

    }

    public function Run()
    {
        // Boot up..
        Injector::loadClass($this->HelpersUtils);
        Injector::loadClass($this->HandlersSession);
        Injector::loadClass($this->HandlersAuth);

        Routes::Initialize();
    }
}
