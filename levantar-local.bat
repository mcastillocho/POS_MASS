@echo off
setlocal

set APP_HOST=127.0.0.1
set APP_PORT=8000
set DB_HOST=127.0.0.1
set DB_PORT=3306

echo Verificando base de datos en %DB_HOST%:%DB_PORT%...
powershell -NoProfile -ExecutionPolicy Bypass -Command "$ok=(Test-NetConnection '%DB_HOST%' -Port %DB_PORT% -InformationLevel Quiet); if (-not $ok) { exit 1 }"
if errorlevel 1 (
    echo.
    echo No hay conexion a la DB en %DB_HOST%:%DB_PORT%.
    echo Abre Laragon y confirma que MySQL/MariaDB este escuchando en el puerto %DB_PORT%.
    echo.
    pause
    exit /b 1
)

echo Verificando puerto del sistema POS en %APP_HOST%:%APP_PORT%...
powershell -NoProfile -ExecutionPolicy Bypass -Command "$busy=(Test-NetConnection '%APP_HOST%' -Port %APP_PORT% -InformationLevel Quiet); if ($busy) { exit 1 }"
if errorlevel 1 (
    echo.
    echo El sistema ya parece estar levantado en http://%APP_HOST%:%APP_PORT%
    start http://%APP_HOST%:%APP_PORT%
    echo.
    pause
    exit /b 0
)

php artisan config:clear
echo.
echo Levantando MASS POS en http://%APP_HOST%:%APP_PORT%
echo Presiona Ctrl+C para detener el servidor.
echo.
start http://%APP_HOST%:%APP_PORT%
php artisan serve --host=%APP_HOST% --port=%APP_PORT%
