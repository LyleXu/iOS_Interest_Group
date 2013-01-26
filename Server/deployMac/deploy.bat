set WWWROOT=D:\wamp\www\gtcclibrary
set LIBPATH=D:\wamp\phplibpath\gtcclibrary
set INIPATH=D:\wamp\bin\php\php5.3.13

rmdir /S /Q %WWWROOT%
rmdir /S /Q %LIBPATH%

mkdir %WWWROOT%
mkdir %LIBPATH%

mkdir %WWWROOT%\json\
mkdir %WWWROOT%\json\Sample\
mkdir %WWWROOT%\json\Schema\
mkdir %WWWROOT%\json2html\
mkdir %WWWROOT%\cache\
mkdir %WWWROOT%\Tapjoy\
mkdir %WWWROOT%\Images\
mkdir %WWWROOT%\amfphp\
mkdir %WWWROOT%\stream\
mkdir %LIBPATH%\Models\

xcopy /Y /S ..\source\amfphp2 %WWWROOT%\amfphp\
xcopy /Y /S ..\source\stream %WWWROOT%\stream\

xcopy /Y /S  ..\source\lib\Json\Sample %WWWROOT%\json\Sample\
xcopy /Y /S ..\source\lib\Json\Schema %WWWROOT%\json\Schema\
xcopy /Y /S ..\source\json2html %WWWROOT%\json2html\
xcopy /Y /S ..\source\Tapjoy %WWWROOT%\Tapjoy\

xcopy /Y /S ..\source\Images %WWWROOT%\Images\

xcopy ..\source\*.php %LIBPATH%\
xcopy /Y /S ..\source\lib %LIBPATH%\
xcopy /Y /S ..\source\Models %LIBPATH%\Models

xcopy /Y /Q ..\source\*.ini %INIPATH%\

xcopy /Y /Q .\usedInWindows\GlobalConfiguration.php D:\wamp\phplibpath\gtcclibrary\Utility\
xcopy /Y /Q .\usedInWindows\DoctrineBaseService.php D:\wamp\www\gtcclibrary\amfphp\lib\
xcopy /Y /Q .\usedInWindows\AmfphpServiceBrowser.php D:\wamp\www\gtcclibrary\amfphp\Plugins\AmfphpServiceBrowser\