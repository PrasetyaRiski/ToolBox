@echo off
echo ========================================
echo ProductiviTools Setup Script
echo ========================================
echo.

:: Check if composer exists
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo Error: Composer not found. Please install Composer first.
    pause
    exit /b 1
)

:: Check if npm exists
where npm >nul 2>nul
if %errorlevel% neq 0 (
    echo Error: NPM not found. Please install Node.js and NPM first.
    pause
    exit /b 1
)

:: Check if php exists
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo Error: PHP not found. Please install PHP 8.2 or higher.
    pause
    exit /b 1
)

echo All requirements met!
echo.

:: Copy .env file if it doesn't exist
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
)

:: Create required directories
echo Creating required directories...
if not exist bootstrap\cache mkdir bootstrap\cache
if not exist storage\framework mkdir storage\framework
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\framework\cache\data mkdir storage\framework\cache\data
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\app mkdir storage\app
if not exist storage\app\public mkdir storage\app\public

:: Install PHP dependencies
echo Installing PHP dependencies...
call composer install --no-scripts
if %errorlevel% neq 0 (
    echo Error: Failed to install PHP dependencies
    pause
    exit /b 1
)

:: Generate application key
echo.
echo Generating application key...
call php artisan key:generate --ansi
if %errorlevel% neq 0 (
    echo Warning: Failed to generate application key
)

:: Run post-install scripts
echo.
echo Running post-install scripts...
call composer dump-autoload
call php artisan package:discover --ansi
if %errorlevel% neq 0 (
    echo Warning: Package discovery had issues, but continuing...
)

:: Install JavaScript dependencies
echo.
echo Installing JavaScript dependencies...
call npm install
if %errorlevel% neq 0 (
    echo Error: Failed to install JavaScript dependencies
    pause
    exit /b 1
)

echo.
echo ========================================
echo Installation Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Create MySQL database: CREATE DATABASE productivitools;
echo 2. Update .env file with your database credentials
echo 3. Run: php artisan migrate
echo 4. Run: php artisan db:seed
echo 5. Run: npm run dev (in a separate terminal)
echo 6. Run: php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
pause
