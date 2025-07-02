<?php
use App\Http\Controllers\Api\AcademicTermsController;
use App\Http\Controllers\Api\AcademyListController;
use App\Http\Controllers\Api\AffiliateController;
use App\Http\Controllers\Api\ApiListsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlockAdminssionsController;
use App\Http\Controllers\Api\ConfigGeneralController;
use App\Http\Controllers\Api\CustomFieldImportsController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EducationsTypesController;
use App\Http\Controllers\Api\EmailTemplateController;
use App\Http\Controllers\Api\EmailTemplateTypesController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\FormAdminssionsController;
use App\Http\Controllers\Api\KpisController;
use App\Http\Controllers\Api\LeadsController;
use App\Http\Controllers\Api\MarjorsController;
use App\Http\Controllers\Api\MethodAdminssionController;
use App\Http\Controllers\Api\NationsController;
use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\Api\NotificationsGroupsController;
use App\Http\Controllers\Api\PriceListsController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\SemestersController;
use App\Http\Controllers\Api\SourcesController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\SupportsController;
use App\Http\Controllers\Api\SupportsStatusController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\TransactionsController;
use App\Http\Controllers\Api\TransactionStatusController;
use App\Http\Controllers\Api\TransactionTypesController;
use App\Http\Controllers\Api\Voip24hController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionsController;
use App\Models\ConfigFilter;
use App\Models\ConfigGeneral;
use Illuminate\Support\Facades\Route;

$router->get('/test_send_mail', [PageController::class, 'test_send_mail']);
// Quản lý leads
Route::group([
    'middleware' => 'api',
    'prefix' => 'leads'
], function ($router) {
    // Đăng ký hồ sơ
    $router->post('/register-profile', [LeadsController::class, 'create']);
    //Upload avatar
    $router->post('/upload-avatar/{id}', [LeadsController::class, 'uAvatar']);
    // Thông tin hồ sơ
    $router->post('/information-profile/{id}', [LeadsController::class, 'uPersonal']);
    // Thông tin liên lạc
    $router->post('/contacts/{id}', [LeadsController::class, 'contacts']);
    // Thông tin gia đình
    $router->post('/family/{id}', [LeadsController::class, 'family']);
    // Thông tin xét tuyển
    $router->post('/score/{id}', [LeadsController::class, 'score']);
    // Xác nhận hồ sơ
    $router->post('/confirm/{id}', [LeadsController::class, 'confirm']);
    // Gửi yêu cầu hỗ trợ
    $router->post('/supports', [LeadsController::class, 'supports']);
    // Thông tin thi sinh
    $router->get('/thong-tin-sinh-vien/{id}', [LeadsController::class, 'details']);
    // Api đăng ký
    
    $router->post('/dang-ky', [LeadsController::class, 'register_with_sources']);
    // Lịch sử thay đổi trạng thái
    $router->get('/history/{id}', [LeadsController::class, 'get_status_history']);
    
    $router->post('/forgot-password', [LeadsController::class, 'forgot_password'])->name('Leads.forgotpassword');

});


// CRM
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/reset-password', [PageController::class, 'reset_password']);
    $router->post('/send-mail-link-reset', [PageController::class, 'send_mail_link_reset']);
});

