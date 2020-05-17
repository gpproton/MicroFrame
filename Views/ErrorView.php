<?php

Injector::loadClass('Views_BaseView');

final class ErrorView extends BaseView{

    protected static function Content()
    {
?>

    <div>
        <div class="dl_horizontal_center">
            <span class="dl_header_text">Error encountered</span>

            <div class="dl_status_icon" style="margin-top: 35px;">
                <span class="material-icons dl_status_icon_error">error</span>
            </div>
        </div>
    </div>

<?php
    return '';
    }

}
