<?php

final class Query {

    const STATE_TAGS = array(
        'start',
        'list',
        'auth',
        'search',
        'error'
    );

    public function __construct()
    { }

    public static function Filter()
    {
        $query = "";
        if(isset($_SERVER['QUERY_STRING']))
        {
            $query  = explode('&', $_SERVER['QUERY_STRING']);

            $params = array();

            foreach( $query as $param )
            {
            // prevent notice on explode() if $param has no '='
            if (strpos($param, '=') === false) $param += '=';

            list($name, $value) = explode('=', $param, 2);
            $params[urldecode($name)][] = urldecode($value);
            }

            return $params;
        }
        
        return [];

    }

    public static function ModeSwitch($modeType)
    {
        $curQuery = $_SERVER['QUERY_STRING'];
        $firstString = 'mode=';
        $finalQuery = '';
        $locakedStrings = self::STATE_TAGS;

        switch($modeType)
        {
            // Transfer and auth active already - redirect to done.
            case $locakedStrings[1]:
                $finalQuery = str_replace($firstString . $modeType, $firstString . $locakedStrings[3], $curQuery);
            break;
            // Auth sucessfully - redirect to done.
            case $locakedStrings[2]:
                $finalQuery = str_replace($firstString . $modeType, $firstString . $locakedStrings[3], $curQuery);
            break;
             // Done view displyed - redirect to auth.
            case $locakedStrings[3]:
                $finalQuery = str_replace($firstString . $modeType, $firstString . $locakedStrings[2], $curQuery);
            break;
            // Redirect to error view.
            default:
                $finalQuery = str_replace($firstString . $modeType, $firstString . $locakedStrings[4], $curQuery);
            break;
        }

        return $finalQuery;
    }

    public static function PostData($postKey)
    {
        if(isset($_POST['tlr_submit']))
        {
            return $_POST[$postKey];
        }
        else
        {
            return null;
        }
    }
}