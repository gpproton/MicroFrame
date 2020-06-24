<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Routes {

    private static $RouteMode;
    private static $queryString = [];

    // Fixed tags for query strings
    const QUERY_MODE = 'mode';
    const STATE_TAGS = Config::ALLOWED_QUERY_STRINGS;

    public function __construct()
    { }

    public static function Initialize()
    {
        self::$RouteMode = self::STATE_TAGS[2];
        self::AuthController();
    }

    public static function RedirectQuery($queryString)
    {
        header("Status: 301 Moved Permanently");
        header("Location: " . $queryString, TRUE, 301);
        exit();
    }

    // Return actual page link when needed
    public static function PageActualUrl($option = null)
    {
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

    // All view controllers
    // Temp Auth placeholder for devel
    private static function AuthController()
    {
        Utils::viewLoader(self::$RouteMode);
        AuthView::Render();

    }

    // private static function FaqsController()
    // {
    //     Utils::viewLoader(self::$RouteMode);
    //     FaqsView::Render();
    // }

    // private static function ListController()
    // {
    //     Utils::viewLoader(self::$RouteMode);
    //     if(Query::PostData('tlr_submit_search') === null)
    //     {
    //         self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[3]));
    //     }
    //     else
    //     {
    //         ListView::Render();
    //     }
    // }

    // private static function SearchController()
    // {
    //     Utils::viewLoader(self::$RouteMode);
    //     if(Query::PostData('tlr_submit_search') !== null)
    //     {
    //         self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[1]));
    //     }
    //     else
    //     {
    //         SearchView::Render();
    //     }
    // }

    // private static function ErrorController()
    // {
    //     Utils::viewLoader(self::$RouteMode);
    //     ErrorView::Render();
    // }

    // private static function SignOutController()
    // {
    //     Utils::viewLoader(self::$RouteMode);
    //     SignOutView::Render();
    // }

}
