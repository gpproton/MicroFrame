<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

function getQueryString()
{
    return "SELECT
	oft.FT_NEW_VEHICLE_NUMBER,
	zud.ZUD_CR_DT,
	otihf.TINVH_TXN_CODE,
	otihf.TINVH_NO,
	otihf.TINVH_DT,
	otirf.TINVR_REF_TXN_CODE,
	otirf.TINVR_REF_NO,
	othf.TOH_FLEX_06 FT_TXN_NO,
	oft.FT_DELIVER_NO,
	zud.ZUD_DOC_ADDR
FROM
	OT_TRIP_INVOICE_HEAD_FIN otihf,
	OT_TRIP_INVOICE_REF_FIN otirf,
	OT_TO_HEAD_FIN othf,
	OT_FLEET_TIME oft
LEFT JOIN ZWB_UPLOAD_DETAIL zud ON oft.FT_DELIVER_NO = zud.ZUD_DELIVER_NO
WHERE
	otirf.TINVR_TINVH_SYS_ID = otihf.TINVH_SYS_ID
	AND otihf.TINVH_NO = :TINVH_NO
	AND otihf.TINVH_COMP_CODE = 'MCPL006'
	AND othf.TOH_COMP_CODE = 'MCPL006'
	AND otihf.TINVH_TXN_CODE = :TINVH_TXN_CODE
	AND otirf.TINVR_REF_TXN_CODE = othf.TOH_TXN_CODE
	AND otirf.TINVR_REF_NO = othf.TOH_NO
    AND TO_NUMBER(NVL(othf.TOH_FLEX_06, '0')) = oft.FT_TXN_NO
    AND oft.FT_DELIVER_NO IS NOT NULL";
}

function getQueryReturn()
{
    return true;
}
