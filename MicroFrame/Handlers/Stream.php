<?php

/**
 * Stream Handler class
 * 
 * PHP Version 5
 * 
 * @category  Core
 * @package   MicroFrame
 * @author    Godwin peter .O <me@godwin.dev>
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/bhn_mcpl_invoicepdf
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to 
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Handlers;

final class Stream
{

    //TODO: Rework old codes
    public function __construct()
    { }

    // public static function Transfer()
    // {

    //     if(Utils::urlIllegalCheckr(Path::$filePath)){
    //         $filepath = Path::$filePath;
    //         $filename = basename($filepath);
    //         $filesize = filesize($filepath);

    //         // Process download
    //         if(file_exists($filepath)) {
    //             header('Content-Description: File Transfer');
    //             header('Content-Type: ' . Utils::mimeType($filename));
    //             header('Content-Disposition: attachment; filename="'. $filename .'"');
    //             header('Content-Transfer-Encoding: binary');
    //             header('Expires: 0');
    //             header('Cache-Control: must-revalidate');
    //             header('Pragma: public');
    //             header('Content-Length: ' . $filesize);
                
    //             ob_clean();
    //             flush();
    //             readfile($filepath);
    //             die();
    //         } else {
    //             http_response_code(404);
    //             die();
    //         }
    //     } else {
    //         die("Invalid file name!");
    //     }
    // }

}