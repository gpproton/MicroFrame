<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace App\Handlers;

use App\Helpers\HTTPQuery;

final class Routes {

    public function __construct()
    { }

    public static function Initialize()
    {
        // echo var_dump(\App\Helpers\Config::$DATA_SOURCE->default->host);

            if(empty(HTTPQuery::RequestGetData()))
            {
                echo 'Hallo';

                return FALSE;
            }
            else
            {
                echo var_dump(HTTPQuery::RequestGetData());

                return TRUE;
            }
    }

}
