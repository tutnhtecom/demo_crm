<?php

namespace App\Services\Affiliate;

use App\Exports\AffiliatesExports;
use App\Exports\AffiliatesExportsDetails;
use App\Imports\AffiliateImports;
use App\Imports\AffiliatesImports;
use App\Jobs\AutoCreateSemestersJob;
use App\Models\AcademyList;
use App\Models\DVLKSemesters;
use App\Models\DVLKStudents;
use App\Models\DVLKTransactions;
use App\Models\Sources;
use App\Models\SourcesDocuments;
use App\Repositories\ApiListsRepository;
use App\Repositories\DVLKSemestersRepository;
use App\Repositories\DVLKStudentsRepository;
use App\Repositories\DVLKTransactionsRepository;
use App\Services\Affiliate\AffiliateInterface;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AffiliateServices implements AffiliateInterface
{
    use General;
    protected $dVLKStudentsRepository;
    protected $dVLKSemestersRepository;
    protected $dVLKTransactionsRepository;
    public function __construct(
        DVLKStudentsRepository $dVLKStudentsRepository, 
        DVLKSemestersRepository $dVLKSemestersRepository, 
        DVLKTransactionsRepository $dVLKTransactionsRepository
    )
    {
        $this->dVLKStudentsRepository       = $dVLKStudentsRepository;
        $this->dVLKSemestersRepository      = $dVLKSemestersRepository;
        $this->dVLKTransactionsRepository   = $dVLKTransactionsRepository;
    }  
    // Hiển thị danh sách sinh viên đóng tiền
    //--------------------------------------------------------------------------------------------------------  
    // Ban cu
    public function filter($params){       
        $model = $this->dVLKSemestersRepository->where('types', 0);
        if(isset($params['keyword'])){
            $model = $model->where('name', '%' . $params['keyword'] . '%', 'LIKE');                           
        }
        $model = $model->orderBy('id', 'desc');
        return $model ?? null;
    }
    private function get_sources_name($id) {        
        return $this->get_data_by_output('sources', ["id" => $id], "name");
    }
    public function data_semesters($params, $id = null){        
        $model          = $this->filter($params, $id)->get();   
        // $model = DVLKSemesters::where('types', 0)->get();
        $result = null;
        if(isset($model) && count($model) > 0) {
            $result = [
                "code"      => 200,
                "message"   => "Tải dữ liệu thành công",
                "data"      => $model,                
            ];
        } else {
            $result = [
                "code"      => 200,
                "message"   => "Không tìm thấy bản ghi trên hệ thống",                
            ];
        }        
        return $result;
    }    
    //-----------------------------------------------------------------------------------------------------------------
    // mới
    private function get_semesters_id() {
        $list_semesters = DVLKTransactions::with('dvlk_semesters')
                        ->groupBy('semesters_id')
                        ->select('semesters_id')
                        ->get()
                        ->pluck('dvlk_semesters.semesters_full_year', 'semesters_id')
                        ->toArray();        
        $data = [];
        if(isset($list_semesters ) && count($list_semesters ) >= 0) {
            foreach ($list_semesters as $key => $value) {
                if(!in_array($value, $data)) $data[] = $value;
            }
        }
        return $data;
    }
    private function get_data_list_students_id($id){
        $list_students_id = $this->dVLKStudentsRepository->where('students_sources_id', $id)->orderBy('id', 'desc')->get()->pluck("id")->toArray();
        return $list_students_id;
    }   
    private function get_data_general($id) {
        $list_students_id = $this->get_data_list_students_id($id);        
        $semesters_full_year = $this->get_semesters_id($id);        
        $model = $this->dVLKTransactionsRepository
                ->with(['dvlk_students', 'dvlk_semesters'])
                ->whereIn('students_id', $list_students_id)                
                ->orderBy('students_id', 'desc')
                ->get()->toArray();         
        return $model;      
    }
    public function get_data_transaction($params, $id){                      
        // Danh sach sinh viên theo ĐVLK
        $model = $this->get_data_general($id);          
        $data = [];
        $s_full_year = [];
        foreach ($model as $key => $item) {        
            $semesters_full_year = isset($item["dvlk_semesters"]["semesters_full_year"]) ? $item["dvlk_semesters"]["semesters_full_year"] : ($item["dvlk_semesters"]["semesters_from_year"] . '-' . $item["dvlk_semesters"]["semesters_to_year"]);               
            if(!in_array($semesters_full_year, $s_full_year)) $s_full_year[] = $semesters_full_year;
            $data[$item["students_id"]][$semesters_full_year ]["students_code"] = $item["dvlk_students"]["students_code"];
            $data[$item["students_id"]][$semesters_full_year ]["students_name"] = $item["dvlk_students"]["students_name"];
            $data[$item["students_id"]][$semesters_full_year ]["students_status"] = $item["dvlk_students"]["students_status"];
            $data[$item["students_id"]][$semesters_full_year ]["students_academy"] = $item["dvlk_students"]["students_academy"];
            $data[$item["students_id"]][$semesters_full_year ]["students_majors"] = $item["dvlk_students"]["students_majors"];
            $data[$item["students_id"]][$semesters_full_year ]["students_sources"] = $item["dvlk_students"]["students_sources"];
            $data[$item["students_id"]][$semesters_full_year ]["students_sources_id"] = $item["dvlk_students"]["students_sources_id"];
            $data[$item["students_id"]][$semesters_full_year ]["semesters_full_year"] = $semesters_full_year ;
            $data[$item["students_id"]][$semesters_full_year ][$item["dvlk_semesters"]["semesters_name"]] = isset($item["tran_price"]) ? number_format($item["tran_price"], 0, ',', '.') : 0;        
            $data[$item["students_id"]][$semesters_full_year ]["price"] = isset($item["tran_price"]) ? number_format($item["tran_price"], 0, ',', '.') : 0;        
        }
        $sources_name       = $this->get_sources_name($id);             
        $result = null;
        if(isset($data) && count($data) > 0) {
            $result = [
                "code"              => 200,
                "message"           => "Tải dữ liệu thành công",
                "data"              => $data,
                "sources_name"      => $sources_name ?? '',                
            ];
        } else {
            $result = [
                "code"      => 200,
                "message"   => "Không tìm thấy bản ghi trên hệ thống",                
            ];
        }
        return $result;
    }
    //-----------------------------------------------------------------------------------------------------------------
    public function details_semesters($id){
        $model = $this->dVLKSemestersRepository->where('id', $id)->first();        
        $result = null;
        if(isset($model->id)){
            $result = [
                "code"        => 200,
                "message"     => "Tải dữ liệu thành công"  ,
                "data"        => $model
            ];
        } else {
            $result = [
                "code"        => 422,
                "message"     => "Không tìm thấy bản ghi"  ,                
            ];
        }
        return $result;
    } 
    public function delete_semesters($id){        
        $result = null;
        $dem =  $this->dVLKSemestersRepository->where('id', $id, '=')->count();        
        if($dem <= 0) {
            return [
                "code"      => 422,
                "message"   => "Không tìm thấy bản ghi này",
            ];
        }
        $model = $this->dVLKSemestersRepository->updateById($id, [
            "deleted_at"    =>  Carbon::now(),
            "deleted_by"    =>  Auth::user()->id
        ]);
        if($model){
            $result = [
                "code"      => 200,
                "message"   => "Xóa bỏ thông tin thành công",                
            ];
        } else {
            $result = [
                "code"      => 422,
                "message"   => "Xóa bỏ thông tin không thành công",
            ];
        }
        return $result;
    }
    private function get_academy_name($id, $output) {
        $model = AcademyList::where('id', $id)->first();
        return $model->$output ?? null;
    }
    private function get_data_semesters_full_year($params){
        $academy_name   = $this->get_academy_name($params["academy_id"], "name");
        $data = [];
        $semesters_full_name = [];
        $semesters_from_year = [];
        $semesters_to_year   = [];
        $semesters_full_year = [];
        switch ($params["academy_id"]) {
            case '1':
                $semesters_full_name    = $academy_name . " năm " .  $params["semesters_year"] . " nhập học vào " . DVLKSemesters::SEMESTERS_NAME_MAP[$params["academy_id"]] . " năm học " . ( $params["semesters_year"] - 1) . '-' .  $params["semesters_year"]; 
                $semesters_from_year    = $params["semesters_year"] - 1;
                $semesters_to_year      = $params["semesters_year"];
                $semesters_full_year    = ($params["semesters_year"] - 1) . '-' .  $params["semesters_year"];
                break;
            case '2':
                $semesters_full_name  = $academy_name . " năm " .  $params["semesters_year"] . " nhập học vào " . DVLKSemesters::SEMESTERS_NAME_MAP[$params["academy_id"]] . " năm học " . ( $params["semesters_year"] - 1) . '-' .  $params["semesters_year"]; 
                $semesters_from_year = $params["semesters_year"] - 1;
                $semesters_to_year = $params["semesters_year"];
                $semesters_full_year = ($params["semesters_year"] - 1) . '-' .  $params["semesters_year"];
                break;
            case '3':
                $semesters_full_name  = $academy_name . " năm " .  $params["semesters_year"] . " nhập học vào " . DVLKSemesters::SEMESTERS_NAME_MAP[$params["academy_id"]] . " năm học " . $params["semesters_year"] . '-' .  ($params["semesters_year"] + 1); 
                $semesters_from_year = $params["semesters_year"];
                $semesters_to_year = $params["semesters_year"] + 1;
                $semesters_full_year = $params["semesters_year"] . '-' .  ($params["semesters_year"] + 1);
                break;
            case '4':
                $semesters_full_name  = $academy_name . " năm " .  $params["semesters_year"] . " nhập học vào " . DVLKSemesters::SEMESTERS_NAME_MAP[$params["academy_id"]] . " năm học " .  $params["semesters_year"] . '-' .  ($params["semesters_year"] + 1); 
                $semesters_from_year = $params["semesters_year"];
                $semesters_to_year = $params["semesters_year"] + 1;
                $semesters_full_year = $params["semesters_year"] . '-' .  ($params["semesters_year"] + 1);
                break;            
        }

        return [
            "semesters_full_name"   => $semesters_full_name,
            "semesters_from_year"   => $semesters_from_year,
            "semesters_to_year"     => $semesters_to_year,
            "semesters_full_year"   => $semesters_full_year
        ];
    }
    private function get_semesters_full_name($params) {        
        return $this->get_data_semesters_full_year($params);       
    }
    public function create_semesters($params){
        try {
            DB::beginTransaction();            
            $semesters = $this->get_semesters_full_name($params);
            $data = [
                "academy_id"            => $params["academy_id"],
                "semesters_name"        => $params["semesters_name"],
                "note"                  => $semesters["semesters_full_name"],
                "semesters_from_year"   => $semesters["semesters_from_year"],
                "semesters_to_year"     => $semesters["semesters_to_year"],
                "semesters_full_year"   => $semesters["semesters_full_year"],
                "admission_date"        => Carbon::createFromFormat("d/m/Y", $params["admission_date"])->format('Y-m-d'),
                "created_by"            => Auth::user()->id,
                "types"                 => $params["types"] ?? 0,
            ];                  
            $model = $this->dVLKSemestersRepository->create($data);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code"      => 200,
                    "message"   => "Tạo học kỳ thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Tạo học kỳ không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function update_semesters($params, $id){
        try {
            DB::beginTransaction();            
            if(isset($params["admission_date"])) {
                $params["admission_date"] = Carbon::createFromFormat("d/m/Y", $params["admission_date"])->format('Y-m-d');
            }             
            $semesters = $this->get_semesters_full_name($params);                 
            $data = [
                "academy_id"            => $params["academy_id"],
                "semesters_name"        => $params["semesters_name"],
                "note"                  => $semesters["semesters_full_name"],
                "semesters_from_year"   => $semesters["semesters_from_year"],
                "semesters_to_year"     => $semesters["semesters_to_year"],
                "semesters_full_year"   => $semesters["semesters_full_year"],
                "admission_date"        => $params["admission_date"],
                "updated_by"            => Auth::user()->id,                
            ];                        
            $model = $this->dVLKSemestersRepository->updateById($id, $data);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật học kỳ thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Cập nhật học kỳ không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    private function get_current_year(){
        $current_year   = (int)Carbon::now()->format('Y');
        $list_year = DVLKSemesters::where('types' , 1)->orderBy('id')->get()->pluck('semesters_from_year')->toArray();        
        if(count($list_year) <= 0) {
            return  $current_year;          
        } else {
            if(in_array($current_year, $list_year)){                
                while (in_array($current_year, $list_year) == true) {
                    $current_year = $current_year + 1; 
                }
            }
        }
        return $current_year;
    }
    public function auto_create_semesters(){
       try {            
            DB::beginTransaction();
            $current_year   = $this->get_current_year();            
            $max_next_year = $current_year + 20;            
            $semesters_name = DVLKSemesters::SEMESTERS_NAME;
            $data = [];
            for ($i=$current_year; $i <= $max_next_year ; $i++) { 
                foreach ($semesters_name as $key => $value) {
                    $data[] = [
                        "semesters_name"        => $value,    
                        "semesters_from_year"   => $i,
                        "semesters_to_year"     => $i + 1,
                        "semesters_full_year"   => $i . '-' . ($i+1),
                        "note"                  => $value . ' năm học ' . ($i .'-'.($i+1)),
                        "created_by"            => Auth::user()->id,
                        "created_at"            => Carbon::now(),
                        "types"                 => 1,
                    ];
                }
            }            
            $result = null;            
            $model = DVLKSemesters::insert($data);
            if($model) {
                $result = [
                    "code"      => 200,
                    "message"   => "Tự động thêm mới học kỳ thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Tự động thêm mới học kỳ không thành công"
                ];
            }
            DB::commit();
            return $result;
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    // import học phí cho sinh viên
    public function imports_transactions($params){
        try {            
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new AffiliatesImports($params['semesters_id']), $params['file']);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures   = $e->failures();           
            $errors     =   []; 
            foreach ($failures as $failure) {
                $errors[] = [
                    'row' => $failure->row(), // Row number where error occurred
                    'attribute' => $failure->attribute(), // Column name
                    'errors' => $failure->errors(), // Validation error messages
                    'values' => $failure->values(), // The entire row values
                ];
            }
            DB::rollBack();
            return response()->json(['errors' => $errors]);            
        }
    }
    // Hiển thị thông tin hoa hồng
    // --------------------------------------------------------   
    private function get_data_sources_rate($sources_id, $year, $quantity, $semesters_id){         
        $s_documents    = SourcesDocuments::with(['sources_rate'])
                        ->where('sources_id', $sources_id)
                        ->whereYear('signed_from_date', $year)
                        ->first(); 
        $data = null;
        if(isset($s_documents->id)) {
            $s_rate = $s_documents["sources_rate"]->toArray();
            if(is_array($s_rate) && count($s_rate) > 0)            
            foreach ($s_rate as $value) {
                if($value["semesters_id"] == $semesters_id){
                    if($quantity < $value["payment_condition"] && $value["math_sign"] == "<"){
                        $data = $value;
                    } elseif($quantity >= $value["payment_condition"] && $value["math_sign"] == ">="){
                        $data = $value;
                    }
                    
                }
            }
        }        
        return $data;
    }
    public function get_data_commission_for_affiliate($params, $id){
        $list_students_id = $this->get_data_list_students_id($id);       
        $model =    DVLKTransactions::with(['dvlk_semesters', 'dvlk_students'])
                    ->whereIn('students_id', $list_students_id)
                    ->select('semesters_id', 'tran_academy',
                    DB::raw('COUNT(DISTINCT students_id) as total_quantity'),
                    DB::raw('SUM(tran_price) as total_price'))
                    ->groupBy('students_id')
                    ->groupBy('semesters_id')
                    ->groupBy('tran_academy')
                    ->get()->toArray();           
        $data = [];
        if(isset($model) && count($model) > 0) {
            foreach ($model as $key => $value) {                    
                $sources_rate               = $this->get_data_sources_rate($id,$value["dvlk_semesters"]["semesters_from_year"],$value["total_quantity"],$value["semesters_id"] );  
                $payment_manager_price      = isset($sources_rate["payment_manager_price"]) ? $sources_rate["payment_manager_price"] : 0;
                $total_quantity             = $value["total_quantity"] ?? 0;
                $total_price                = $value["total_price"] ?? 0;                
                $payment_for_manager        = $payment_manager_price * $total_quantity;                
                $payment_for_sources        = (($sources_rate["payment_rate"] ?? 0) * $total_price)/100 -  $payment_for_manager;                
                $payment_5_for_price_lists  = (($sources_rate["payment_manager_rate"] ?? 0) * $total_price) / 100;    
                $semesters_full_year = isset($value["dvlk_semesters"]["semesters_full_year"]) ? $value["dvlk_semesters"]["semesters_full_year"] : ($value["dvlk_semesters"]["semesters_from_year"] . '-' . $value["dvlk_semesters"]["semesters_to_year"]);                
                $data[$semesters_full_year][] = [
                    "tran_academy"                    => $value["tran_academy"],
                    "total_quantity"                  => $total_quantity ?? 0,
                    "total_price"                     => $total_price ?? 0,
                    "payment_rate"                    => $sources_rate["payment_rate"] ?? null,
                    "payment_manager_rate"            => $sources_rate["payment_manager_rate"] ?? null,
                    "expense_name"                    => $sources_rate["expense_name"] ?? null,
                    "payment_note"                    => $sources_rate["payment_note"] ?? null,
                    "payment_condition"               => $sources_rate["payment_condition"] ?? 0,
                    "payment_terms_note"              => $sources_rate["payment_terms_note"] ?? 'sv/khoa',
                    "payment_manager_price"           => number_format($payment_manager_price, 0, ',', '.') , 
                    "payment_for_manager"             => number_format($payment_for_manager, 0, ',', '.'),     
                    "payment_for_sources"             => number_format($payment_for_sources, 0, ',', '.'),     
                    "payment_5_for_price_lists"       => number_format($payment_5_for_price_lists, 0, ',', '.'),
                    "semesters_name"                  => $value["dvlk_semesters"]["semesters_name"] ?? null,
                ];             
            }
        }         
        return $data;
    }
    public function export_overview($params){
        try {                   
            $data = Sources::with(["leads"])->orderBy('id', 'desc')->whereNotNull('code')->get();              
            $file_name = "danh_sach_tong_quan_don_vi_lien_ket" . date('d-m-Y') . '.xlsx';            
            return Excel::download(new AffiliatesExports($data), $file_name);
            // return Excel::download(new LeadsExports, $file_name);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }

    private function get_new_data_transactions($id){
        $data = DVLKTransactions::with(["dvlk_students" => function ($q) use($id){
            $q->where('students_sources_id', $id);
        }])->select('students_id', 'tran_academy', 'semesters_id', DB::raw('SUM(tran_price) as tran_price'))
        ->groupBy('students_id', 'tran_academy', 'semesters_id')
        ->get()->toArray();
        // dd($data);
        $groupedData = collect($data)->groupBy(function ($item) {            
            return $item['students_id'] . '-' . $item['tran_academy'];
        })->map(function ($items) {
            $firstItem = $items->first();            
            return [
                'students_id'   => $firstItem["students_id"],                
                'tran_academy'  => $firstItem['tran_academy'],                
                'semesters' => $items->map(function ($item) {
                    return [
                        'semesters_id' => $item['semesters_id'],
                        'tran_price' => $item['tran_price'],
                    ];
                })->values()->toArray() 
            ];
        });
        return $groupedData->values()->toArray() ?? null;
    }
    private function get_data_students($id){
        $model = DVLKStudents::where("id", $id)->first();
        return [
            "students_name"         => $model->students_name ?? '',
            "students_academy"      => $model->students_academy ?? '',
            "students_code"         => $model->students_code ?? '',
            "students_majors"       => $model->students_majors ?? '',
            "students_sources"      => $model->students_sources ?? '',
        ];
    }
    private function get_data_semesters($id) {       
      
        $model = DVLKSemesters::where('id', $id)->where("types", 1)->first();        
        return [
            "semesters_name"            => $model->semesters_name ?? '',
            "semesters_from_year"       => $model->semesters_from_year ?? '',
            "semesters_to_year"         => $model->semesters_to_year ?? '',
            "semesters_full_year"       => $model->semesters_full_year ?? '',
            "admission_date"            => $model->admission_date ?? '',
        ];
    }
    private function get_semesters_name($semesters){
        $data = [];
        $config_semesters = config("data.affiliate.semesters");    
        foreach ($semesters as $s) {
            $semesters = $this->get_data_semesters($s["semesters_id"]);            
            $data[$semesters["semesters_name"]] = $s["tran_price"] ?? '';            
        }        
        foreach ($config_semesters as $v) {
            if(!isset($data[$v])) {
                $data[$v] = 0;
            }
        }        
        return $data;
    }
    public function export_details($id){        
        try {                   
            $transactions = $this->get_new_data_transactions($id);                   
            $data = [];
            foreach ($transactions as $item) {
                $students = $this->get_data_students($item["students_id"]);
                $items = [
                    $students["students_name"] ?? '',
                    $students["students_academy"] ?? '',
                    $students["students_majors"] ?? '',
                    $students["students_code"] ?? '',
                    $students["students_sources"] ?? ''
                ];  
                $sem = $this->get_semesters_name($item["semesters"]);           
                foreach ($sem as $value) {
                    $items[] = $value;
                }
                $data[] = $items;
            }      
                  
            // $data = $this->get_data_transaction($id);
            // $this->get_data($data["data"]);
            $params["heading_1"]        = $data["sources_name"] ?? '';
            $params["heading_2"]        = config("data.affiliate.title_price_lists");
            $headings                   = config("data.affiliate.headings");
            $semesters                  = config("data.affiliate.semesters");            
            $s_full_year                = $data["s_ful_lyear"] ?? '';  
            $heading_4 = [];
            $heading_3 = [];                     
            foreach ($headings as $key => $item) {
                $heading_4 [] = $item;
                $heading_3[] = '';
                if($key == 3 && isset($semesters)) {
                    foreach ($s_full_year as $v) {
                        $heading_3[] = $v;
                        foreach ($semesters as $s) {
                            $heading_4[] = $s;
                        }
                    }
                }
            }
            
            $params["heading_3"] = $heading_3;
            $params["heading_4"] = $heading_4;
            // dd($params);
            // $params["data"]             = $data["data"];
            $list = [];            
            foreach ($data["data"] as $l_key=> $data) {
                
                // $l_key là id sinh viên                
                foreach ($data as $s_key => $d) {
                    // dd($d);
                    // s_key là khóa học                    
                    $list[$s_key][] = [
                        $d["students_name"], $d["students_academy"], $d["students_majors"], $d["students_code"], $d["price"]
                    ];
                }
                  
            }

            // dd($list);         
            
            
            // dd($params);
            // $data = SourcesDocuments::with(['sources'])->where('sources_id', $id)->get()->toArray();
            // dd($data);
            $data = null;
            // // $data = Sources::with(["leads"])->whereNotNull('code')->get();            
            $file_name = "danh_sach_tong_quan_don_vi_lien_ket" . date('d-m-Y') . '.xlsx';            
            
            return Excel::download(new AffiliatesExportsDetails($data), $file_name);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
}


    