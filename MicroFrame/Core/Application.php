<?php

/**
 * Core Application class
 *
 * PHP Version 7
 *
 * @category  Core
 * @package   MicroFrame\Core
 * @author    Tolaram Group Nigeria <teamerp@tolaram.com>
 * @copyright 2020 Tolaram Group Nigeria
 * @license   MIT License
 * @link      https://github.com/gpproton/microframe
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so
 */

namespace MicroFrame\Core;

use MicroFrame\Handlers\Route;
use MicroFrame\Library\Config;
use MicroFrame\Library\Utils;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as whoopsRun;

/**
 * Application class
 *
 * @category Core
 * @package  MicroFrame\Core
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://godwin.dev
 */
class Application extends Core
{
    /**
     * Contains retrieved config for the app bootstrap.
     *
     * @var array|mixed|null
     */
    private $config;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->config = Config::fetch();
    }


    /**
     * Check debug settings and set error checking.
     *
     * @return bool
     */
    public function environment()
    {
        return $this->config['system']['debug'];
    }

    /**
     * Boot up application
     *
     * @return void
     */
    public function start()
    {

        /**
         * Implement pretty error display.
         */
        if ($this->config['system']['debug']) {
            $whoops = new whoopsRun();
            $page = new PrettyPageHandler();
            $protectArray = array('_ENV', '_SERVER');

            foreach ($protectArray as $pat) {
                foreach ($GLOBALS[$pat] as $offKey => $offValue) {
                    $page->blacklist($pat, $offKey);
                }
            }
            $whoops->pushHandler($page)->register();
        }

        if ($this->config['console']) {
            /**
             * Initialize console instance.
             */
            $consoleInstance = Console::init();

            /**
             * Retrieves console parameters.
             */
            $consoleInstance->execute();

            //TODO: Handle console serve mode from app's symfony process.
            if (
                isset($consoleInstance->all['S'])
                || isset($consoleInstance->all['Serve'])
            ) {
                /**
                 * Execute command or kill.
                 */
                $process = new Process(
                    [
                    (new PhpExecutableFinder())->find(false),
                    '-S',
                    '127.0.0.1:4567',
                    '--define',
                    'memory_limit=1024M',
                    '--define',
                    'max_input_time=-1',
                    '--define',
                    'max_execution_time=-1',
                    ]
                );

                try {
//                    $process->start();
                    $process->run(function ($type, $buffer) {
                        if (Process::ERR === $type) {
                            echo 'ERR > ' . $buffer;
                        } else {
                            echo 'OUT > ' . $buffer;
                        }
                    });
                } catch (ProcessFailedException $exception) {
                    die($exception);
                }

                echo("Running built-in web server on port --> 4567...\n");
//                foreach ($process as $type => $data) {
//                    if ($process::OUT === $type) {
//                        echo "Micro: " . $data;
//                    } else {
//                        echo "Micro: " . $data;
//                    }
//                }

                die('Completed web request');
            }
        } else {
            /**
             * Load defined routes to request
             */
            Utils::get()->injectRoutes();

            /**
             * Load only request route
             */
            Route::set()->boot();
        }
    }
}
