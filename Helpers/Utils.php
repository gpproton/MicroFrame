<?php

/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

final class Utils {

    public function __construct()
    { }

    public static function urlIllegalCheckr($urlPath)
    {
        return preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $urlPath) == 0;
    }

    public static function getLocalStatus()
    {
        $ipaddress = 'UNKNOWN';
        $keys=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');
        foreach($keys as $k)
        {
            if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP))
            {
                $ipaddress = $_SERVER[$k];
                break;
            }
        }
        return (
            ($ipaddress == '::1'
            || $ipaddress == '127.0.0.1'
            || $ipaddress == '0.0.0.0')
            || !Config::$PRODUCTION_MODE
        );
    }

    public static function errorHandler($option)
    {
        if(Utils::getLocalStatus())
        {
            echo json_encode($option);
            return false;
        }
        
        Routes::RedirectQuery(Routes::PageActualUrl(Config::ALLOWED_QUERY_STRINGS[4]));
    }

    public static function mimeType($filename)
    {
        if(!function_exists('mime_content_type')) {

            function mime_content_type($filename) {
        
                $mime_types = array(
        
                    'txt' => 'text/plain',
                    'htm' => 'text/html',
                    'html' => 'text/html',
                    'php' => 'text/html',
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'json' => 'application/json',
                    'xml' => 'application/xml',
                    'swf' => 'application/x-shockwave-flash',
                    'flv' => 'video/x-flv',
        
                    // images
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'ico' => 'image/vnd.microsoft.icon',
                    'tiff' => 'image/tiff',
                    'tif' => 'image/tiff',
                    'svg' => 'image/svg+xml',
                    'svgz' => 'image/svg+xml',
        
                    // archives
                    'zip' => 'application/zip',
                    'rar' => 'application/x-rar-compressed',
                    'exe' => 'application/x-msdownload',
                    'msi' => 'application/x-msdownload',
                    'cab' => 'application/vnd.ms-cab-compressed',
        
                    // audio/video
                    'mp3' => 'audio/mpeg',
                    'qt' => 'video/quicktime',
                    'mov' => 'video/quicktime',
        
                    // adobe
                    'pdf' => 'application/pdf',
                    'psd' => 'image/vnd.adobe.photoshop',
                    'ai' => 'application/postscript',
                    'eps' => 'application/postscript',
                    'ps' => 'application/postscript',
        
                    // ms office
                    'doc' => 'application/msword',
                    'rtf' => 'application/rtf',
                    'xls' => 'application/vnd.ms-excel',
                    'ppt' => 'application/vnd.ms-powerpoint',
        
                    // open office
                    'odt' => 'application/vnd.oasis.opendocument.text',
                    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                );
        
                $ext = strtolower(array_pop(explode('.',$filename)));
                if (array_key_exists($ext, $mime_types)) {
                    return $mime_types[$ext];
                }
                elseif (function_exists('finfo_open')) {
                    $finfo = finfo_open(FILEINFO_MIME);
                    $mimetype = finfo_file($finfo, $filename);
                    finfo_close($finfo);
                    return $mimetype;
                }
                else {
                    return 'application/octet-stream';
                }
            }
        } else {
            // Use php internal funtion..
            return mime_content_type($filename);
        }
    }

    public static function viewLoader($text)
    {
        if(empty($text))
        {
            $text = 'Start';
        }
        $classString = 'Views_' . $text . 'View';
        Injector::loadClass($classString);

        return $classString;
    }

    public static function nullCheck($type, $data)
    {
        if($type == 'date')
        {
            if(!empty($data))
            {
                return $data;
            }
            return 'Pending';
        }
        else if($type == 'download')
        {
            if(strpos($data, 'NIL') === false)
            {
                $fileHTTPUrl = Config::$UPLOAD_BASE_URL . $data;
                return "<a href='$fileHTTPUrl' target='_blank' class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored'>
                        <span id='dl_icon' class='material-icons' style='color: green;'>vertical_align_bottom</span>
                        </a>
                        <div class='mdl-tooltip' for='dl_icon'>
                        Click to download <br> attached document.
                        </div>";
            }
            return "<a class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored'>
                    <span id='dl_icon' class='material-icons' style='color: red;'>not_interested</span>
                    </a>
                    <div class='mdl-tooltip' for='dl_icon'>
                    Attached document is <br> unavailable.
                    </div>";
        }

        return 'Not Data';
    }

}