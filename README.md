# VNPT Voice IP CRM — Laravel 12

Hệ thống Quản trị Quan hệ Khách hàng (CRM) cho dịch vụ Voice over IP của VNPT,
xây dựng trên **Laravel 12 / PHP 8.2** theo kiến trúc **Route → Controller → Service → Repository**.

---

## 📋 Yêu cầu hệ thống

| Thành phần | Phiên bản |
|------------|-----------|
| PHP        | ≥ 8.2     |
| Laravel    | 12.x      |
| MySQL      | ≥ 8.0     |
| Composer   | ≥ 2.x     |

---

## 🚀 Cài đặt

```bash
# 1. Clone project
git clone <repo-url> vnpt-voip-crm && cd vnpt-voip-crm

# 2. Cài dependencies
composer install

# 3. Cấu hình environment
cp .env.example .env
php artisan key:generate

# 4. Cấu hình database trong .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vnpt_voip_crm
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Cấu hình VNPT SIP Server trong .env
VNPT_SIP_BASE_URL=http://sip.vnpt.vn/api
VNPT_SIP_API_KEY=your_api_key
VNPT_SIP_DOMAIN=sip.vnpt.vn

# 6. Chạy migration
php artisan migrate

# 7. Seed dữ liệu test
php artisan db:seed

# 8. Chạy server
php artisan serve
```

---

## 🏗️ Kiến trúc hệ thống

```
HTTP Request
     │
     ▼
┌─────────────┐
│   routes/   │  api.php — định nghĩa endpoint, middleware, prefix
│   api.php   │
└──────┬──────┘
       │
       ▼
┌─────────────────────┐
│   FormRequest       │  Validation (StoreCustomerRequest, ...)
└──────┬──────────────┘
       │
       ▼
┌─────────────────────────────┐
│   Controller (API Layer)    │  Nhận request, gọi Service, trả JSON
│  CustomerController         │
│  SubscriptionController     │
│  PackageController          │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│   Service (Business Logic)  │  Xử lý nghiệp vụ, validate, transaction
│  CustomerService            │
│  SubscriptionService        │──── gọi ───► SipProvisioningService
│  (implements Interface)     │               (giao tiếp VNPT SIP Server)
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│   Repository (Data Access)  │  Truy vấn DB, không có business logic
│  CustomerRepository         │
│  SubscriptionRepository     │
│  (implements Interface)     │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│   Models (Eloquent ORM)     │
│  Customer / Package         │
│  Subscription / SipAccount  │
│  Invoice / Payment / CallLog│
└──────┬──────────────────────┘
       │
       ▼
┌─────────────┐
│   MySQL DB  │
└─────────────┘
```

---

## 🗄️ Database Schema

```
customers ──────────── subscriptions ──── packages
    │                       │
    │                  sip_accounts ───── VNPT SIP Server
    │                       │
    ├── invoices             └── call_logs
    │      │
    └── payments
         │
    admin_users (confirmed_by)

system_logs (polymorphic — ghi lại mọi thao tác)
```

### Các bảng chính

| Bảng           | Mô tả                                     |
|----------------|-------------------------------------------|
| `customers`    | Thông tin KH cá nhân & doanh nghiệp       |
| `admin_users`  | Tài khoản quản trị hệ thống               |
| `packages`     | Danh mục gói cước VoIP                    |
| `subscriptions`| Vòng đời đăng ký gói (active/expired/...) |
| `sip_accounts` | Tài khoản SIP tương ứng trên SIP Server   |
| `invoices`     | Hóa đơn cước dịch vụ                      |
| `payments`     | Giao dịch thanh toán                      |
| `call_logs`    | Lịch sử cuộc gọi (từ SIP CDR)            |
| `system_logs`  | Nhật ký thao tác (audit trail)            |

---

## 🔌 API Endpoints

### Authentication
| Method | Endpoint                          | Mô tả                    |
|--------|-----------------------------------|--------------------------|
| POST   | `/api/v1/auth/admin/login`        | Đăng nhập admin          |
| POST   | `/api/v1/auth/customer/login`     | Đăng nhập khách hàng     |
| POST   | `/api/v1/auth/customer/register`  | Đăng ký tài khoản KH     |

### Gói cước (Public)
| Method | Endpoint                 | Mô tả                |
|--------|--------------------------|----------------------|
| GET    | `/api/v1/packages`       | Danh sách gói cước   |
| GET    | `/api/v1/packages/{id}`  | Chi tiết gói cước    |

### Admin — Quản lý Khách hàng
| Method | Endpoint                              | Mô tả                       |
|--------|---------------------------------------|-----------------------------|
| GET    | `/api/v1/admin/customers`             | Danh sách KH (filter/paging)|
| POST   | `/api/v1/admin/customers`             | Tạo KH mới                  |
| GET    | `/api/v1/admin/customers/{id}`        | Chi tiết KH                 |
| PUT    | `/api/v1/admin/customers/{id}`        | Cập nhật KH                 |
| DELETE | `/api/v1/admin/customers/{id}`        | Xóa KH (soft delete)        |
| PATCH  | `/api/v1/admin/customers/{id}/status` | Đổi trạng thái KH           |