Route::group([
    'middleware'    => 'api',
    'prefix'        => 'academy-list'
], function ($router) {
    $router->get('/', [AcademyListController::class, 'index'])->name('AcademyList.data');
    $router->post('/create', [AcademyListController::class, 'create'])->name('AcademyList.create');
    // $router->post('/create-multiple', [AcademyListController::class, 'createMultiple'])->name('AcademyList.create');
    $router->post('/update/{id}', [AcademyListController::class, 'update'])->name('AcademyList.update');
    $router->post('/delete/{id}', [AcademyListController::class, 'delete'])->name('AcademyList.delete');
    // $router->post('/import', [AcademyListController::class, 'imports'])->name('AcademyList.import');
    // $router->post('/update-leads-to-academic/{id}', [AcademyListController::class, 'update_leads_to_academic'])->name('AcademyList.update_leads_to_academic');
});
Route::middleware(['api.login', 'crm.allow_access'])->group(function () {
    // Tạo phân quyền theo router
    // Route::middleware(['router.access'])->group(function () {
        // Sinh viên tiềm năng
        Route::prefix('leads')->group(function ($router) {
            $router->post('/data', [LeadsController::class, 'data'])->name('Leads.data');
            $router->post('/ajax', [LeadsController::class, 'data'])->name('Leads.data');
            $router->post('/details/{id}', [LeadsController::class, 'details'])->name('Leads.data');
            $router->post('/update/{id}', [LeadsController::class, 'update'])->name('Leads.update');
            $router->post('/update-status-lead/{id}', [LeadsController::class, 'update_status_lead'])->name('Leads.update');
            $router->post('/delete/{id}', [LeadsController::class, 'delete'])->name('Leads.delete');
            $router->post('/delete-multiple', [LeadsController::class, 'delete_multiple'])->name('Leads.delete_multiple');
            $router->post('/crm-create-lead', [LeadsController::class, 'crm_create_lead'])->name('Leads.create');
            $router->post('/export', [LeadsController::class, 'export'])->name('Leads.data');
            $router->post('/import', [LeadsController::class, 'import'])->name('Leads.create');
            $router->post('/active', [LeadsController::class, 'active'])->name('Leads.update');
            $router->post('/update-employees/{id}', [LeadsController::class, 'update_employees'])->name('Leads.update');
            $router->post('/create-leads-from-support', [LeadsController::class, 'create_leads_from_support'])->name('Leads.create');
            $router->post('/update-custom-fields/{id}', [LeadsController::class, 'update_custom_fields'])->name('Leads.update_custom_field');
            $router->get('/get-notification-birthday', [LeadsController::class, 'get_notification_birthday']);
            $router->post('/import-code-for-leads', [LeadsController::class, 'import_code_for_leads'])->name('Leads.import_code_for_leads');
            $router->post('/update-status-for-leads', [LeadsController::class, 'update_status_for_leads'])->name('Leads.update');
            $router->post('/update-employees-for-leads', [LeadsController::class, 'update_employees_for_leads'])->name('Leads.update');

        });
        // Sinh viên chính thức
        Route::group([
            'middleware' => 'api',
            'prefix' => 'students'
        ], function ($router) {
            $router->post('/', [StudentsController::class, 'data'])->name('Students.data');
            $router->post('/ajax', [StudentsController::class, 'data'])->name('Students.data');
            $router->post('/details/{id}', [StudentsController::class, 'details'])->name('Students.data');
            $router->post('/convert', [StudentsController::class, 'convert'])->name('Students.create');
            $router->post('/convert-multiple', [StudentsController::class, 'convert_multiple'])->name('Students.convert_multiple'); // Chuyển từ leads sang student
            $router->post('/update/{id}', [StudentsController::class, 'update'])->name('Students.update');
            $router->post('/update-status-students/{id}', [StudentsController::class, 'update_status_students'])->name('Leads.update');
            // $router->post('/delete/{id}', [StudentsController::class, 'delete'])->name('Students.delete');
            $router->post('/import', [StudentsController::class, 'import'])->name('Students.create');
            $router->post('/export', [StudentsController::class, 'export'])->name('Students.data');
            $router->post('/convert-to-leads/{id}', [StudentsController::class, 'convert_to_leads'])->name('Leads.convert_to_leads');
            $router->post('/convert-multiple-students-to-leads', [StudentsController::class, 'convert_multiple_students_to_leads'])->name('Leads.convert_multiple_students_to_leads');
            $router->post('/update-multiple-academic-terms', [StudentsController::class, 'update_multiple_academic_terms'])->name('Leads.update_multiple_academic_terms');
        });
        // Quản lý thông báo
        Route::group([
            'middleware' => 'api',
            'prefix' => 'notifications'
        ], function ($router) {
            $router->get('/', [NotificationsController::class, 'index'])->name('Notifications.data');
            $router->get('/data-for-employees', [NotificationsController::class, 'notification_heads'])->name('Notifications.data');
            $router->get('/details/{id}', [NotificationsController::class, 'details'])->name('Notifications.data');
            $router->post('/create', [NotificationsController::class, 'create'])->name('Notifications.create');
            $router->post('/create-draft', [NotificationsController::class, 'create_craft'])->name('Notifications.create');
            $router->post('/update/{id}', [NotificationsController::class, 'update'])->name('Notifications.update');
            $router->post('/delete/{id}', [NotificationsController::class, 'delete'])->name('Notifications.delete');
            $router->post('/import-excel', [NotificationsController::class, 'imports'])->name('Notifications.imports');

        });
        // Quản lý học phí
        Route::group([
            'middleware' => 'api',
            'prefix' => 'price-list'
        ], function ($router) {
            $router->get('/', [PriceListsController::class, 'index'])->name('PriceLists.data');
            $router->post('/create', [PriceListsController::class, 'create'])->name('PriceLists.create');
            $router->post('/create-multiple', [PriceListsController::class, 'create_multiple'])->name('PriceLists.create_multiple');
            $router->post('/update/{id}', [PriceListsController::class, 'update'])->name('PriceLists.update');
            $router->post('/delete/{id}', [PriceListsController::class, 'delete'])->name('PriceLists.delete');
            $router->post('/update-status/{id}', [PriceListsController::class, 'update_status'])->name('PriceLists.update');
            $router->get('/details/{id}', [PriceListsController::class, 'details'])->name('PriceLists.data');
            $router->post('/upload-file/{id}', [PriceListsController::class, 'update_file_pdf'])->name('PriceLists.update');
            $router->post('/update-note/{id}', [PriceListsController::class, 'update_note'])->name('PriceLists.update_note');
            $router->post('/imports-excel', [PriceListsController::class, 'imports'])->name('PriceLists.imports');
        });
        // Quản lý chi tiêu
        Route::group([
            'middleware' => 'api',
            'prefix' => 'kpis'
        ], function ($router) {
            $router->get('/', [KpisController::class, 'data'])->name('Kpis.data');
            $router->get('/get-data-kpis', [KpisController::class, 'get_data_kpis'])->name('Kpis.data');
            $router->get('/details/{id}', [KpisController::class, 'details'])->name('Kpis.data');
            $router->post('/create', [KpisController::class, 'create'])->name('Kpis.create');
            $router->post('/update', [KpisController::class, 'update'])->name('Kpis.update');
            $router->post('/update-mulitple', [KpisController::class, 'update_multiple'])->name('Kpis.update_multiple');
            $router->post('/cron-data', [KpisController::class, 'cron_data'])->name('Kpis.create');
            $router->get('/create-notification-kpis-expired', [KpisController::class, 'create_notification_kpis_expired'])->name('Kpis.create_notification_kpis_expired');
        });

    // });
    // Phần quyền cấu hình
    Route::middleware(['config.access'])->group(function () {

    });

    // Thông tin tài khoản
    Route::prefix('auth')->group(function ($router) {
        $router->post('/logout', [AuthController::class, 'logout']);
        $router->post('/refresh', [AuthController::class, 'refresh']);
        $router->get('/user-profile', [AuthController::class, 'userProfile']);
        $router->post('/change-password', [AuthController::class, 'changePassWord']);
        $router->post('/update-profile/{id}', [AuthController::class, 'update_profile']);        
    });
    // Thông tin yêu cầu hỗ trợ
    Route::prefix('supports')->group(function ($router) {
        $router->post('/', [SupportsController::class, 'index']);
        $router->get('/details/{id}', [SupportsController::class, 'details']);
        $router->post('/create', [SupportsController::class, 'create']);
        $router->post('/create-multiple', [SupportsController::class, 'createMultiple']);
        $router->post('/update/{id}', [SupportsController::class, 'update']);
        $router->post('/update-status/{id}', [SupportsController::class, 'update_status']);
        $router->post('/update-reply/{id}', [SupportsController::class, 'update_reply']);
        $router->post('/delete/{id}', [SupportsController::class, 'delete']);
        $router->post('/export', [SupportsController::class, 'export'])->name('Leads.export');
        $router->post('/auto-update-status-support', [SupportsController::class, 'su'])->name('supports.auto_update_status_support');
    });
    // Thông tin trạng thái yêu cầu hỗ trợ
    Route::prefix('supports-status')->group(function ($router) {
        $router->get('/', [SupportsStatusController::class, 'index']);
        $router->get('/details/{id}', [SupportsStatusController::class, 'details']);
        $router->post('/create', [SupportsStatusController::class, 'create']);
        $router->post('/create-multiple', [SupportsStatusController::class, 'createMultiple']);
        $router->post('/update/{id}', [SupportsStatusController::class, 'update']);
        $router->post('/delete/{id}', [SupportsStatusController::class, 'delete']);
    });
    Route::prefix('config-general')->group(function ($router) {
        $router->get('/', [ConfigGeneralController::class, 'index']);
        $router->get('/details/{id}', [ConfigGeneralController::class, 'details']);
        $router->post('/create', [ConfigGeneralController::class, 'create']);        
        $router->post('/update/{id}', [ConfigGeneralController::class, 'update']);
        $router->post('/delete/{id}', [ConfigGeneralController::class, 'delete']);
        $router->post('/create-config-voip', [ConfigGeneralController::class, 'create_config_voip']);   
        $router->post('/update-config-voip/{id}', [ConfigGeneralController::class, 'update_config_voip']);           
    });
    // Thông tin nhân viên
    Route::prefix('employees')->group(function ($router) {
        $router->get('/', [EmployeeController::class, 'index'])->name('employees.index');
        $router->post('/get-all-leads', [EmployeeController::class, 'get_all_leads']);
        $router->get('/details/{id}', [EmployeeController::class, 'details'])->name('employees.details');
        $router->post('/create', [EmployeeController::class, 'create'])->name('employees.create');
        $router->post('/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        $router->post('/not-active/{id}', [EmployeeController::class, 'not_active']);
        $router->post('/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');
        $router->post('/delete-multiple', [EmployeeController::class, 'delete_multiple']);
        $router->post('/imports', [EmployeeController::class, 'imports'])->name('employees.imports');
        $router->get('/exports', [EmployeeController::class, 'exports']);
        $router->post('/active-system', [EmployeeController::class, 'active_system']);        
        // $router->post('/report-kpis', [EmployeeController::class, 'exports']);
    });



    // Nguồn tiếp cận
    Route::group([
        'middleware' => 'api',
        'prefix' => 'sources'
    ], function ($router) {
        $router->get('/', [SourcesController::class, 'index']);
        $router->get('/details/{id}', [SourcesController::class, 'details']);
        $router->post('/create', [SourcesController::class, 'create']);
        $router->post('/create-sources-documents', [SourcesController::class, 'create_sources_documents']);
        $router->post('/create-sources-rate', [SourcesController::class, 'create_sources_rate']);
        $router->post('/update/{id}', [SourcesController::class, 'update']);
        $router->post('/update-sources-documents/{id}', [SourcesController::class, 'update_sources_documents']);
        $router->post('/update-sources-rate/{id}', [SourcesController::class, 'update_sources_rate']);
        $router->post('/delete/{id}', [SourcesController::class, 'delete']);
        $router->post('/delete-sources-documents/{id}', [SourcesController::class, 'delete_sources_documents']);
        $router->post('/delete-sources-rate/{id}', [SourcesController::class, 'delete_sources_rate']);
        $router->post('/imports', [SourcesController::class, 'imports']);
        $router->post('/imports-sources-documents', [SourcesController::class, 'imports_sources_documents']);
        $router->post('/imports-sources-rates', [SourcesController::class, 'imports_sources_rates']);
        $router->post('/exports', [SourcesController::class, 'exports']);
        $router->get('/get-quantity-leads-by-sources/{id}', [SourcesController::class, 'get_quantity_leads_by_sources']); // Báo cáo số lượng thí sinh theo đối tác
        $router->post('/get-price_lists-leads-by-sources/{id}', [SourcesController::class, 'get_price_lists_leads_by_sources']); // Báo cáo học phí của thí sinh
        $router->post('/get-price_lists-leads-by-sources-for-ajax/{id}', [SourcesController::class, 'get_price_lists_leads_by_sources_for_ajax']); // Báo cáo học phí của thí sinh                
        $router->get('/get-list-by-fields', [SourcesController::class, 'get_list_by_fields']);
        $router->post('/imports-sources-price-list', [SourcesController::class, 'import_sources_price_lists']);
        $router->post('/get-price_lists-leads-by-sources-news/{id}', [SourcesController::class, 'get_price_lists_leads_by_sources_news']); // Báo cáo học phí của thí sinh
        $router->post('/get-payment-for-partners/{id}', [SourcesController::class, 'get_payment_for_partners']); // Báo cáo thống kê thanh toán hoa hồng cho đối tác

        $router->post('/get-payment-for-partners-news/{id}', [SourcesController::class, 'get_payment_for_partners_news']); // Báo cáo thống kê thanh toán hoa hồng cho đối tác
    });
    // Chuyên ngành đào tạo
    Route::group([
        'middleware' => 'api',
        'prefix' => 'marjors'
    ], function ($router) {
        $router->get('/', [MarjorsController::class, 'index']);
        $router->get('/details/{id}', [MarjorsController::class, 'details']);
        $router->post('/create', [MarjorsController::class, 'create']);
        $router->post('/create-multiple', [MarjorsController::class, 'createMultiple']);
        $router->post('/update/{id}', [MarjorsController::class, 'update']);
        $router->post('/delete/{id}', [MarjorsController::class, 'delete']);
    });

    // Quản lý trạng thái
    Route::group([
        'middleware' => 'api',
        'prefix' => 'status'
    ], function ($router) {
        $router->get('/', [StatusController::class, 'index']);
        $router->get('/details/{id}', [StatusController::class, 'details']);
        $router->post('/create', [StatusController::class, 'create']);
        $router->post('/create-multiple', [StatusController::class, 'createMultiple']);
        $router->post('/update/{id}', [StatusController::class, 'update']);
        $router->post('/delete/{id}', [StatusController::class, 'delete']);
    });

    // Quản lý thẻ
    Route::group([
        'middleware' => 'api',
        'prefix' => 'tags'
    ], function ($router) {
        $router->get('/', [TagsController::class, 'index']);
        $router->get('/details/{id}', [TagsController::class, 'details']);
        $router->post('/create', [TagsController::class, 'create']);
        $router->post('/create-multiple', [TagsController::class, 'createMultiple']);
        $router->post('/update/{id}', [TagsController::class, 'update']);
        $router->post('/delete/{id}', [TagsController::class, 'delete']);
    });

    // Quản lý loại tốt nghiệp
    Route::group([
        'middleware' => 'api',
        'prefix' => 'educations-types'
    ], function ($router) {
        $router->get('/', [EducationsTypesController::class, 'index']);
        $router->get('/details/{id}', [EducationsTypesController::class, 'details']);
        $router->post('/create', [EducationsTypesController::class, 'create']);
        $router->post('/create-multiple', [EducationsTypesController::class, 'createMultiple']);
        $router->post('/update/{id}', [EducationsTypesController::class, 'update']);
        $router->post('/delete/{id}', [EducationsTypesController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'method-adminssions'
    ], function ($router) {
        $router->get('/', [MethodAdminssionController::class, 'index']);
        $router->get('/details/{id}', [MethodAdminssionController::class, 'details']);
        $router->post('/create', [MethodAdminssionController::class, 'create']);
        $router->post('/create-multiple', [MethodAdminssionController::class, 'createMultiple']);
        $router->post('/update/{id}', [MethodAdminssionController::class, 'update']);
        $router->post('/delete/{id}', [MethodAdminssionController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'form-adminssions'
    ], function ($router) {
        $router->get('/', [FormAdminssionsController::class, 'index']);
        $router->get('/details/{id}', [FormAdminssionsController::class, 'details']);
        $router->post('/create', [FormAdminssionsController::class, 'create']);
        $router->post('/create-multiple', [FormAdminssionsController::class, 'createMultiple']);
        $router->post('/update/{id}', [FormAdminssionsController::class, 'update']);
        $router->post('/delete/{id}', [FormAdminssionsController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'block-adminssions'
    ], function ($router) {
        $router->get('/', [BlockAdminssionsController::class, 'index']);
        $router->get('/details/{id}', [BlockAdminssionsController::class, 'details']);
        $router->post('/create', [BlockAdminssionsController::class, 'create']);
        $router->post('/create-multiple', [BlockAdminssionsController::class, 'createMultiple']);
        $router->post('/update/{id}', [BlockAdminssionsController::class, 'update']);
        $router->post('/delete/{id}', [BlockAdminssionsController::class, 'delete']);
    });

    //Trạng thái giao dịch
    // Quản lý thẻ
    Route::group([
        'middleware' => 'api',
        'prefix' => 'transactions-status'
    ], function ($router) {
        $router->get('/', [TransactionStatusController::class, 'index']);
        $router->get('/details/{id}', [TransactionStatusController::class, 'details']);
        $router->post('/create', [TransactionStatusController::class, 'create']);
        $router->post('/create-multiple', [TransactionStatusController::class, 'createMultiple']);
        $router->post('/update/{id}', [TransactionStatusController::class, 'update']);
        $router->post('/delete/{id}', [TransactionStatusController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'transactions-types'
    ], function ($router) {
        $router->get('/', [TransactionTypesController::class, 'index']);
        $router->get('/details/{id}', [TransactionTypesController::class, 'details']);
        $router->post('/create', [TransactionTypesController::class, 'create']);
        $router->post('/create-multiple', [TransactionTypesController::class, 'createMultiple']);
        $router->post('/update/{id}', [TransactionTypesController::class, 'update']);
        $router->post('/delete/{id}', [TransactionTypesController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'transactions'
    ], function ($router) {
        $router->get('/', [TransactionsController::class, 'index']);
        $router->get('/details/{id}', [TransactionsController::class, 'details']);
        $router->post('/create', [TransactionsController::class, 'create'])->name('transactions.create');
        $router->post('/update/{id}', [TransactionsController::class, 'update'])->name('transactions.update');
        $router->post('/delete/{id}', [TransactionsController::class, 'delete'])->name('transactions.delete');
        $router->post('/createMultiple', [TransactionsController::class, 'createMultiple']);
        $router->post('/create-multiple', [TransactionsController::class, 'create_multiple']);
        $router->post('/import-excel', [TransactionsController::class, 'import_excel']);
    });



    // Quản lý dân tộc
    Route::group([
        'middleware' => 'api',
        'prefix' => 'nations'
    ], function ($router) {
        $router->get('/', [NationsController::class, 'index']);
        $router->get('/details/{id}', [NationsController::class, 'details']);
        $router->post('/create', [NationsController::class, 'create']);
        $router->post('/create-multiple', [NationsController::class, 'createMultiple']);
        $router->post('/update/{id}', [NationsController::class, 'update']);
        $router->post('/delete/{id}', [NationsController::class, 'delete']);
    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'tasks'
    ], function ($router) {
        $router->get('/', [TasksController::class, 'index'])->name('Task.list');
        $router->get('/details/{id}', [TasksController::class, 'details']);
        $router->post('/create', [TasksController::class, 'create'])->name('Tasks.create');
        $router->post('/update/{id}', [TasksController::class, 'update'])->name('Tasks.update');
        $router->post('/update-status/{id}', [TasksController::class, 'update_status']);
        $router->post('/delete/{id}', [TasksController::class, 'delete'])->name('Tasks.delete');
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'roles'
    ], function ($router) {
        $router->get('/', [RolesController::class, 'index']);
        $router->get('/details/{id}', [RolesController::class, 'details']);
        $router->post('/create', [RolesController::class, 'create']);
        $router->post('/create-multiple', [RolesController::class, 'createMultiple']);
        $router->post('/update/{id}', [RolesController::class, 'update']);
        $router->post('/delete/{id}', [RolesController::class, 'delete']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'permissions'
    ], function ($router) {        
        $router->post('/roles-permission/store', [RolePermissionController::class, 'store']);
        $router->get('/', [PermissionsController::class, 'index']);
        $router->get('/details/{id}', [PermissionsController::class, 'index']);
        $router->get('/get-list-id-by-show-data-all', [PermissionsController::class, 'get_list_id_by_show_data_all']);
        $router->post('/set-permission-for-router-name', [PermissionsController::class, 'set_permission_for_router_name']);
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'list'
    ], function ($router) {
        $router->get('/', [ApiListsController::class, 'index']);
        $router->post('/create', [ApiListsController::class, 'create']);
        $router->get('/details/{id}', [ApiListsController::class, 'details']);
        $router->post('/update/{id}', [ApiListsController::class, 'update']);
        $router->post('/delete/{id}', [ApiListsController::class, 'delete']);
        $router->post('/import', [ApiListsController::class, 'imports']);
    });
    // Loại mẫu email
    Route::group([
        'middleware' => 'api',
        'prefix' => 'email-template-types'
    ], function ($router) {
        $router->post('/create', [EmailTemplateTypesController::class, 'create']);
        $router->get('/', [EmailTemplateTypesController::class, 'index']);
        $router->get('/details/{id}', [EmailTemplateTypesController::class, 'details']);
        $router->post('/update/{id}', [EmailTemplateTypesController::class, 'update']);
        $router->post('/delete/{id}', [EmailTemplateTypesController::class, 'delete']);
    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'email-templates'
    ], function ($router) {
        $router->post('/create', [EmailTemplateController::class, 'create']);
        $router->post('/update/{id}', [EmailTemplateController::class, 'update']);
        $router->get('/', [EmailTemplateController::class, 'index']);
        $router->get('/details/{id}', [EmailTemplateController::class, 'details']);
        $router->post('/delete/{id}', [EmailTemplateController::class, 'delete']);
        $router->post('/upload-image', [EmailTemplateController::class, 'upload_image']);
        $router->post('/import-key-email-template', [EmailTemplateController::class, 'import_key_email_template']);
    });

    Route::group([
        'middleware'    => 'api',
        'prefix'        => 'notifications-groups'
    ], function ($router) {
        $router->get('/', [NotificationsGroupsController::class, 'index'])->name('Notifications.data');
        $router->get('/details/{id}', [NotificationsGroupsController::class, 'details'])->name('Notifications.data');
        $router->post('/create', [NotificationsGroupsController::class, 'create'])->name('Notifications.create');
        $router->post('/create-multiple', [NotificationsGroupsController::class, 'createMultiple'])->name('Notifications.create');
        $router->post('/update/{id}', [NotificationsGroupsController::class, 'update'])->name('Notifications.update');
        $router->post('/delete/{id}', [NotificationsGroupsController::class, 'delete'])->name('Notifications.delete');
    });

    Route::group([
        'middleware'    => 'api',
        'prefix'        => 'academic-terms'
    ], function ($router) {
        $router->get('/', [AcademicTermsController::class, 'index'])->name('AcademicTerms.data');
        $router->get('/details/{id}', [AcademicTermsController::class, 'details'])->name('AcademicTerms.data');
        $router->post('/create', [AcademicTermsController::class, 'create'])->name('AcademicTerms.create');
        $router->post('/create-multiple', [AcademicTermsController::class, 'createMultiple'])->name('AcademicTerms.create');
        $router->post('/update/{id}', [AcademicTermsController::class, 'update'])->name('AcademicTerms.update');
        $router->post('/delete/{id}', [AcademicTermsController::class, 'delete'])->name('AcademicTerms.delete');
        $router->post('/import', [AcademicTermsController::class, 'imports'])->name('AcademicTerms.import');
        $router->post('/update-leads-to-academic/{id}', [AcademicTermsController::class, 'update_leads_to_academic'])->name('AcademicTerms.update_leads_to_academic');
    });

    // Route::group([
    //     'middleware'    => 'api',
    //     'prefix'        => 'academy-list'
    // ], function ($router) {
    //     $router->get('/', [AcademyListController::class, 'index'])->name('AcademyList.data');
    //     $router->post('/create', [AcademyListController::class, 'create'])->name('AcademyList.create');
    //     // $router->post('/create-multiple', [AcademyListController::class, 'createMultiple'])->name('AcademyList.create');
    //     $router->post('/update/{id}', [AcademyListController::class, 'update'])->name('AcademyList.update');
    //     $router->post('/delete/{id}', [AcademyListController::class, 'delete'])->name('AcademyList.delete');
    //     // $router->post('/import', [AcademyListController::class, 'imports'])->name('AcademyList.import');
    //     // $router->post('/update-leads-to-academic/{id}', [AcademyListController::class, 'update_leads_to_academic'])->name('AcademyList.update_leads_to_academic');
    // });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'dashboard'
    ], function ($router) {
        //Lấy tất cả
        $router->post('/new-leads', [DashboardController::class, 'report_new_leads'])->name('dashboard.new_leads');
        $router->post('/profile-success', [DashboardController::class, 'report_profile_success'])->name('dashboard.profile_success');
        $router->post('/students', [DashboardController::class, 'report_to_students'])->name('dashboard.students');
        $router->post('/total-leads', [DashboardController::class, 'report_total_leads'])->name('dashboard.total_leads');
        $router->post('/rate-converts', [DashboardController::class, 'rate_converts'])->name('dashboard.rate_converts');
        $router->post('/report-total-by-status', [DashboardController::class, 'report_by_status'])->name('dashboard.report_by_status');
        $router->post('/report-total-by-marjors', [DashboardController::class, 'report_price_by_marjors'])->name('dashboard.report_by_marjors');
        $router->post('/report-total-price-by-sources', [DashboardController::class, 'report_total_price_by_sources'])->name('dashboard.report_by_sources');
        $router->post('/report-quantity-leads-by-date', [DashboardController::class, 'report_quantity_leads_by_date'])->name('dashboard.report_quantity_leads_by_date');
        $router->post('/report-rate-leads-for-marjors', [DashboardController::class, 'report_rate_leads_for_marjors'])->name('dashboard.report_rate_leads_for_marjors');
        $router->post('/report-rate-leads-for-status', [DashboardController::class, 'report_rate_leads_for_status'])->name('dashboard.report_rate_leads_for_status');
        $router->get('/get-data-new-leads', [DashboardController::class, 'get_list_new_leads'])->name('dashboard.list_new_leads');

        //TTA
        $router->post('/statistical-overview', [DashboardController::class, 'statistical_overview'])->name('dashboard.statistical_overview');
    });

    Route::group([
        'middleware'    => 'api',
        'prefix'        => 'custom-field-imports'
    ], function ($router)
    {
        $router->get('/', [CustomFieldImportsController::class, 'index'])->name('customsFields.index');
        $router->get('/details/{id}', [CustomFieldImportsController::class, 'details'])->name('customsFields.data');
        $router->post('/create', [CustomFieldImportsController::class, 'create'])->name('customsFields.create');
        $router->post('/create-multiple', [CustomFieldImportsController::class, 'createMultiple'])->name('customsFields.create');
        $router->post('/update/{id}', [CustomFieldImportsController::class, 'update'])->name('customsFields.update');
        $router->post('/delete/{id}', [CustomFieldImportsController::class, 'delete'])->name('customsFields.delete');
        $router->post('/import', [CustomFieldImportsController::class, 'imports'])->name('customsFields.import');
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'semesters'
    ], function ($router) {
        $router->post('/', [SemestersController::class, 'index']);
        $router->get('/details/{id}', [SemestersController::class, 'details']);
        $router->post('/create', [SemestersController::class, 'create']);
        $router->post('/create-multiple', [SemestersController::class, 'createMultiple']);
        $router->post('/update/{id}', [SemestersController::class, 'update']);
        $router->post('/delete/{id}', [SemestersController::class, 'delete']);
        // Cấu hình
        $router->get('/config', [SemestersController::class, 'semesters_config']);
        $router->post('/config/update/{id}', [SemestersController::class, 'update_semesters_config']);
    });
    // Đơn vị liên kết
    Route::group([
        'middleware' => 'api',
        'prefix' => 'affiliate'
    ], function ($router) {
        $router->get('/data-transaction/{id}', [AffiliateController::class , 'get_data_transaction']);       
        $router->get('/details-semesters/{id}', [AffiliateController::class , 'details_semesters']);
        $router->post('/delete-semesters/{id}', [AffiliateController::class , 'delete_semesters']);               
        $router->post('/create-semesters', [ AffiliateController::class , 'create_semesters']);       
        $router->post('/update-semesters/{id}', [ AffiliateController::class , 'update_semesters']);       
        $router->post('/auto-create-semesters', [ AffiliateController::class , 'auto_create_semesters']);       
        $router->post('/imports-transactions', [ AffiliateController::class , 'imports_transactions']);     
        //Thông tin hoa hồng 
        $router->get('/data-commission-for-affiliate/{id}', [AffiliateController::class , 'get_data_commission_for_affiliate']);       
        // Xuất file
        // $router->post('/export-overview', [ AffiliateController::class , 'export_overview']);
        $router->get('/export-overview', [ AffiliateController::class , 'export_overview']);
        $router->post('/export-details/{id}', [ AffiliateController::class , 'export_details']);
    });

    Route::prefix('config-filter')->group(function ($router) {
        $router->get('/', [FilterController::class, 'index']);
        $router->get('/details/{id}', [FilterController::class, 'details']);
        $router->post('/create', [FilterController::class, 'create']);        
        $router->post('/update/{id}', [FilterController::class, 'update']);
        $router->post('/delete/{id}', [FilterController::class, 'delete']);
    });

    Route::prefix('voip24h')->group(function ($router) {
        $router->get('/', [Voip24hController::class, 'index']);
        // $router->get('/details/{id}', [Voip24hController::class, 'details']);
        $router->post('/create', [Voip24hController::class, 'create']);        
        $router->post('/update/{id}', [Voip24hController::class, 'update']);
        $router->post('/delete/{id}', [Voip24hController::class, 'delete']);
    });

});

