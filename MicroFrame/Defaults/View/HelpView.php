<?php

/**
 * Default Help View
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

$fullUrl = \MicroFrame\Core\Request::get()->url();
$curPath = \MicroFrame\Core\Request::get()->path(false);
//$basePath = \MicroFrame\Library\Strings::filter($fullUrl)->replace($curPath)->value() . "resources/swagger/";
ob_start();
?>

<html>
<head>
    <title>Page name</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- https://github.com/sindresorhus/github-markdown-css -->
    <!-- https://sindresorhus.com/github-markdown-css/ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/4.0.0/github-markdown.css">
    <!-- https://highlightjs.org/ -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/default.min.css">
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
<body class="markdown-body">
<!-- Insert converted markdown -->

<!-- https://highlightjs.org/ -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
</body>
</html>

<?php

$vals = ob_get_contents();
ob_clean();
return $vals;