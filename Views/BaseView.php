<?php

class BaseView {

    protected static function Header()
    {
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
                <link rel="stylesheet" href="./Libs/style/material.min.css">
                <link rel="stylesheet" href="./Libs/style/main.css">
                <title>TDLOADS</title>
            </head>
            <body>
            <div class="dl-card-square mdl-card mdl-shadow--2dp">
                <div class="mdl-card__supporting-text">
        
        
    
EOF;
    }

    protected static function Footer()
    {
        return <<<EOF
                </div>
            </div>
        <script defer src="./Libs/js/material.min.js"></script>
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