<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel=“canonical” href=“<?=$url?>” />
    <title><?=$errorTitle?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Import Google Icon Font-->
    <link href="<?=$root?>css/main.css" rel="stylesheet">
    <!-- Load CSS lib -->
    <link rel="stylesheet" href="<?=$root?>css/materialize.min.css" media="screen,projection">
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

<?php if (isset($showReturn)) {
    if ($showReturn) { ?>
<div class="center-align">
    <a class='waves-effect waves-light btn grey lighten-1 center-align z-depth-0' style='color: white; text-decoration: none; margin-right: auto; margin-left: auto;' href='<?=$base?>'>
        <i class='material-icons left'>chevron_left</i>Return Home</a>
</div>
<?php }
} ?>

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