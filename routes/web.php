<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\crm\AffiliateController;
use App\Http\Controllers\crm\ConfigSystemController;
use App\Http\Controllers\crm\EducationTypeController;
use App\Http\Controllers\crm\RolePermissionController;
use App\Http\Controllers\crm\EmployeesController;
use App\Http\Controllers\crm\InteractionHistoryController;
use App\Http\Controllers\crm\Voip24hController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\crm\DashboardController;
use App\Http\Controllers\crm\FilterController;
use App\Http\Controllers\crm\LeadsController;
use App\Http\Controllers\crm\NotificationController;
use App\Http\Controllers\crm\OfficialStudentController;
use App\Http\Controllers\crm\RequestSupportController;
use App\Http\Controllers\crm\TaskManagementController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'login'])->name('Leads.login');
Route::get('/login', [PageController::class, 'login'])->name('Leads.login');
Route::post('/leads-login', [AuthController::class, 'leads_login'])->name('post.login');
Route::get('/register', [PageController::class, 'register'])->name('Leads.register');
Route::get('/application_form/{id}', [PageController::class, 'application_form'])->name('application.form.register');
Route::get('/view_application_form/{id}', [PageController::class, 'view_application_form'])->name('view.application.form.register');

// Route::get('/', [PageController::class, 'loginCRM'])->name('crm.login');
Route::get('/crm/login', [PageController::class, 'loginCRM'])->name('crm.login');
Route::get('/crm/register', [PageController::class, 'registerCRM'])->name('crm.register');
Route::get('/crm/forgot_password', [PageController::class, 'forgotPasswordCRM'])->name('crm.forgotPassword');
Route::get('/crm/change-password', [PageController::class, 'change_password'])->name('crm.change_password');

Route::get('/403', [PageController::class, 'errors'])->name('errors.403');

Route::get('/form_register/landing_page', [PageController::class, 'form_register'])->name('form.register');

