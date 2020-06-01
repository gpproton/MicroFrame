<?php

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

        <form action="" method="POST" class="tlr_form tlr_vertical_center tlr_horizontal_center">
            <div class="tlr_base_form">
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input tlr_input" type="password" id="auth" name="tlr_passkey" required>
                    <label class="mdl-textfield__label" for="auth">Pass Key..</label>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored tlr_button" name="tlr_submit">
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