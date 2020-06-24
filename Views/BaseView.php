<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */


class BaseView {

    protected static function Header()
    {
        if(isset(Query::Filter()['mode'])) if(Query::Filter()['mode'][0] === Config::ALLOWED_QUERY_STRINGS[5]) Session::Explunge();
        
        $baseUrl = Routes::PageActualUrl();
        $siteTitle = Config::$SITE_TITLE;
        $iconImage = "<a href='" . $baseUrl . "'><img src='" . $baseUrl . "Assets/Icons/apple-icon.png' style='height: 32px;' alt='logo' /></a>";
        $iconsBasePath = $baseUrl . 'Assets/Icons';
        $logOutLink = "";
        $faqsLink = "<a class='mdl-navigation__link' href='" . Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[0]) . "'>FAQ's</a>";
        if(Auth::Verify()) $logOutLink = "<a class='mdl-navigation__link' href='" . Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[5]) . "'>Sign Out</a>";
        return <<<EOF

        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="HandheldFriendly" content="true">
                <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
                <!-- Load icon library -->
                <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
                <link rel="stylesheet" href="./Libs/style/materialize.min.css">
                <link rel="stylesheet" href="./Libs/style/main.css">
                <!-- Load Icons / Logos -->
                <link rel="apple-touch-icon" sizes="57x57" href="{$iconsBasePath}/apple-icon-57x57.png">
                <link rel="apple-touch-icon" sizes="60x60" href="{$iconsBasePath}/apple-icon-60x60.png">
                <link rel="apple-touch-icon" sizes="72x72" href="{$iconsBasePath}/apple-icon-72x72.png">
                <link rel="apple-touch-icon" sizes="76x76" href="{$iconsBasePath}/apple-icon-76x76.png">
                <link rel="apple-touch-icon" sizes="114x114" href="{$iconsBasePath}/Icons/apple-icon-114x114.png">
                <link rel="apple-touch-icon" sizes="120x120" href="{$iconsBasePath}/apple-icon-120x120.png">
                <link rel="apple-touch-icon" sizes="144x144" href="{$iconsBasePath}/apple-icon-144x144.png">
                <link rel="apple-touch-icon" sizes="152x152" href="{$iconsBasePath}/apple-icon-152x152.png">
                <link rel="apple-touch-icon" sizes="180x180" href="{$iconsBasePath}/apple-icon-180x180.png">
                <link rel="icon" type="image/png" sizes="192x192"  href="{$iconsBasePath}/android-icon-192x192.png">
                <link rel="icon" type="image/png" sizes="32x32" href="{$iconsBasePath}/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="96x96" href="{$iconsBasePath}/favicon-96x96.png">
                <link rel="icon" type="image/png" sizes="16x16" href="{$iconsBasePath}/favicon-16x16.png">
                <link rel="manifest" href="{$iconsBasePath}/manifest.json">
                <meta name="msapplication-TileColor" content="#ffffff">
                <meta name="msapplication-TileImage" content="{$iconsBasePath}/ms-icon-144x144.png">
                <meta name="theme-color" content="#ffffff">
                <title>{$siteTitle}</title>
            </head>
            <body>
            <div class="container">        
        
    
EOF;
    }

    protected static function Footer()
    {
        return <<<EOF

                </div>
                <!--<script src="./Libs/js/alpine.min.js" defer></script>-->
                <script defer src="./Libs/js/materialize.min.js"></script>
                <script src="./Libs/js/main.js" defer></script>
            </body>
        </html>

EOF;
    }

    public static function Render()
    {
        echo self::Header();

        echo static::Content();

        echo self::Footer();
    }

}