<?php
/**
 * Error Handler  class
 *
 * PHP Version 7
 *
 * @category  Handlers
 * @package   MicroFrame\Handlers
 * @author    Godwin peter .O <me@godwin.dev>
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

defined('BASE_PATH') OR exit('No direct script access allowed');

use ErrorException;
use MicroFrame\Core\Application;
use Throwable;

/**
 * Class ErrorHandler
 * @package MicroFrame\Handlers
 */
final class ErrorHandler extends \Error implements Throwable
{

    private $app;

    /**
     * ErrorHandler constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // TODO: Finish Exception / Exception setup

    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $this->app = $app;

        error_reporting(-1);

        set_error_handler([$this, 'handleError']);

        set_exception_handler([$this, 'handleException']);

        register_shutdown_function([$this, 'handleShutdown']);

        if (! $this->app->environment(true)) {
            ini_set('display_errors', 'Off');
        }

        if (!empty($this->app)) {
            $this->app->start();
        };

    }

    /**
     * @param $level
     * @param $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @throws Exception
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new Exception($message);
        }
    }

    /**
     * @param Throwable $e
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
     *
     */
    public function handleShutdown()
    {
        if (! is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalErrorFromPhpError($error, 0));
        }
    }

    /**
     * @param array $error
     * @param null $traceOffset
     * @return ErrorHandler
     */
    protected function fatalErrorFromPhpError(array $error, $traceOffset = null)
    {
        return new ErrorHandler($error['message'], 0, $traceOffset);
    }


}