Route::middleware(['auth.login', 'crm.allow_access'])->group(function () {
    Route::get('/crm/employees/detail/edit/{id}', [EmployeesController::class, 'editEmployees'])->name('crm.employees.edit');
    // Route::get('/', [PageController::class, 'index']);
    // Route::get('/', [LeadsController::class, 'statistical'])->name('crm.leads.statistical');
    // Route::get('/statistical', [LeadsController::class, 'statistical'])->name('crm.leads.statistical');
    Route::group(['prefix' => 'crm'], function () {
        Route::get('/', [LeadsController::class, 'statistical'])->name('crm.statistical');
        Route::get('/profile_detail', [PageController::class, 'profileDetailUserLogin'])->name('crm.profile.detail');
        Route::get('/', [DashboardController::class, 'statistical'])->name('crm.leads.statistical');
        Route::get('/statistical', [DashboardController::class, 'statistical'])->name('crm.leads.statistical');
        Route::get('/kpi_statistical', [DashboardController::class, 'statistical_kpi'])->name('crm.leads.statistical_kpi');
        Route::get('/notification/to-me', [NotificationController::class, 'listNotificationToMe'])->name('crm.notification.listToMe');        
        Route::group(['prefix' => 'config-filters'], function () {                        
            Route::get('/', [FilterController::class, 'index'])->name('crm.filters.index');
        });
        Route::post('/search', [SearchController::class, 'search'])->name('search');

        Route::middleware(['router_name.access'])->group(function () {
            Route::group(['prefix' => 'leads'], function () {
                Route::get('/', [LeadsController::class, 'index'])->name('crm.leads.index');
                Route::post('/filter', [LeadsController::class, 'filter'])->name('crm.lead.filter');
                Route::get('/detail_lead/{id}', [LeadsController::class, 'detailLead'])->name('crm.lead.detail');
                Route::get('/detail_lead/{id}/transaction/', [LeadsController::class, 'transaction'])->name('crm.lead.transaction');
                Route::get('/detail_transaction/{id}', [LeadsController::class, 'transactionDetail'])->name('crm.transaction.detail');
                Route::get('/create_lead', [LeadsController::class, 'createLead'])->name('crm.lead.create_lead');
                Route::get('/edit_lead/{id}', [LeadsController::class, 'editLead'])->name('crm.lead.edit_lead');
            });
            // Route::get('/official_student', [OfficialStudentController::class, 'listStudent'])->name('crm.official.student');
            Route::group(['prefix' => 'students'], function () {
                Route::get('/', [OfficialStudentController::class, 'listStudent'])->name('crm.official.student');
                Route::get('/detail_student/{id}', [OfficialStudentController::class, 'detailStudent'])->name('crm.student.detail');
                Route::post('/filter', [LeadsController::class, 'filter'])->name('crm.lead.filter');
                // Route::get('/detail_lead/{id}/transaction/', [LeadsController::class, 'transaction'])->name('crm.lead.transaction');
                // Route::get('/detail_transaction/{id}', [LeadsController::class, 'transactionDetail'])->name('crm.transaction.detail');
                // Route::get('/create_lead', [LeadsController::class, 'createLead'])->name('crm.lead.create_lead');
                Route::get('/edit_student/{id}', [OfficialStudentController::class, 'editStudent'])->name('crm.student.edit');
            });
            Route::group(['prefix' => 'employees'], function () {
                Route::get('/', [EmployeesController::class, 'employeesList'])->name('crm.employees.list');
                Route::get('/create', [EmployeesController::class, 'createEmployees'])->name('crm.employees.create');
                Route::get('/detail/{id}', [EmployeesController::class, 'detailEmployees'])->name('crm.employee.detail');
                // Route::get('/detail/edit/{id}', [EmployeesController::class, 'editEmployees'])->name('crm.employees.edit');
            });

            Route::group(['prefix' => 'notification'], function () {
                Route::get('/list', [NotificationController::class, 'listNotification'])->name('crm.notification.list');
                Route::get('/groups', [NotificationController::class, 'groupsNotification'])->name('crm.notification.groups');
                Route::get('/groups/{id}', [NotificationController::class, 'groupsNotificationDetail'])->name('crm.notification.groupsDetail');
                Route::get('/detail/{id}', [NotificationController::class, 'detailNotification'])->name('crm.notification.detail');
                Route::get('/create', [NotificationController::class, 'createNotification'])->name('crm.notification.create');
                Route::get('/send_group_price_list', [NotificationController::class, 'sendNotiPriceList'])->name('crm.notification.pricelist');
            });

            Route::group(['prefix' => 'task_management'], function () {
                Route::get('/list', [TaskManagementController::class, 'listTask'])->name('crm.task.list');
                Route::get('/target', [TaskManagementController::class, 'targetTask'])->name('crm.task.target');
            });
            Route::get('/role_permissions', [RolePermissionController::class, 'roleDetail'])->name('crm.role.roleList');
            Route::get('/config_email', [ConfigSystemController::class, 'configEmail'])->name('crm.system.email');
            Route::get('/config_sources', [ConfigSystemController::class, 'configSources'])->name('crm.system.sources');
            Route::get('/config_status', [ConfigSystemController::class, 'configStatus'])->name('crm.system.status');
            Route::get('/custom_fields', [ConfigSystemController::class, 'customFields'])->name('crm.custom.field');
            Route::get('/major_subject_combination', [ConfigSystemController::class, 'majorSubjectCombination'])->name('crm.major.subject');
            Route::get('/general_configuration', [ConfigSystemController::class, 'generalConfiguration'])->name('crm.general.configuration');
            Route::get('/request_support', [RequestSupportController::class, 'listSupport'])->name('crm.request.support');
            Route::get('/request_support/detail_support/{id}', [RequestSupportController::class, 'detailSuport'])->name('crm.detail.support');
            Route::get('/interaction_history', [InteractionHistoryController::class, 'listHistory'])->name('crm.interaction.history');
            Route::get('/affiliate_sources', [AffiliateController::class, 'affiliateSources'])->name('crm.affiliate.sources');
            Route::get('/affiliate_sources/{id}', [AffiliateController::class, 'affiliateSourcesDetail'])->name('crm.affiliate.detail');
            Route::get('/academic_terms', [LeadsController::class, 'academic_terms'])->name('crm.academic.terms');
            Route::get('/academic_terms/semesters/{id}', [LeadsController::class, 'academic_semesters'])->name('crm.academic.semesters');
            Route::get('/education_type', [EducationTypeController::class, 'educationType'])->name('crm.education.type');

            // Tổng đài VOIP24H \\
            Route::get('/voip24h', [Voip24hController::class, 'listVoip24h'])->name('crm.voip24h.list');

        });
    });
});

