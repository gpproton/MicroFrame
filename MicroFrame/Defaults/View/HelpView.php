<html>
<head>
    <title><?=$options['title']?></title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
    <link rel="stylesheet" href="<?=$root?>markdown/css/github-markdown.css">
    <link rel="stylesheet" href="<?=$root?>markdown/css/highlight.min.css">
    <style>

        body {
            font-weight: 300 !important;
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
        }

        @media (min-width: 767px) {
            .sidenav-size {
                min-width: 450px !important;
            }

            .brand-logo-minify {
                font-weight: 100 !important;
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
        echo "<object type=\"image/svg+xml\" data=\"{$root}markdown/images/404.svg\"></object>";
    } else {
        echo $html;
    } ?>

</div>

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