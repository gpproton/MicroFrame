<?php

Injector::loadClass('Views_BaseView');

final class ListView extends BaseView {

    protected static function Content()
    {

        $invoiceModel = new Model('Models_InvoiceList');
        $invoiceModel->queryParams = array(':rownums' => 5);
        $invoiceData = $invoiceModel->Query();
        // while ($row =  $invoiceData->fetch(PDO::FETCH_ASSOC))
        // {
        //     echo var_dump($row) . '<br>';
        // }

?>

    <div>
         <div style="margin-top: 25px;">
         <a class="" style="color: #942621; text-decoration: none;" href="#">
            <button style="margin-left: 25px;" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
                <span class="material-icons" style="font-size: 36px; color: #942621;">keyboard_arrow_left</span>
            </button>
            Back
         </a>
         </div>
        <div  style="margin-top: 25px;">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--0dp tlr_horizontal_center">
                <thead style="font-size: 11px;">
                    <tr>
                    <th class="mdl-data-table__cell--non-numeric" style="color: #942621; text-decoration: none;">TRUCK NO</th>
                    <th class="mdl-data-table__cell--non-numeric">DELIVERY TIME</th>
                    <th class="mdl-data-table__cell--non-numeric">INVOICE NO</th>
                    <th class="mdl-data-table__cell--non-numeric">DELIVERY NO</th>
                    <th> </th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">EPE 123 XX</td>
                        <td class="mdl-data-table__cell--non-numeric">06-MAY-2020 04:21</td>
                        <td class="mdl-data-table__cell--non-numeric">231221</td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <button id="show-dialog" class="mdl-button mdl-js-button mdl-button--primary" style="padding: 0; margin: 0; font-size: 11px;">
                                LMN099HB989UHJJ8
                            </button>
                        </td>
                        <td>
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
                            <span class="material-icons" style="color: red;">not_interested</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">KJA 543 JX</td>
                        <td class="mdl-data-table__cell--non-numeric">04-MAY-2020 13:06</td>
                        <td class="mdl-data-table__cell--non-numeric">313213</td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <button class="mdl-button mdl-js-button mdl-button--primary" style="padding: 0; margin: 0; font-size: 11px;">
                                LMN98787987JNBJH
                            </button>
                        </td>
                        <td>
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
                            <span class="material-icons" style="color: green;">vertical_align_bottom</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">EPE 752 XX</td>
                        <td class="mdl-data-table__cell--non-numeric">21-MAY-2020 00:43</td>
                        <td class="mdl-data-table__cell--non-numeric">324123</td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <button class="mdl-button mdl-js-button mdl-button--primary" style="padding: 0; margin: 0; font-size: 11px;">
                                LMN98787HBUG88989
                            </button>
                        </td>
                        <td>
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
                            <span class="material-icons" style="color: red;">not_interested</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Test diag -->
            <dialog class="mdl-dialog" style="min-width: 500px;">
                <h4 class="mdl-dialog__title">Delivery Information</h4>
                <div class="mdl-dialog__content">
                <p>
                    Trip informations will be listed here
                </p>
                </div>
                <div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Close</button>
                </div>
            </dialog>
        </div>
    </div>

<?php
    return '';
    }

}