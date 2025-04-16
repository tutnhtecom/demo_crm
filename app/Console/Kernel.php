<?php

namespace App\Console;

use App\Console\Commands\AutoCreateSemestersCommand;
use App\Console\Commands\AutoNotificationExpiredKpis;
use App\Console\Commands\CreateEmailTemplateBladeView;
use App\Console\Commands\KpisAutoStoreNextMonthCommands;
use App\Console\Commands\SendMailHappyBirtday;
use App\Console\Commands\TestScheduleCMD;
use App\Console\Commands\UpdateSupportStatusCMD;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{    
    protected function schedule(Schedule $schedule): void
    {        
        $schedule->command('happy:birthday')->dailyAt("09:00"); // Loi chuc sinh nhat se duoc gui vao luc 9:00
        $schedule->command('auto:kpis')->monthly();
        $schedule->command('auto:notification-kpis-expired')->dailyAt("21:15");
        $schedule->command('auto:create-semesters')->yearly();
        $schedule->command('auto:update_status_for_supports')->everyFiveMinutes();
        
    }
    protected $commands = [
        SendMailHappyBirtday::class,
        KpisAutoStoreNextMonthCommands::class,
        CreateEmailTemplateBladeView::class,
        AutoNotificationExpiredKpis::class,
        AutoCreateSemestersCommand::class,
        UpdateSupportStatusCMD::class
        // TestScheduleCMD::class
    ];
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');        
        require base_path('routes/console.php');
    }
}

