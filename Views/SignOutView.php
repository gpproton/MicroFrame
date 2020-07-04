<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

Injector::loadClass('Views_BaseView');

final class SignOutView extends BaseView{

    protected static function Content()
    {
?>

    <div>
        <div class="tlr_horizontal_center">
            <span class="tlr_header_text">Signing Out..</span>

            <div class="tlr_status_icon" style="margin-top: 35px;">
                <div class="mdl-spinner mdl-js-spinner is-active" style="width: 95px; height: 95px;"></div>
            </div>
        </div>

        <script type="text/JavaScript">
            setTimeout(function () {
            window.location.href = "<?php echo Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[2]) ?>";
            }, 2000);
        </script>
    </div>

<?php
    return '';
    }

}
