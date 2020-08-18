<?php
/**
 * SwaggerUI View
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
$root .= 'swagger/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel=“canonical” href=“<?=$url?>” />
    <title>MicroFrame API</title>
    <link rel="stylesheet" type="text/css" href="<?=$root?>swagger-ui.css" >
    <link rel="icon" type="image/png" href="<?=$root?>favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?=$root?>favicon-16x16.png" sizes="16x16" />
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }
        body
        {
            margin:0;
            background: #fafafa;
            font-weight: 300;
        }

        .topbar {
            display: none !important;
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="<?=$root?>swagger-ui-bundle.js"> </script>
<script src="<?=$root?>swagger-ui-standalone-preset.js"> </script>
<script>
    window.onload = function() {
        // Begin Swagger UI call region
        const ui = SwaggerUIBundle({
            url: "<?=$apiPath?>",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout"
        })
        // End Swagger UI call region
        window.ui = ui
    }
</script>
</body>
</html>
