<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace App;

use \App\Helpers\Config;
use \App\Handlers\Routes;

final class Core {

    public function __construct()
    {
        // Auto loader class injection.
        spl_autoload_register(function ($class)
        {
            $nameSpacePath = str_replace('\\', '/', $class) . '.php';
            if(is_file($nameSpacePath))
            {
                require $nameSpacePath;
            }
        });
    }

    public function Run()
    {
        Config::Load();
        Routes::Initialize();
    }
}
