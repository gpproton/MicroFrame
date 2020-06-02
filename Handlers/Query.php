<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Query {

    const STATE_TAGS = Config::ALLOWED_QUERY_STRINGS;

    public function __construct()
    { }

    public static function Filter()
    {
        $query = null;
        if(isset($_SERVER['QUERY_STRING']))
        {
            $query  = explode('&', $_SERVER['QUERY_STRING']);
            if(count($query) > 0 && !empty($query[0]))
            {
                $allowed = Config::ALLOWED_QUERY_STRINGS_KEYS;
                $params = array();
                $filtered = array();

                foreach( $query as $param )
                {
                // prevent notice on explode() if $param has no '='
                if (strpos($param, '=') === false) $param += '=';

                list($name, $value) = explode('=', $param, 2);
                $params[urldecode($name)][] = urldecode($value);
                }

                if(count($params) > 0)
                {
                    $filtered = array_filter(
                        $params,
                        function ($key) use ($allowed) {
                            return in_array($key, $allowed);
                        },
                        ARRAY_FILTER_USE_KEY
                    );
                }
                return $filtered;
            }
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
            // Redirect to error view.
            default:
                $finalQuery = str_replace($firstString . $modeType, $firstString . $locakedStrings[4], $curQuery);
            break;
        }

        return $finalQuery;
    }

    public static function PostData($postKey)
    {
        if(in_array($postKey, Config::ALLOWED_POST_KEY))
        {
            return $_POST[$postKey];
        }
        else
        {
            return null;
        }
    }
}