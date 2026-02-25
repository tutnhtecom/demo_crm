@echo off
echo Dang bat dau tao cac Model...

:: Tao cac model theo danh sach trong hinh
php artisan make:model Customer
php artisan make:model Package
php artisan make:model Subscription
php artisan make:model SipAccount
php artisan make:model Invoice
php artisan make:model Payment
php artisan make:model CallLog
php artisan make:model AdminUser

echo.
echo Hoan thanh! Tat ca 8 model da duoc tao.
pause