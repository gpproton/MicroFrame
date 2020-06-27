<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace App\Helpers;

final class Routes {

    public static function RedirectQuery($queryString)
    {
        header("Status: 301 Moved Permanently");
        header("Location: " . $queryString, TRUE, 301);
        exit();
    }

    // Return actual page link when needed
    public static function PageActualUrl($option = null)
    {
        //TODO: Make useful for new routing mothod
        $currentLink = (isset($_SERVER['HTTPS'])
        && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if(strpos($currentLink, '?') !== false)
        {
            $currentLink = substr($currentLink, 0, strpos($currentLink, '?') - strlen($currentLink));
        }

        if($option !== null)
        {
            return $currentLink . '?mode=' . $option;
        }
        return $currentLink;
    }

    public static function LoadController()
    {

    }

}
