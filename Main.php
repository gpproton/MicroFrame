<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

require 'vendor/autoload.php';

final class Main {

    private $HandlersConfig = 'Handlers_Config';
    private $HandlersDatabase = 'Handlers_Database';
    private $HelpersModel = 'Helpers_Model';
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
        Injector::loadClass($this->HelpersModel);

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
        if(Utils::getLocalStatus())
        {
            Routes::Initialize();
        }
        else if(Database::Initialize())
        {
            Routes::Initialize();
        }

    }
}
