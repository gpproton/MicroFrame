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

final class ListView extends BaseView {

    protected static function Content()
    {

        $invoiceModel = new Model('Models_InvoiceList');
        $invoiceModel->queryParams = array(
            ':TINVH_NO' => Query::PostData('tlr_search_invoice'),
            ':TINVH_TXN_CODE' => 'INOTHS'
        );
        $invoiceData = $invoiceModel->Query();
        $rowCount = 0;
?>

    <div>
         <div style="margin-top: 25px;">
         <a class="" style="color: #942621; text-decoration: none;" href="<?php echo Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[3]) ?>">
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
                    <th class="mdl-data-table__cell--non-numeric tlr_table_th">TRUCK NO</th>
                    <th class="mdl-data-table__cell--non-numeric tlr_table_th">DELIVERY TIME</th>
                    <th class="mdl-data-table__cell--non-numeric tlr_table_th">INVOICE NO</th>
                    <th class="mdl-data-table__cell--non-numeric tlr_table_th">DELIVERY NO</th>
                    <th> </th>
                    </tr>
                </thead>
                
                <tbody>
                <?php while ($row =  $invoiceData->fetch(PDO::FETCH_ASSOC)) { $rowCount++; ?>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row['FT_NEW_VEHICLE_NUMBER'] ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo Utils::nullCheck('date', $row['ZUD_CR_DT']) ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row['TINVH_NO'] ?></td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <button class="mdl-button mdl-js-button mdl-button--primary" style="padding: 0; margin: 0; font-size: 11px;">
                            <?php echo $row['FT_DELIVER_NO'] ?>
                            </button>
                        </td>
                        <td>
                            <?php echo Utils::nullCheck('download', $row['ZUD_DOC_ADDR']) ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <?php if($rowCount < 1) { ?>
                <div class="tlr_status_icon" style="padding-top: 75px;">
                    <span class="material-icons tlr_status_icon_lock">warning</span>
                </div>
                <div id="list-toast-text" class="mdl-js-snackbar mdl-snackbar" style="background-color: orange;">
                    <div class="mdl-snackbar__text">
                    </div>
                    <button class="mdl-snackbar__action" style="color:  #FFFFFF;" type="button">X</button>
                </div>

                <script type="text/JavaScript">
                    setTimeout(function () {
                    window.location.href = "<?php echo Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[3]) ?>";
                    }, 8000);
                </script>
            <?php } ?>

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