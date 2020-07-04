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

final class SearchView extends BaseView {

    protected static function Content()
    {
?>

    <div>
        <div class="" style="margin-top: 3%;">
            <div>
                <span class="tlr_horizontal_center" style="font-weight: 200; font-size: 5em; color: #942621;">Invoice Search</span>
            </div>
            <form action="<?php echo Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[1]); ?>" autocomplete="off" target="_self" method="POST" class="tlr_form">
                <div class="mdl-textfield mdl-js-textfield tlr_horizontal_center" style="margin-top: 120px;">
                    <input class="mdl-textfield__input tlr_input" type="text" id="tlr_search" name="tlr_search_invoice" pattern="-?[0-9]*(\.[0-9]+)?" style="border-color: #942621;" autofocus>
                    <label class="mdl-textfield__label" for="tlr_search">Invoice No</label>
                    <span class="mdl-textfield__error">Input is not a number!</span>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored tlr_button" name="tlr_submit_search">
                        <i class="material-icons">search</i>
                    </button>
                </div>
            </form>
         </div>
    </div>

<?php
    return '';
    }

}