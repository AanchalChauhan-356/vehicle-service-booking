@echo off
title AutoCare - Vehicle Service Booking System
cd /d "%~dp0"
if exist "php\php.exe" (
    echo Starting with bundled portable PHP...
    start "" http://localhost:8000
    php\php.exe -c php.ini -S localhost:8000
) else (
    where php >nul 2>nul
    if %errorlevel%==0 (
        echo Starting with PHP found on this computer...
        start "" http://localhost:8000
        php -S localhost:8000
    ) else (
        echo.
        echo PHP not found. One-time setup ^(no installer needed^):
        echo  1. Download "VS16/VS17 x64 Thread Safe ZIP" from https://windows.php.net/download
        echo  2. Extract it into a folder named "php" INSIDE this project folder
        echo     so that this file exists:  php\php.exe
        echo  3. Double-click start.bat again.
        pause
    )
)
