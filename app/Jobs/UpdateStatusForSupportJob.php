<?php

namespace App\Jobs;

use App\Models\ConfigGeneral;
use App\Models\Supports;
use App\Models\SupportsStatus;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpdateStatusForSupportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function handle(): void
    {        
        $config = ConfigGeneral::where('types', ConfigGeneral::TYPES_SUPPORTS)->first()->toArray();        
        $model  = Supports::with(['employees'])->get()->toArray();                   
        foreach ($model as $item) {            
            $c_date = Carbon::now()->format('Y-m-d'); // date trong db
            $n_date = Carbon::parse($item['created_at'])->addDay($config['end_date'])->format('Y-m-d'); // date + n
            if($c_date > $n_date && strlen($item["answers"]) > 0 && $item['sp_status_id'] != SupportsStatus::STATUS_CLOSE) {                    
                $data = [
                    "sp_status_id"  => SupportsStatus::STATUS_CLOSE,
                    "created_by"    => Auth::user()->id ?? null,
                    "note"          => "Tự động đóng yêu cầu hỗ trợ do quá " . $config['end_date'] . " ngày so với Yêu cầu hỗ trợ được tạo",
                ];                                
                Supports::where('id', $item['id'])->update($data);
            }            
        }                   
    }
}
