<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Injector {
    public function __construct()
    { }
    
    public static function loadClass($class)
    {
        $extName = '.php';
        
        $files = array(
            $class . $extName,
            str_replace('_', '/', $class) . $extName,
        );

        foreach (explode(PATH_SEPARATOR, ini_get('include_path')) as $base_path)
        {
            foreach ($files as $file)
            {
                $path = "$base_path/$file";
                if (file_exists($path) && is_readable($path))
                {
                    include_once $path;
                    return;
                }
            }
        }

        return $path;
    }
}