<?php

require './helpers/Injector.php';

// Base class injection
Injector::loadClass('Main');

// Initialize processes..
$baseApp = new Main;
$baseApp->Run();
