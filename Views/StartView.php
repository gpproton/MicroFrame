<?php

Injector::loadClass('Views_BaseView');

final class StartView extends BaseView {

    protected static function Content()
    {
?>

    <div>
        <div class="tlr_horizontal_center">
            <span class="tlr_header_text">Start</span>

            <div class="tlr_status_icon" style="margin-top: 35px;">
                <span class="material-icons tlr_status_icon_done">fiber_manual_record</span>
            </div>
        </div>
    </div>

<?php
    return '';
    }

}