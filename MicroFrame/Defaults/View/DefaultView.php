<html>
<head>
    <title><?=$errorTitle?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Import Google Icon Font-->
    <link href="<?=$root?>css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
    <style>
        body {
            font-weight: 300 !important;
            box-sizing: border-box;
            min-width: 380px;
            max-width: 980px;
            margin: 0 auto;
            padding: 45px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
        }

        .vector-style {
            min-height: auto !important;
            max-height: 450px !important;
            min-width: auto !important;
        }
    </style>
</head>
<body>

<?php if (isset($showReturn)) {if ($showReturn) { ?>
<div class="center-align">
    <a class='waves-effect waves-light btn grey lighten-1 center-align z-depth-0' style='color: white; text-decoration: none; margin-right: auto; margin-left: auto;' href='<?=$base?>'>
        <i class='material-icons left'>chevron_left</i>Return Home</a>
</div>
<?php } } ?>

<div class="center-align">
    <object class="center-align vector-style" type='image/svg+xml' data='<?=$root?><?=$errorImage?>'></object>
</div>

<div class="center-align" style="word-wrap: break-word;">
    <h4 class="center-align" style="color: <?=$errorColor?>; font-weight: 100;"><?=$errorText?></h4>
</div>

<script src="<?=$root?>js/materialize.min.js"></script>
<script>

    /**
     * Setup auto initialization for Materialize css.
     */
    M.AutoInit();
</script>
</body>
</html>