<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

use App\Services\AcademicTerms\AcademicTermsInterface;
use App\Services\AcademicTerms\AcademicTermsServices;
use App\Services\AcademyList\AcademyListInterface;
use App\Services\AcademyList\AcademyListServices;
use App\Services\Affiliate\AffiliateInterface;
use App\Services\Affiliate\AffiliateServices;
use App\Services\ApiLists\ApiListsInterface;
use App\Services\ApiLists\ApiListsServices;
use App\Services\Authentication\AuthInterface;
use App\Services\Authentication\AuthServices;
use App\Services\BlockAdminssions\BlockAdminssionsInterface;
use App\Services\BlockAdminssions\BlockAdminssionsServices;
use App\Services\ConfigFilters\ConfigFilterInterface;
use App\Services\ConfigFilters\ConfigFilterServices;
use App\Services\ConfigGeneral\ConfigGeneralServices;
use App\Services\ConfigGeneral\ConfigGeneralsInterface;
use App\Services\CustomFieldImports\CustomFieldImportsInterface;
use App\Services\CustomFieldImports\CustomFieldImportsServices;
use App\Services\Dashboard\DashboardInterface;
use App\Services\Dashboard\DashboardServices;
use App\Services\EducationsTypes\EducationsTypesInterface;
use App\Services\EducationsTypes\EducationsTypesServices;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use App\Services\EmailTemplates\EmailTemplatesServices;
use App\Services\EmailTemplateTypes\EmailTemplateTypesInterface;
use App\Services\EmailTemplateTypes\EmailTemplateTypesServices;
use App\Services\Employees\EmployeesInterface;
use App\Services\Employees\EmployeesServices;
use App\Services\FormAdminssions\FormAdminssionsInterface;
use App\Services\FormAdminssions\FormAdminssionsServices;
use App\Services\Kpis\KpisInterface;
use App\Services\Kpis\KpisServices;
use App\Services\Leads\LeadsInterface;
use App\Services\Leads\LeadsServices;
use App\Services\Marjors\MarjorsInterface;
use App\Services\Marjors\MarjorsServices;
use App\Services\MethodAdminssions\MethodAdminssionsInterface;
use App\Services\MethodAdminssions\MethodAdminssionsServices;
use App\Services\Nations\NationsInterface;
use App\Services\Nations\NationsServices;
use App\Services\Notifications\NotificationsInterface;
use App\Services\Notifications\NotificationsServices;
use App\Services\NotificationsGroups\NotificationsGroupsInterface;
use App\Services\NotificationsGroups\NotificationsGroupsServices;
use App\Services\Permissions\PermissionsInterface;
use App\Services\Permissions\PermissionsServices;
use App\Services\PriceLists\PriceListsInterface;
use App\Services\PriceLists\PriceListsServices;
use App\Services\Roles\RolesInterface;
use App\Services\Roles\RolesServices;
use App\Services\RolesPermissions\RolesPermissionsInterface;
use App\Services\RolesPermissions\RolesPermissionsServices;
use App\Services\ScoreAdminssions\ScoreAdminssionsInterface;
use App\Services\ScoreAdminssions\ScoreAdminssionsServices;
use App\Services\Semesters\SemestersInterface;
use App\Services\Semesters\SemestersServices;
use App\Services\Sources\SourcesInterface;
use App\Services\Sources\SourcesServices;
use App\Services\Status\StatusInterface;
use App\Services\Status\StatusServices;
use App\Services\Students\StudentsInterface;
use App\Services\Students\StudentsServices;
use App\Services\Supports\SupportsInterface;
use App\Services\Supports\SupportsServices;
use App\Services\SupportsStatus\SupportsStatusInterface;
use App\Services\SupportsStatus\SupportsStatusServices;
use App\Services\Tags\TagsInterface;
use App\Services\Tags\TagsServices;
use App\Services\Tasks\TasksInterface;
use App\Services\Tasks\TasksServices;
use App\Services\Transactions\TransactionsInterface;
use App\Services\Transactions\TransactionsServices;
use App\Services\TransactionStatus\TransactionStatusInterface;
use App\Services\TransactionStatus\TransactionStatusServices;
use App\Services\TransactionTypes\TransactionTypesInterface;
use App\Services\TransactionTypes\TransactionTypesServices;
use App\Services\Voip24h\Voip24hInterface;
use App\Services\Voip24h\Voip24hServices;

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
$app->singleton(AuthInterface::class, AuthServices::class);
$app->singleton(SourcesInterface::class, SourcesServices::class);
$app->singleton(MarjorsInterface::class, MarjorsServices::class);
$app->singleton(TagsInterface::class, TagsServices::class);
$app->singleton(StatusInterface::class, StatusServices::class);
$app->singleton(LeadsInterface::class, LeadsServices::class);
$app->singleton(EducationsTypesInterface::class, EducationsTypesServices::class);
$app->singleton(MethodAdminssionsInterface::class, MethodAdminssionsServices::class);
$app->singleton(FormAdminssionsInterface::class, FormAdminssionsServices::class);
$app->singleton(BlockAdminssionsInterface::class, BlockAdminssionsServices::class);
$app->singleton(ScoreAdminssionsInterface::class, ScoreAdminssionsServices::class);
$app->singleton(SupportsInterface::class, SupportsServices::class);
$app->singleton(SupportsStatusInterface::class, SupportsStatusServices::class);
$app->singleton(EmployeesInterface::class, EmployeesServices::class);
$app->singleton(PriceListsInterface::class, PriceListsServices::class);
$app->singleton(TransactionsInterface::class, TransactionsServices::class);
$app->singleton(TransactionStatusInterface::class, TransactionStatusServices::class);
$app->singleton(TransactionTypesInterface::class, TransactionTypesServices::class);
$app->singleton(NotificationsInterface::class, NotificationsServices::class);
$app->singleton(NationsInterface::class, NationsServices::class);
$app->singleton(StudentsInterface::class, StudentsServices::class);
$app->singleton(RolesInterface::class, RolesServices::class);
$app->singleton(TasksInterface::class, TasksServices::class);
$app->singleton(KpisInterface::class, KpisServices::class);
$app->singleton(RolesPermissionsInterface::class, RolesPermissionsServices::class);
$app->singleton(PermissionsInterface::class, PermissionsServices::class);
$app->singleton(ApiListsInterface::class, ApiListsServices::class);
$app->singleton(EmailTemplateTypesInterface::class, EmailTemplateTypesServices::class);
$app->singleton(EmailTemplatesInterface::class, EmailTemplatesServices::class);
$app->singleton(DashboardInterface::class, DashboardServices::class);
$app->singleton(NotificationsGroupsInterface::class, NotificationsGroupsServices::class);
$app->singleton(AcademicTermsInterface::class, AcademicTermsServices::class);
$app->singleton(CustomFieldImportsInterface::class, CustomFieldImportsServices::class);
$app->singleton(SemestersInterface::class, SemestersServices::class);
$app->singleton(ConfigGeneralsInterface::class, ConfigGeneralServices::class);
$app->singleton(AcademyListInterface::class, AcademyListServices::class);
$app->singleton(AffiliateInterface::class, AffiliateServices::class);
$app->singleton(ConfigFilterInterface::class, ConfigFilterServices::class);
$app->singleton(Voip24hInterface::class, Voip24hServices::class);

/*$app->singleton(FormAdminssionsInterface::class, FormAdminssionsServices::class);
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;

