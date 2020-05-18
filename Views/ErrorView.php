<?php

Injector::loadClass('Views_BaseView');

final class ErrorView extends BaseView{

    protected static function Content()
    {
?>

    <div>
        <div class="tlr_horizontal_center">
            <span class="tlr_header_text">Error encountered</span>

            <div class="tlr_status_icon" style="margin-top: 35px;">
                <span class="material-icons tlr_status_icon_error">error</span>
            </div>
        </div>
    </div>

<?php
    return '';
    }

}
