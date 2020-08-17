<?php
/**
 * Error Handler  class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
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

namespace MicroFrame\Handlers;

defined('BASE_PATH') or exit('No direct script access allowed');

use Error as sysError;
use MicroFrame\Core\Application;
use Throwable;

/**
 * ErrorHandler class
 *
 * @category Handlers
 * @package  MicroFrame\Handlers
 * @author   Godwin peter .O <me@godwin.dev>
 * @license  MIT License
 * @link     https://github.com/gpproton/microframe
 */
final class ErrorHandler extends sysError implements Throwable
{
    private $_app;

    /**
     * ErrorHandler constructor.
     *
     * @param string         $message  here
     * @param int            $code     here
     * @param Throwable|null $previous here
     *
     * @return void
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // TODO: Finish Exception / Exception setup

    /**
     * Kick start base app class and enable custom error handling.
     *
     * @param Application $app here
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->_app = $app;

        error_reporting(-1);

        set_error_handler([$this, 'handleError']);

        set_exception_handler([$this, 'handleException']);

        register_shutdown_function([$this, 'handleShutdown']);

        if (! $this->_app->environment()) {
            ini_set('display_errors', 'Off');
        }

        if (!empty($this->_app)) {
            $this->_app->start();
        };
    }

    /**
     * Fatal error converter to an exception.
     *
     * @param int    $level   here
     * @param string $message here
     * @param string $file    here
     * @param int    $line    here
     * @param array  $context here
     *
     * @throws Exception
     *
     * @return void
     */
    public function handleError(
        $level,
        $message,
        $file = '',
        $line = 0,
        $context = []
    ) {
        if (error_reporting() & $level) {
            throw new Exception($message);
        }
    }

    /**
     * Handling the actual final exceptions.
     *
     * @param Throwable $e here
     *
     * @return void
     */
    public function handleException(Throwable $e)
    {
        try {
            throw new Exception($e);
        } catch (Exception $e) {
            $e->output();
        }
    }

    /**
     * Handle errors during the shutdown process.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (! is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalErrorFromPhpError($error, 0));
        }
    }

    /**
     * Check PHP fatal errors and return an error instance.
     *
     * @param array $error       here
     * @param null  $traceOffset here
     *
     * @return ErrorHandler
     */
    protected function fatalErrorFromPhpError(array $error, $traceOffset = null)
    {
        return new ErrorHandler($error['message'], 0, $traceOffset);
    }

    /**
     * Check PHP error if it's fatal.
     *
     * @param string $type here
     *
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, [E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE]);
    }
}
