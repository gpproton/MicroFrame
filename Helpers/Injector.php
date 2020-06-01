<?php

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