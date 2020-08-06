<html>
<head>
    <title>Page name</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
    <link rel="stylesheet" href="<?=$root?>markdown/css/github-markdown.css">
    <link rel="stylesheet" href="<?=$root?>markdown/css/highlight.min.css">
    <style>
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
        }
    </style>
</head>
<body>
<nav class="z-depth-0 grey lighten-1">
    <div class="nav-wrapper z-depth-0">
        <a href="#" data-target="slide-out" class="brand-logo sidenav-trigger" style="display: inline">
            <i class="material-icons">menu</i>
        </a>
        <a href="<?=$rootUrl?>" class="brand-logo center">MicroFrame Docs</a>
    </div>
</nav>

<ul id="slide-out" class="sidenav">
    <li style="margin-bottom: 85px;">
        <div class="user-view">
            <div class="background" style="height: 75px; font-weight: lighter;">
                <span class="material-icons" style="font-size: 4em; vertical-align: middle;">book</span>
                MicroFrame Docs
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
    hljs.initHighlightingOnLoad();
    M.AutoInit();

</script>
</body>
</html>