@echo off
SET /P project_name="Nhap ten thu muc project (vd: my-app): "

echo =========================================
echo    DANG KHOI TAO PROJECT LARAVEL: %project_name%
echo =========================================

:: 1. Tao project moi qua Composer
call composer create-project laravel/laravel %project_name%

:: Di chuyen vao thu muc project
cd %project_name%

:: 2. Kiem tra va copy file .env neu chua co
if not exist ".env" (
    echo [INFO] Dang copy file .env...
    copy .env.example .env
)

:: 3. Tao Application Key
echo [INFO] Dang tao Application Key...
php artisan key:generate

:: 4. Hoi nguoi dung co muon chay Migration khong
set /p migrate="Ban co muon chay Migration ngay bay gio khong? (y/n): "
if /I "%migrate%"=="y" (
    echo [INFO] Dang chay Migration...
    php artisan migrate
)

echo =========================================
echo    DA HOAN THANH! 
echo    - Thu muc: %cd%
echo    - Lenh chay: php artisan serve
echo =========================================

:: Tu dong mo thu muc project bang File Explorer
start .

:: Hoi xem co muon chay server ngay khong
set /p serve="Ban co muon khoi chay server ngay khong? (y/n): "
if /I "%serve%"=="y" (
    php artisan serve
)

pause