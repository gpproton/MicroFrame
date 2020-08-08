<html>
<head>
    <title><?=$errorTitle?></title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
    <style>

        body {
            font-weight: 300 !important;
        }
        body {
            box-sizing: border-box;
            min-width: 200px;
            max-width: 980px;
            margin: 0 auto;
            padding: 45px;
        }

        @media (max-width: 767px) {
            body {
                padding: 15px;
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
    <object class="center-align" style="min-height: 350px; max-height: 500px; min-width: auto;" type='image/svg+xml' data='<?=$root?><?=$errorImage?>'></object>
</div>

<div class="center-align">
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