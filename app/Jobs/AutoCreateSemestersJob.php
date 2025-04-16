<?php

namespace App\Jobs;

use App\Models\DVLKSemesters;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AutoCreateSemestersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private function check_year($current_year){
        $dem = DVLKSemesters::where('semesters_from_year', $current_year)->count();
        if($dem > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function handle(): void
    {   
        $current_year   = (int)Carbon::now()->format('Y');                
        $max_next_year = $current_year + 20;            
        $semesters_name = DVLKSemesters::SEMESTERS_NAME;
        $data = [];
        for ($i=$current_year; $i <= $max_next_year ; $i++) { 
            foreach ($semesters_name as $key => $value) {
                $data[] = [
                    "semesters_name"        => $value,    
                    "semesters_from_year"   => $i,
                    "semesters_to_year"     => $i + 1,
                    "note"                  => $value . ' năm học ' . ($i .'-'.($i+1)),
                    "created_by"            => Auth::user()->id ?? 1,
                    "created_at"            => Carbon::now(),
                    "types"                 => 1,
                ];
            }
        }        
        DVLKSemesters::insert($data);  
    }
}