### Admin — Quản lý Đăng ký Gói
| Method | Endpoint                                    | Mô tả                            |
|--------|---------------------------------------------|----------------------------------|
| GET    | `/api/v1/admin/subscriptions`               | Danh sách đăng ký                |
| POST   | `/api/v1/admin/subscriptions/register`      | **Đăng ký gói** (→ kích hoạt SIP)|
| POST   | `/api/v1/admin/subscriptions/{id}/cancel`   | Hủy gói (→ suspend SIP)          |
| POST   | `/api/v1/admin/subscriptions/{id}/renew`    | Gia hạn gói                      |
| POST   | `/api/v1/admin/subscriptions/{id}/upgrade`  | Nâng cấp gói (→ update SIP config)|
| PATCH  | `/api/v1/admin/subscriptions/{id}/toggle`   | Tạm dừng / Kích hoạt lại        |

---

## 💡 Luồng nghiệp vụ chính: Đăng ký gói cước

```
POST /api/v1/admin/subscriptions/register
        │
        ▼
SubscriptionController::register()
        │  Validate request
        ▼
SubscriptionService::register()
        │
        ├─ 1. Tính giá theo billing_cycle
        ├─ 2. DB::transaction() {
        │       a. SubscriptionRepository::create()  → INSERT subscriptions
        │       b. SipProvisioningService::activate()
        │              ├─ SipAccount::create()       → INSERT sip_accounts
        │              └─ HTTP POST → VNPT SIP Server API /accounts/create
        │  }
        │
        ▼
JSON Response { success: true, data: subscription }
```

---

## 🔑 Tài khoản test (sau khi seed)

| Vai trò           | Email                         | Mật khẩu       |
|-------------------|-------------------------------|----------------|
| Super Admin       | superadmin@vnpt.vn            | Admin@123456   |
| Admin KD          | admin.kd@vnpt.vn              | Admin@123456   |
| Operator          | operator01@vnpt.vn            | Admin@123456   |
| Kế toán           | accountant01@vnpt.vn          | Admin@123456   |
| KH cá nhân        | nguyenvanan@gmail.com         | Customer@123   |
| KH doanh nghiệp   | info@techsolutionvn.com       | Customer@123   |

---

## 📦 Cấu trúc thư mục

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── BaseApiController.php       ← Trait response helper (success/error/paginated)
│   │   ├── CustomerController.php
│   │   ├── SubscriptionController.php
│   │   └── PackageController.php
│   └── Requests/
│       ├── StoreCustomerRequest.php
│       └── UpdateCustomerRequest.php
├── Models/
│   ├── Customer.php
│   ├── AdminUser.php
│   ├── Package.php
│   ├── Subscription.php
│   ├── SipAccount.php
│   ├── Invoice.php
│   ├── Payment.php
│   └── CallLog.php
├── Repositories/
│   ├── Interfaces/
│   │   ├── BaseRepositoryInterface.php
│   │   ├── CustomerRepositoryInterface.php
│   │   └── SubscriptionRepositoryInterface.php
│   ├── BaseRepository.php
│   ├── CustomerRepository.php
│   └── SubscriptionRepository.php
├── Services/
│   ├── Interfaces/
│   │   ├── CustomerServiceInterface.php
│   │   ├── SubscriptionServiceInterface.php
│   │   └── SipProvisioningServiceInterface.php
│   ├── CustomerService.php
│   ├── SubscriptionService.php
│   └── SipProvisioningService.php       ← Giao tiếp VNPT SIP Server
└── Providers/
    └── AppServiceProvider.php           ← DI bindings (Interface → Implementation)

database/
├── migrations/
│   ├── ..._create_customers_table.php
│   ├── ..._create_admin_users_table.php
│   ├── ..._create_packages_table.php
│   ├── ..._create_subscriptions_table.php
│   ├── ..._create_sip_accounts_table.php
│   ├── ..._create_invoices_table.php
│   ├── ..._create_payments_table.php
│   ├── ..._create_call_logs_table.php
│   └── ..._create_system_logs_table.php
└── seeders/
    ├── DatabaseSeeder.php               ← Entry point: gọi tất cả seeders
    ├── AdminUserSeeder.php
    ├── PackageSeeder.php
    ├── CustomerSeeder.php
    ├── SubscriptionSeeder.php           ← cũng tạo SipAccount
    ├── InvoicePaymentSeeder.php
    └── CallLogSeeder.php

routes/
└── api.php                              ← Toàn bộ API routes
```
