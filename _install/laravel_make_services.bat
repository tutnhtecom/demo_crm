@echo off
setlocal enabledelayedexpansion

:: Thiết lập đường dẫn mục tiêu
set "targetDir=app\Services"

:: Tạo thư mục nếu chưa tồn tại
if not exist "%targetDir%" (
    mkdir "%targetDir%"
    echo Da tao thu muc: %targetDir%
)

echo Dang khoi tao cac file Repository...

:: Danh sach các file cần tạo
set files=CustomerService SubscriptionService SipProvisioningService

for %%f in (%files%) do (
    set "fileName=%targetDir%\%%f.php"
    
    echo ^<?php > "!fileName!"
    echo. >> "!fileName!"
    echo namespace App\Repository; >> "!fileName!"
    echo. >> "!fileName!"
    echo class %%f >> "!fileName!"
    echo { >> "!fileName!"
    echo     // Code logic cho %%f o day >> "!fileName!"
    echo } >> "!fileName!"
    
    echo Da tao: !fileName!
)

echo ---------------------------------------
echo Hoan tat! Cac file da duoc tao tai %targetDir%
pause