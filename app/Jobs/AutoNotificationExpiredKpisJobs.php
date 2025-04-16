<?php

namespace App\Jobs;

use App\Models\ConfigGeneral;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Kpis;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class   AutoNotificationExpiredKpisJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use General;

    public function handle(): void
    {
        // $this->kpis_interface->create_notification_kpis_expired();
        $this->create_notification_kpis_expired();
    }
    private function get_expired_date()
    {
        $config = ConfigGeneral::where('types', ConfigGeneral::TYPES_KPIS)->first();
        return $config;
    }
    private function get_file_name_by_email_template()
    {
        $title = 'Mẫu thông báo kpis';
        $model = EmailTemplates::where('types_id', EmailTemplateTypes::TYPE_KPIS)->where('is_default', 1)
            ->orwhere('title', 'like', '%' . $title . '%')
            ->orWhere('title', 'like', '%kpis%')
            ->first();
        $file_name = null;
        if (isset($model->file_name)) $file_name = 'includes.template.' . $model->file_name;
        else $file_name = 'includes.crm.mau_thong_bao_kpi_het_han';
        return $file_name;
    }
    public function create_notification_kpis_expired()
    {
        try {
            DB::beginTransaction();
            $file_name = $this->get_file_name_by_email_template(5);
            $config                 = $this->get_expired_date();
            $data_notification      = [];
            $kpis                   = Kpis::with(['employees'])->orderBy('employees_id', 'desc')
                ->whereMonth('to_date', Carbon::now()->format('m'))
                ->get()->toArray();
            $m_year_current         = Carbon::now()->format('m/Y');
            $title                  = "Hệ thống thông báo kỳ hạn thực hiện chỉ tiêu tuyển sinh";
            $data_sendmail          = null;

            if (count($kpis) > 0 && ($config["current_month"] == null ||  $config["current_month"] != $m_year_current)) {
                foreach ($kpis as $k) {
                    $kpis_this_year     =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('Y'); // Lấy năm
                    $kpis_this_month    =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('m'); // Lấy tháng
                    $kpis_this_day      =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('d'); // Lấy ngày                    
                    $expired_day        =  $kpis_this_day - Carbon::now()->format('d'); // Thời gian khóa  
                    $content            =  "Chỉ tiểu tuyển sinh tháng " . Carbon::now()->format('m') . "/" . Carbon::now()->format('Y') . " của bạn cần đạt: Tổng doanh thu: " . number_format($k["price"], 0, ',', '.') . " - Tổng sinh viên: " . $k["quantity"] . "/người hết hạn vào ngày " . $k["to_date"];
                    $email              =  $k["employees"]["email"] ?? null;                                   
                    if (($kpis_this_year == Carbon::now()->format('Y')) && ($kpis_this_month == Carbon::now()->format('m')) && ($expired_day <=  $config['end_date'])) {
                        $data_notification      = [
                            "email"             =>   $email,
                            "topic"             =>    $title,
                            "title"             =>    $title,
                            "content"           =>    $content,
                            "obj_types"         =>    2,
                            "send_types"        =>    2,
                            "status"            =>    1,
                            "is_open"           =>    0,
                            "created_at"        =>    Carbon::now(),
                            "created_by"        =>    Auth::user()->id ?? null
                        ];
                        CreateNotificationsJobs::dispatch($data_notification);
                        $data_sendmail = [
                            "title"         => $title,
                            'subject'       => $title,
                            "content"       => $content,
                            'to'            => $email,
                            'email'         => $email,
                        ];
                        SendMailJobs::dispatch($data_sendmail, $file_name);
                    }
                }
                // $data = [
                //     "current_month" => Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('m/Y')
                // ];
                // ConfigGeneral::where('types', ConfigGeneral::TYPES_KPIS)->update($data);
            }
            DB::commit();
            // AutoNotificationExpiredKpisJobs::dispatch();       
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
}
