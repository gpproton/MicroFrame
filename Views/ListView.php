<?php

Injector::loadClass('Views_BaseView');

final class ListView extends BaseView {

    protected static function Content()
    {
?>

    <div>
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--0dp">
            <thead>
                <tr>
                <th class="mdl-data-table__cell--non-numeric">TRUCK NO</th>
                <th>DELIVERY TIME</th>
                <th>INVOICE</th>
                <th>DELIVERY NO</th>
                <th> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                </tr>
            </tbody>
        </table>
    </div>

<?php
    return '';
    }

}