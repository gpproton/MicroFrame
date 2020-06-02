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

final class AuthView extends BaseView {
    
    protected static function Content()
    {
?>

    <div>
        <div onload="showToast()" class="tlr_horizontal_center">
            <div class="tlr_status_icon">
                <span class="material-icons tlr_status_icon_lock">lock</span>
            </div>
            <span class="tlr_header_text" style="font-size: 22px;">Requires a PassKey</span>
        </div>

        <form action="<?php echo Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[2]); ?>" method="POST"  autocomplete="off" target="_self" class="tlr_form tlr_vertical_center tlr_horizontal_center">
            <div class="tlr_base_form">
                <?php if(Config::$AUTH_TYPE !== 'passkey') { ?>
                <!-- Username field for other Auth types -->
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input tlr_input" type="text" id="userid" name="tlr_auth_user_id" style="border-color: #942621;">
                    <label class="mdl-textfield__label" for="tlr_search">User ID</label>
                </div>
                <br />
                <?php } ?>
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input tlr_input" type="password" id="auth" name="tlr_auth_sec_key" required>
                    <label class="mdl-textfield__label" for="auth">Pass Key..</label>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored tlr_button" name="tlr_submit_login">
                        <i class="material-icons">navigate_next</i>
                    </button>
                </div>
            </div>
        </form>

        <div id="toast-text" class="mdl-js-snackbar mdl-snackbar" style="background-color: red;">
            <div class="mdl-snackbar__text">
            </div>
            <button class="mdl-snackbar__action" style="color:  #FFFFFF;" type="button">
            X
            </button>
        </div>
    </div>


<?php
    return '';
    }

}