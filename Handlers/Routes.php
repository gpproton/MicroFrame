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
        self::$queryString = Query::Filter();
        $authStates = (
            count(self::$queryString) < 1
            || !in_array(self::$queryString['mode'][0], Config::ALLOWED_QUERY_STRINGS)
            || self::$queryString['mode'][0] === self::STATE_TAGS[2]
        );

        // Set and filter modes as required
        if($authStates)
        {
            self::$RouteMode = self::STATE_TAGS[2];
        }
        else
        {
            self::$RouteMode = self::$queryString['mode'][0];
        }

        // Authentication redirections
        if(!Auth::Verify() && !$authStates)
        {
            // self::RedirectQuery('?' . $_SERVER['QUERY_STRING']);
            // self::RedirectQuery('?' . Query::ModeSwitch('main'));
            self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[2]));
        }
        else if(Auth::Verify() && $authStates)
        {
            self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[3]));
        }
        
        // Route controllers match with modes
        switch(self::$RouteMode)
        {
            case self::STATE_TAGS[0]:
                self::StartController();
            break;
            case self::STATE_TAGS[1]:
                self::ListController();
            break;
            case self::STATE_TAGS[2]:
                self::AuthController();
            break;
            case self::STATE_TAGS[3]:
                self::SearchController();
            break;
            case self::STATE_TAGS[4]:
                self::ErrorController();
            break;
            default:
                self::StartController();
            break;
        }
    }

    public static function RedirectQuery($queryString)
    {
        header("Status: 301 Moved Permanently");
        header("Location: " . $queryString, TRUE, 301);
        exit();
    }

    // Return actual page link when needed
    public static function PageActualUrl($option)
    {
        $currentLink = (isset($_SERVER['HTTPS'])
        && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if(strpos($currentLink, '?'))
        {
            $currentLink = substr($currentLink, 0, strpos($currentLink, '?') - strlen($currentLink));
        }

        if($option !== 'base')
        {
            return $currentLink . '?mode=' . $option;
        }
        return $currentLink;
    }

    // All view controllers
    private static function StartController()
    {
        Utils::viewLoader(self::$RouteMode);
        StartView::Render();
    }

    private static function ListController()
    {
        Utils::viewLoader(self::$RouteMode);
        if(Query::PostData('tlr_submit_search') === null)
        {
            self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[3]));
        }
        else
        {
            ListView::Render();
        }
    }

    private static function SearchController()
    {
        Utils::viewLoader(self::$RouteMode);
        if(Query::PostData('tlr_submit_search') !== null)
        {
            self::RedirectQuery(self::PageActualUrl(self::STATE_TAGS[1]));
        }
        else
        {
            SearchView::Render();
        }
    }

    private static function ErrorController()
    {
        Utils::viewLoader(self::$RouteMode);
        ErrorView::Render();
    }

    private static function AuthController()
    {
        Utils::viewLoader(self::$RouteMode);
        AuthView::Render();

    }

}
