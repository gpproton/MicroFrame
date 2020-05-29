<?php

Injector::loadClass('Views_BaseView');

final class SearchView extends BaseView {

    protected static function Content()
    {
?>

    <div>
        <div class="" style="margin-top: 3%;">
            <div>
                <span class="tlr_horizontal_center" style="font-weight: 200; font-size: 5em; color: #942621;">Invoice Search</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield tlr_horizontal_center" style="margin-top: 120px;">
                <input class="mdl-textfield__input tlr_input" type="text" id="tlr_search" pattern="-?[0-9]*(\.[0-9]+)?" style="border-color: #942621;">
                <label class="mdl-textfield__label" for="tlr_search">Invoice No</label>
                <span class="mdl-textfield__error">Input is not a number!</span>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored tlr_button" name="tlr_submit">
                    <i class="material-icons">search</i>
                </button>
            </div>
         </div>
    </div>

<?php
    return '';
    }

}