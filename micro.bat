@echo off

rem -------------------------------------------------------------
rem  MicroFrame console bootstrap file.
rem
rem  @author Godwin peter .O <me@godwin.dev>
rem  @link https://github.com/tolaramgroup/microframe/
rem  @copyright 2020 Tolaram Group
rem  @license   MIT License
rem -------------------------------------------------------------

@setlocal

set MICRO_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%MICRO_PATH%micro" %*

@endlocal
