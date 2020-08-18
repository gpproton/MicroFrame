<?php
/**
 * Help View
 *
 * PHP Version 7
 *
 * @category  DefaultView
 * @package   MicroFrame\Defaults\View
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/microframe
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel=“canonical” href=“<?=$url?>” />
    <title><?=$options['title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load CSS lib -->
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
    <!--Import Google Icon Font-->
    <link href="<?=$root?>css/main.css" rel="stylesheet">
    <!-- Link required icons -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?=$root?>icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=$root?>icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=$root?>icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=$root?>icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=$root?>icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=$root?>icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$root?>icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$root?>icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$root?>icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=$root?>icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$root?>icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=$root?>icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$root?>icons/favicon-16x16.png">
    <link rel="manifest" href="<?=$root?>icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ededed">
    <meta name="msapplication-TileImage" content="<?=$root?>icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ededed">
    <!-- Format styles -->
    <link rel="stylesheet" href="<?=$root?>markdown/css/github-markdown.css">
    <link rel="stylesheet" href="<?=$root?>markdown/css/highlight.min.css">
    <style>

        body {
            font-weight: 300 !important;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        .markdown-body {
            box-sizing: border-box;
            min-width: 200px;
            max-width: 980px;
            margin: 0 auto;
            padding: 45px;
        }

        @media (max-width: 767px) {
            .markdown-body {
                padding: 15px;
            }

            .brand-logo-minify {
                font-size: 1.3em !important;
                font-weight: 100 !important;
            }

            .image-state {
                min-height: 150px;
                max-height: 250px;
                min-width: auto;
                margin-right: auto;
                margin-left: auto;
            }

        }

        @media (min-width: 767px) {
            .sidenav-size {
                min-width: 450px !important;
            }

            .brand-logo-minify {
                font-weight: 100 !important;
            }

            .image-state {
                min-height: auto;
                max-height: 340px;
                min-width: auto;
                margin-right: auto;
                margin-left: auto;
            }
        }

        .link-restyle {
            font-weight: 200 !important;
            font-size: 0.85em !important;
            margin-top: 0px !important;
            padding-top: 0px !important;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
            height: 35px !important;
        }

        .list-restyle {
            height: 35px !important;
        }

        .divider-restyle {
            margin-top: 0px !important;
            padding-top: 0px !important;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 200 !important;
        }

        .tags-style {
            background-color: #9e9e9e !important;
            color: #ffffff !important;
            font-size: 0.85em;
            margin-right: 0.8em;
            margin-left: 0.8em;
            padding: 0.2em 0.4em 0.2em 0.4em;
            border-radius: 0.2em;
            flex: auto;
            display: inline-block;
            white-space: normal;
        }

        .icon-items {
            color: #9e9e9e !important;
            font-size: 0.85em !important;
            margin-bottom: 0.3em !important;
        }

        .markdown-emoji {
            width: 20px;
            height: 20px;
        }

    </style>
</head>
<body>
<nav class="z-depth-0 grey lighten-1">
    <div class="nav-wrapper z-depth-0">
        <a href="#" data-target="slide-out" class="brand-logo sidenav-trigger left" style="display: inline">
            <i class="material-icons">menu</i>
        </a>
        <a href="<?=$rootUrl?>" class="brand-logo brand-logo-minify center">MicroFrame Docs</a>
    </div>
</nav>

<ul id="slide-out" class="sidenav sidenav-size">
    <li style="margin-bottom: 85px;">

            <div class="user-view">
                <div class="background" style="height: 75px; font-weight: lighter;">
                    <a href="<?=$rootUrl?>">
                        <span class="material-icons teal-text" style="font-size: 4em; vertical-align: middle; text-decoration: none;">book</span>
                    </a>
                    <a href="<?=$rootUrl?>"> MicroFrame Docs</a>
                </div>
            </div>

    </li>

    <!-- Auto rendered menu -->
    <?=$menu?>
</ul>


<!-- Insert converted markdown -->
<div class="markdown-body">
    <?php

    if (empty($paths)) {
        echo $html;
    } elseif (empty($html)) {
        echo "<a class='waves-effect waves-light btn grey lighten-1 center-align z-depth-0'
                style='color: white; text-decoration: none; margin-right: auto; margin-left: auto;'
                href='$base'>
                <i class='material-icons left'>chevron_left</i>Go Back</a>";
        echo '<br />';
        echo "<object type='image/svg+xml' style='min-height: 350px; min-width: auto;' data='{$root}images/vector/404.svg'></object>";
    } else {
        echo $html;
    } ?>

</div>

<footer class="page-footer" style="background-color: #ededed;">
    <div class="footer-copyright" style="background-color: #9e9e9e;">
        <div class="container">
            © 2020 MicroFrame
            <a class="white-text text-lighten-4 right" href="#!">Tolaram ERP</a>
        </div>
    </div>
</footer>

<script src="<?=$root?>js/materialize.min.js"></script>
<!-- https://highlightjs.org/ -->
<script src="<?=$root?>markdown/js/highlight.min.js"></script>
<script>
    /**
     * Initialize Highlight.js
     */
    hljs.initHighlightingOnLoad();

    /**
     * Setup auto initialization for Materialize css.
     */
    M.AutoInit();
</script>
</body>
</html>