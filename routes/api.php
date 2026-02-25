<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallLogController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SipAccountController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - VNPT Voice IP CRM
|--------------------------------------------------------------------------
| Luồng: Route → Controller → Service → Repository → Model
|
| Prefix:  /api/v1
| Auth:    Sanctum (Bearer Token)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ─── Public routes (không cần xác thực) ──────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('admin/login',    [AuthController::class, 'adminLogin']);
        Route::post('customer/login', [AuthController::class, 'customerLogin']);
        Route::post('customer/register', [AuthController::class, 'customerRegister']);
    });

    // ─── Public: Xem gói cước (không cần đăng nhập) ──────────────────
    Route::get('packages',       [PackageController::class, 'index']);
    Route::get('packages/{id}',  [PackageController::class, 'show']);


    // ─── Protected routes - Admin ─────────────────────────────────────
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

        // Đăng xuất
        Route::post('logout', [AuthController::class, 'logout']);

        // ── Quản lý Gói cước ──────────────────────────────────────────
        Route::apiResource('packages', PackageController::class)
             ->except(['index', 'show']);

        // ── Quản lý Khách hàng ────────────────────────────────────────
        Route::get('customers',                        [CustomerController::class, 'index']);
        Route::post('customers',                       [CustomerController::class, 'store']);
        Route::get('customers/{id}',                   [CustomerController::class, 'show']);
        Route::put('customers/{id}',                   [CustomerController::class, 'update']);
        Route::delete('customers/{id}',                [CustomerController::class, 'destroy']);
        Route::patch('customers/{id}/status',          [CustomerController::class, 'changeStatus']);

        // ── Quản lý Đăng ký Gói ──────────────────────────────────────
        Route::get('subscriptions',                    [SubscriptionController::class, 'index']);
        Route::get('subscriptions/{id}',               [SubscriptionController::class, 'show']);
        Route::post('subscriptions/register',          [SubscriptionController::class, 'register']);
        Route::post('subscriptions/{id}/cancel',       [SubscriptionController::class, 'cancel']);
        Route::post('subscriptions/{id}/renew',        [SubscriptionController::class, 'renew']);
        Route::post('subscriptions/{id}/upgrade',      [SubscriptionController::class, 'upgrade']);
        Route::patch('subscriptions/{id}/toggle',      [SubscriptionController::class, 'toggleSuspend']);

        // ── Quản lý Hóa đơn & Thanh toán ─────────────────────────────
        Route::get('invoices',                         [InvoiceController::class, 'index']);
        Route::get('invoices/{id}',                    [InvoiceController::class, 'show']);
        Route::post('invoices/{id}/payments/confirm',  [InvoiceController::class, 'confirmPayment']);

        // ── Báo cáo & Thống kê ────────────────────────────────────────
        Route::prefix('reports')->group(function () {
            Route::get('revenue',      [ReportController::class, 'revenue']);
            Route::get('subscriptions',[ReportController::class, 'subscriptions']);
            Route::get('call-stats',   [ReportController::class, 'callStats']);
            Route::get('sip-status',   [ReportController::class, 'sipStatus']);
        });
    });


    // ─── Protected routes - Customer Portal ──────────────────────────
    Route::middleware('auth:sanctum')->prefix('customer')->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);

        // Profile
        Route::get('profile',         [CustomerController::class, 'profile']);
        Route::put('profile',         [CustomerController::class, 'updateProfile']);

        // Xem gói cước của mình
        Route::get('subscriptions',   [SubscriptionController::class, 'mySubscriptions']);
        Route::post('subscriptions/register', [SubscriptionController::class, 'register']);

        // Hóa đơn
        Route::get('invoices',        [InvoiceController::class, 'myInvoices']);
        Route::get('invoices/{id}',   [InvoiceController::class, 'show']);
        Route::post('invoices/{id}/pay', [InvoiceController::class, 'pay']);

        // Lịch sử cuộc gọi
        Route::get('call-logs',       [CallLogController::class, 'index']);

        // SIP Accounts
        Route::get('sip-accounts',    [SipAccountController::class, 'index']);
    });
});
