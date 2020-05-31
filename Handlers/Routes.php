<?php

final class Routes {

    private static $RouteMode;
    private static $queryString;

    // Fixed tags for query strings
    const QUERY_MODE = 'mode';
    const STATE_TAGS = array(
        'start',
        'list',
        'auth',
        'search',
        'error',
    );

    public function __construct()
    { }

    public static function Initialize()
    {
        // Initialize query class

        self::$queryString = Query::Filter();

        if(count(self::$queryString) < 1)
        {
            self::$RouteMode = self::STATE_TAGS[0];
        }
        else
        {
            self::$RouteMode = self::$queryString[self::QUERY_MODE][0];
        }

        if(!Auth::Verify())
        {
            self::RedirectQuery('?' . $_SERVER['QUERY_STRING']);
        }

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
        header("Location: /" . $queryString);
    }

    private static function StartController()
    {
        Utils::viewLoader(self::$RouteMode);
        StartView::Render();
    }

    private static function ListController()
    {
        // Check if from done state
        // self::RedirectQuery('?' . Query::ModeSwitch('main'));

        Utils::viewLoader(self::$RouteMode);
        ListView::Render();
    }

    private static function SearchController()
    {
        Utils::viewLoader(self::$RouteMode);
        SearchView::Render();

        if(Session::Status())
        {

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
