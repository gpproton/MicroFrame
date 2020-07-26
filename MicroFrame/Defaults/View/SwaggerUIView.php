<?php
/**
 * Default View swagger class
 *
 * PHP Version 7
 *
 * @category  View
 * @package   MicroFrame\Default\View
 * @author    Godwin peter .O <me@godwin.dev>
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

ob_start();
?>

<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MocroFrame API</title>
<!--    <link rel="stylesheet" type="text/css" href="/web/swagger-ui.css" >-->
<!--    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />-->
<!--    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />-->
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
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist@3.12.1/swagger-ui-standalone-preset.js"></script>
<script src="https://unpkg.com/swagger-ui-dist@3.12.1/swagger-ui-bundle.js"></script>
<script>
    window.onload = function() {
        // Begin Swagger UI call region
        console.log(window.location.pathname);
        const ui = SwaggerUIBundle({
            // url: window.location.protocol + "//" + window.location.hostname + "/path-to-your-swagger.json",
            url: "http://localhost:4567/api/swagger/api/index/?accept=json",
            // url: "https://petstore.swagger.io/v2/swagger.json",
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

<?php

$vals = ob_get_contents();
ob_clean();
return $vals;