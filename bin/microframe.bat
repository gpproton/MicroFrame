@echo off

:init_arg
set args=

:get_arg
shift
if "%0"=="" goto :finish_arg
set args=%args% %0 goto :get_arg

:finish_arg

set php=php.exe
Rem set ini=C:\path\to\php.ini
%php% -c %ini%
..\Public\Index.php %args%