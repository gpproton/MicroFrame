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

final class FaqsView extends BaseView {

    protected static function Content()
    {
?>

    <div>
        <div class="tlr_horizontal_center">
            <span class="tlr_header_text">Frequently asked questions?</span>

            <div class="tlr_status_icon" style="margin-top: 35px;">
                <span class="material-icons tlr_status_icon_done">360</span>
            </div>
        </div>
    </div>

<?php
    return '';
    }

}