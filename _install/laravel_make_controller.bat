@echo off
echo ========================================
echo  VNPT Voice IP CRM - Tao API Controllers
echo ========================================
echo.

php artisan make:controller Api/AuthController
echo [OK] AuthController

php artisan make:controller Api/PackageController
echo [OK] PackageController

php artisan make:controller Api/CustomerController
echo [OK] CustomerController

php artisan make:controller Api/SubscriptionController
echo [OK] SubscriptionController

php artisan make:controller Api/InvoiceController
echo [OK] InvoiceController

php artisan make:controller Api/ReportController
echo [OK] ReportController

php artisan make:controller Api/CallLogController
echo [OK] CallLogController

php artisan make:controller Api/SipAccountController
echo [OK] SipAccountController

echo.
echo ========================================
echo  Hoan tat! Da tao 8 controllers.
echo  Vi tri: app/Http/Controllers/Api/
echo ========================================
pause