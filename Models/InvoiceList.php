<?php

function getQueryString()
{
    return "SELECT * FROM
    (SELECT oft.FT_TXN_NO, oft.FT_NEW_VEHICLE_NUMBER
    FROM OT_FLEET_TIME oft)
    WHERE ROWNUM <= :rownums";
}

function getQueryReturn()
{
    return true;
}
