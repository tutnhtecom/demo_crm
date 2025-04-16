<?php

namespace App\Services\Sources;

use App\Imports\ReportSourcesImports;
use App\Imports\SourcesDocumentsImports;
use App\Imports\SourcesImports;
use App\Imports\SourcesPriceListsImports;
use App\Imports\SourcesRatesImports;
use App\Models\AcademicTerms;
use App\Models\DVLKSemesters;
use App\Models\DVLKStudents;
use App\Models\Semesters;
use App\Models\Sources;
use App\Models\SourcesDocuments;
use App\Models\SourcesPricesLists;
use App\Models\SourcesRates;
use App\Models\Students;
use App\Models\Transactions;
use App\Repositories\AcademicTermsRepository;
use App\Repositories\LeadsRepository;
use App\Repositories\SemestersRepository;
use App\Repositories\SourcesDocumentsRepositoy;
use App\Repositories\SourcesPricesListsRepositoy;
use App\Repositories\SourcesRateRepository;
use App\Repositories\SourcesRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\TransactionsRepository;
use App\Repositories\UserRepository;
use App\Services\Sources\SourcesInterface;
use App\Traits\General;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use function GuzzleHttp\json_decode;

class SourcesServices implements SourcesInterface{
    use General;
    protected $sources_repository;
    protected $sources_rate_repository;
    protected $ld_repository;
    protected $semesters_repository;
    protected $tran_repository;
    protected $academic_term_repository;
    protected $sources_documents_repository;
    protected $st_repository;
    protected $s_price_list_respository;

    public function __construct(
        StudentsRepository $st_repository,
        TransactionsRepository $tran_repository,
        SourcesRepository $sources_repository,
        SourcesRateRepository $sources_rate_repository,
        LeadsRepository $ld_repository,
        SemestersRepository $semesters_repository,
        AcademicTermsRepository $academic_term_repository,
        SourcesDocumentsRepositoy $sources_documents_repository,
        SourcesPricesListsRepositoy $s_price_list_respository
    )
    {
        $this->sources_repository = $sources_repository;
        $this->sources_rate_repository = $sources_rate_repository;
        $this->ld_repository = $ld_repository;
        $this->st_repository = $st_repository;
        $this->semesters_repository = $semesters_repository;
        $this->tran_repository = $tran_repository;
        $this->academic_term_repository = $academic_term_repository;
        $this->sources_documents_repository = $sources_documents_repository;
        $this->s_price_list_respository = $s_price_list_respository;
    }
    private function filter($params) {
        $model = $this->sources_repository->with(['sources_rate', 'leads', 'students']);
        if (isset($params['name'])) {
            $model = $model->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['sources_types'])) {
            $model = $model->where('sources_types', $params['sources_types']);
        }
        return $model;
    }
    public function index($params) {
        try {
            $model = $this->filter($params);
            $model = $model->orderBy('created_at', 'desc')->get()->toArray();
            if (count($model) > 0) {
                $result = [
                    "code" => 200,
                    "data" => $model
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Hệ thống chưa có bản ghi nào"
                ];
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json($e->getMessage());
        }
        return response()->json($result);
    }
    public function details($id) {
       try {
         $model = $this->sources_repository->with(['sources_documents.sources_rate.academic_terms', 'sources_documents.sources_rate.semesters'])->where('id', $id, '=')->first();
         if(isset($model->id)) {
            $result = [
                "code" => 200,
                "data" => $model
            ];
        } else {
            $result = [
                "code" => 422,
                "message" => "Hệ thống chưa có bản ghi nào"
            ];
        }
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }
       return response()->json($result);
    }
    public function create($params) {
        try {
            DB::beginTransaction();
            $code = !empty($params['location_name']) ? $this->get_code($params['location_name']) : null;            
            $data = [
                "sources_types" => $params["sources_types"] ?? null,
                "name" => $params["name"] ?? '' ,
                "code" => $code ,
                "sources_manager_name"   => isset($params["manager"]) ? json_encode( $params["manager"]) : null ,
                "sources_employees_name" => isset( $params["employees"])  ? json_encode($params["employees"]): null,
                "location_name" => $params["location_name"] ?? null ,
                "created_at" => Carbon::now()->format('Y-m-d'),
                "created_by" => Auth::user()->id ?? 1,
            ];
           
            $model = $this->sources_repository->create($data);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được thêm mới thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    private function check_status_create_sources_rate($params) {
        $status = false;
        $dem =  SourcesRates::where('sources_id', $params["sources_id"])
                ->where('sources_documents_id', $params["sources_documents_id"])
                ->where('academic_terms_id', $params["academic_terms_id"]);
        if(isset($params["semesters_id"])) {
            $dem = $dem->where('semesters_id', $params["semesters_id"]);
        }
        $dem = $dem->where('payment_condition', $params["payment_condition"])
                    ->where('math_sign', $params["math_sign"])
                    ->count();
        if($dem > 0) {
            $status = true;
        }        
        return $status;
    }
    private function create_multiple_semesters_in_sources_rate($params){        
        $model = null;
        if(!isset($params["academic_terms_id"])) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn niên khóa"
            ];
        }
        $data = [];
        $sources_rate_id = Semesters::where('academic_terms_id', $params["academic_terms_id"])->get()->pluck("id")->toArray();        
        $unit = "sv/ngành/khoa";
        $payment_terms_note = ($params["math_sign"] ?? null) .' '. ($params["payment_condition"] ?? null) .' '. ($unit ?? null);
        $payment_rate_note = ($params["payment_rate"] ?? 0) .'% ('. ($params["payment_manager_price"]  ?? 0) . ')';
        foreach ($sources_rate_id as $id) {
            $data[] = [
                "sources_id"            => $params["sources_id"] ?? null,
                "sources_documents_id"  => $params["sources_documents_id"] ?? null,
                "academic_terms_id"     => $params["academic_terms_id"] ?? null,
                "semesters_id"          => $id ?? null,
                "expense_name"          => $params["expense_name"] ?? null,
                "payment_condition"     => $params["payment_condition"] ?? null,
                "math_sign"             => $params["math_sign"] ?? null,
                "payment_terms_note"    => $payment_terms_note ?? null,
                "payment_note"          => $params["payment_note"] ?? null,
                "payment_rate"          => $params["payment_rate"] ?? 0,
                "payment_rate_note"     => $payment_rate_note ?? null,
                "payment_manager_rate"  => $params["payment_manager_rate"]  ?? 0,
                "payment_manager_price" => $params["payment_manager_price"]  ?? 0,
                "created_at"            => Carbon::now()->format('Y-m-d H:i:s'),
                "created_by"            => Auth::user()->id
            ];
        }
        $model = $this->sources_rate_repository->createMultiple($data);
        return $model;
    }
    private function create_single_semesters_in_sources_rate($params){                
        $payment_terms_note = $params["payment_units"];
        $payment_rate_note = ($params["payment_rate"] ?? 0) .'% ('. ($params["payment_manager_price"]  ?? 0) . ')';
        $data = [
            "sources_id"            => $params["sources_id"] ?? null,
            "sources_documents_id"  => $params["sources_documents_id"] ?? null,
            // "academic_terms_id"     => $params["academic_terms_id"] ?? null,
            "semesters_id"          => $params["semesters_id"] ?? null,
            "expense_name"          => $params["expense_name"] ?? null,
            "payment_condition"     => $params["payment_condition"] ?? null,
            "math_sign"             => $params["math_sign"] ?? null,
            "payment_terms_note"    => $payment_terms_note ?? null,
            "payment_note"          => $params["payment_note"] ?? null,
            "payment_rate"          => $params["payment_rate"] ?? 0,
            "payment_rate_note"     => $payment_rate_note ?? null,           
            "payment_manager_rate"  => $params["payment_manager_rate"]  ?? 0,
            "payment_manager_price" => $params["payment_manager_price"]  ?? 0,
            "created_at"            => Carbon::now(),
            "created_by"            => Auth::user()->id
        ];        
        $model = $this->sources_rate_repository->create($data);
        return $model;
    }
    private function get_academy_id($id){
        $academy = DVLKSemesters::where("id", $id )->first();
        return $academy->id ?? null;
    }
    public function create_sources_rate($params) {
        try {            
            
            DB::beginTransaction();
            if(!isset($params["sources_id"])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn đối tác cần thiết lập"
                ];
            }           
            $result = null;            
            $params["academic_terms_id"] = $this->get_academy_id($params["semesters_id"]);
            $status = $this->check_status_create_sources_rate($params);                
            if ($status) {
                return [
                    "code" => 422,
                    "message" => "Hợp đồng đã tồn tại khoản chi cho niên khoá và học kỳ này!"
                ];
            }
            
          
            $model = $this->create_single_semesters_in_sources_rate($params);                
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được thêm mới thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }           
            DB::commit();
            return response()->json($result);
           
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function create_sources_documents($params){
        try {
            DB::beginTransaction();
            if(!isset($params["sources_id"])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn đối tác cần thiết lập"
                ];
            }
            $max_id = $this->get_next_id('sources_documents');
            $code   = $this->get_prefix_from_name($params['signed_document']) . ($max_id <10 ? '0' . $max_id : $max_id);
            $data = [
                "code"                  => $code,
                "sources_id"            => $params["sources_id"] ?? null,
                "signed_from_date"      => isset($params["signed_from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_from_date"]))->format('Y-m-d') : null,
                "signed_to_date"        => isset($params["signed_to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_to_date"]))->format('Y-m-d') : null,
                "signed_content"        => $params["signed_content"] ?? null ,
                "signed_document"       => $params["signed_document"] ?? null,
            ];         
            $model = $this->sources_documents_repository->create($data);
            $result = null;
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được thêm mới thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function update($params, $id) {
        try {
            DB::beginTransaction();
            if(isset($params["sources_manager_name"])) {
                $params["sources_manager_name"] = json_encode($params["sources_manager_name"]);
            }
            if(isset($params["sources_employees_name"])) {
                $params["sources_employees_name"] = json_encode($params["sources_employees_name"]);
            }
            $params["signed_from_date"] = isset($params["signed_from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_from_date"]))->format('Y-m-d') : null;
            $params["signed_to_date"] = isset($params["signed_to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_to_date"]))->format('Y-m-d') : null;
            $params['updated_by'] = Auth::user()->id ?? null;

            $model = $this->sources_repository->updateById($id, $params);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được cập nhật thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu cập nhật thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }
    }
    public function update_sources_documents($params, $id) {
        try {
            DB::beginTransaction();
            $params["signed_from_date"] = isset($params["signed_from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_from_date"]))->format('Y-m-d') : null;
            $params["signed_to_date"]   = isset($params["signed_to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["signed_to_date"]))->format('Y-m-d') : null;
            $model = $this->sources_documents_repository->updateById($id, $params);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được cập nhật thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu cập nhật thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
       }
    }
    public function update_sources_rate($params, $id) {        
        try {
            DB::beginTransaction();
            $model = $this->sources_rate_repository->updateById($id, $params);
            $result = null;
            if(isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được cập nhật thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu cập nhật thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
       }
    }
    public function status($table, $conditions){
        return $this->check_data_exits($table, $conditions);
    }
    public function delete($id) {
        try {
            DB::beginTransaction();
            $conditions = ["sources_id" => $id];
            $sd_status = $this->status('sources_documents', $conditions);
            $sr_status = $this->status('sources_rate', $conditions);
            if($sd_status == true || $sr_status == true) {
                return [
                    "code" => 422,
                    "message" => "Đơn vị liên kết này đã tồn tại bảng khác"
                ];
            }
            $dem = Sources::where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi cần xóa"
                ];
            }
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->sources_repository->updateById($id, $data);
            $result = null;
            if($model) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được xóa thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu xóa thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }

    }
    public function delete_sources_documents($id) {
        try {
            DB::beginTransaction();
            $conditions = ["sources_documents_id" => $id];
            $sr_status = $this->status('sources_rate', $conditions);
            if($sr_status) {
                return [
                    "code" => 422,
                    "message" => "Văn bảng ký kết của này đang tồn tại bảng khác"
                ];
            }
            $dem = SourcesDocuments::where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi cần xóa"
                ];
            }
            // Xóa bảng tỷ lệ
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->sources_documents_repository->updateById($id, $data);
            $result = null;
            if($model) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được xóa thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu xóa thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }

    }
    public function delete_sources_rate($id) {
        try {
            DB::beginTransaction();
            $dem = SourcesRates::where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi cần xóa"
                ];
            }
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->sources_rate_repository->updateById($id, $data);
            $result = null;
            if($model) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được xóa thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu xóa thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }

    }
    public function imports($params){
        try {
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new SourcesImports, $params['file']);
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    public function imports_sources_rates($params){
        try {
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new SourcesRatesImports, $params['file']);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    public function import_sources_price_lists($params){        
        try {           
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }            
            Excel::import(new SourcesPriceListsImports($params['semesters_id']), $params['file']);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    public function imports_sources_documents($params){
        try {
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new SourcesDocumentsImports, $params['file']);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    private function get_value_sources_rate($value){
        $data = null;
        $data['sources_id']             = $value['sources_id'];
        $data['expense_name']           = $value['expense_name'];
        $data['payment_condition']      = $value['math_sign'] .' '. $value['payment_condition'];
        $data['payment_rate']           = $value['payment_rate'];
        $data['payment_note']           = $value['payment_note'];
        $data['payment_manager_rate']   = $value['payment_manager_rate'];
        $data['payment_manager_price']  = $value['payment_manager_price'];
        $data['payment_terms_note']     = $value['payment_terms_note'];
        $data['math_sign']              = $value['math_sign'];
        return $data;

    }
    private function get_sources_rate($params, $quantity){
        $data = null;
        foreach ($params as $value) {
            switch ($value['math_sign']) {
                case '<':
                    if($quantity < $value['payment_condition']) {
                        $data = $this->get_value_sources_rate($value);
                    }
                    break;
                case '>=':
                    if($quantity > $value['payment_condition']) {
                        $data = $this->get_value_sources_rate($value);
                    }
                    break;
                case '=':
                    if($quantity == $value['payment_condition']) {
                        $data = $this->get_value_sources_rate($value);
                    }
                    break;
            }
        }
        return $data;
    }
    public function get_quantity_leads_by_sources ($sources_id){
        try {         
            $day_of_month = $this->get_day_of_month();   
            $model = SourcesPricesLists::with(["sources.sources_rate", "students"])->where('sources_id', $sources_id)                  
            ->orderBy('sources_id', 'asc')
            ->get()
            ->toArray();                
            
            $data = [];
            if (count($model) > 0) {
                foreach ($model as $item) {
                    $source_rate = $this->get_sources_rate($item['sources']['sources_rate'], $item['quantity']);
                    $signed_from_date = isset($item['sources']) && isset($item['sources']['signed_from_date']) ? Carbon::createFromFormat('Y-m-d', $item['sources']['signed_from_date'])->format('d/m/Y') : null;
                    $signed_to_date = isset($item['sources']) && isset($item['sources']['signed_to_date']) ? Carbon::createFromFormat('Y-m-d', $item['sources']['signed_to_date'])->format('d/m/Y') : null;
                    if (isset($source_rate)) {
                        $data[$item['sources']['id']]["sources_types"]           = $item['sources']['sources_types'] ?? null;
                        $data[$item['sources']['id']]["name"]                    = $item['sources']['name'] ?? null;
                        $data[$item['sources']['id']]["code"]                    = $item['sources']['code'] ?? null;
                        $data[$item['sources']['id']]["location_name"]           = $item['sources']['location_name'] ?? null;
                        $data[$item['sources']['id']]["sources_manager_name"]    = $item['sources']['sources_manager_name'] ?? null;
                        $data[$item['sources']['id']]["sources_employees_name"]  = $item['sources']['sources_employees_name'] ?? null;
                        $data[$item['sources']['id']]["signed_document"]         = $item['sources']['signed_document'] ?? null;
                        $data[$item['sources']['id']]["signed_content"]          = $item['sources']['signed_content'] ?? null;
                        $data[$item['sources']['id']]["signed_from_date"]        = $signed_from_date;
                        $data[$item['sources']['id']]["signed_to_date"]          = $signed_to_date;
                        $data[$item['sources']['id']]["expense_name"]            = isset($source_rate['expense_name']) ? $source_rate['expense_name'] : NULL;
                        $data[$item['sources']['id']]["payment_condition"]       = isset($source_rate['payment_condition']) ? $source_rate['payment_condition'] : NULL;
                        $data[$item['sources']['id']]["payment_rate"]            = isset($source_rate['payment_rate']) ? $source_rate['payment_rate'] : NULL;
                        $data[$item['sources']['id']]["payment_note" ]           = isset($source_rate['payment_note']) ? $source_rate['payment_note'] : NULL;
                        foreach ($day_of_month as $key => $value) {
                            if ($item['month'] == (int)$value) {
                                $data[$item['sources']['id']][$value . '/' . $item['year']] = $item['quantity'];
                                $data[$item['sources']['id']]["quantity"][$value . '/' . $item['year']] = $item['quantity'];
                                array_splice($day_of_month, $key, 1);
                            } else {
                                $data[$item['sources']['id']]["quantity"][ $value . '/' . $item['year']] = 0;
                                $data[$item['sources']['id']][$value . '/' . $item['year']] = 0;
                            }
                        }
                        $data[$item['sources']['id']][$item['month'] . '/' . $item['year']] = $item['quantity'];
                    }
                }
            }
            $result = null;
            if(isset($sources_id)) {
                $result = $data[$sources_id];
            } else {
                $result = $data;
            }            
            return $model;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }

    }
    private function get_data_semesters($date_time){
        $model = $this->semesters_repository->with(['academic_terms'])->get()->toArray();
        $data = [];
        if(count($model) > 0){
            foreach ($model as $item) {
                $semesters_year =  isset($item['academic_terms']) && isset($item['academic_terms']['from_year']) && isset($item['academic_terms']['from_year']) ?  $item['academic_terms']['from_year'] .'-'. $item['academic_terms']['to_year'] : null;
                $from_date      =  $item['from_year'] .'-'. ($item['from_month'] < 10 ? '0' . $item['from_month'] : $item['from_month']) .'-'. $item['from_day'];
                $to_date        =  $item['to_year'] .'-'. ($item['to_month'] < 10 ? '0' . $item['to_month'] : $item['to_month']) .'-'. $item['to_day'];
                $new_date_time      =  DateTime::createFromFormat('Y-m-d', $date_time)->format('Y-m-d');
                if(strtotime($new_date_time) >= strtotime($from_date) && strtotime($new_date_time) <= strtotime($to_date)) {
                    $data = [
                        "semesters_year"        => $semesters_year,
                        "name"                  => $item['name'],
                        "from_date"             => $from_date,
                        "to_date"               => $to_date,
                    ];
                }
            }
        }
        return $data;
    }
    private function get_total_price($data){
        $new_data = [];
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if(is_array($v)) {
                    $new_data[$key][$k] = array_sum($v);
                } else {
                    $new_data[$key][$k] = $v;
                }
            }
        }
        return $new_data;
    }
    private function merge_data($data, $transactions){
        $new_data = [];
        $params = null;
        foreach ($data as $d) {
            foreach ($transactions as $key => $value) {
                if($d['id'] == $key){
                    $params = $d;
                    foreach ($value as $k => $v) {
                        $params[$k] = $v;

                    }
                    $new_data[] = $params;
                }
            }
        }
        return $new_data;
    }
    private function get_data_transaction(){
        $model = $this->tran_repository->orderBy('id', 'asc')->get()->toArray();
        $data = [];
        foreach ($model as $value) {
            $semesters = $this->get_data_semesters($value['tran_date']);
            $data[$value['students_id']]['semesters_year'] = $semesters['semesters_year'];
            $data[$value['students_id']][$semesters['name']][] = $value['price'];
        }
        $new_data = $this->get_total_price($data);
        return $new_data;
    }
    private function get_academic_terms_by_id($id){
        $model = AcademicTerms::with(['semesters'])->where('id', $id)->first();
        return $model;
    }
    private function get_academic_semesters_by_id($id){
        $model = AcademicTerms::with(['semesters'])->where('id', $id)->first();        
        return $model;
    }
    private function get_transations_groupped_by_student_id($params, $id){
        $student_ids = $this->get_data_leads_id($id);
        $model = Transactions::with(['academic_terms','students','students.marjors'=> function ($query) {
                                $query->select('id', 'name');
                            },
        ]);
        if(isset($params["academic_terms_id"])) {
            $model = $model->where('academic_terms_id', $params["academic_terms_id"]);
        }

        $model = $model->whereIn('students_id', $student_ids)->get()->toArray();
        return $model;
    }
    private function get_academic_list_have_academic_terms_id($params, $id) {
        $dataTable = array();
        $academic_list = $this->get_academic_semesters_by_id($params['academic_terms_id'])->toArray();         
        $arr_academic = array();
        foreach($academic_list['semesters'] as $item){
            $arr_academic[$item['id']] = null;
        }
        $data_transations = $this->get_transations_groupped_by_student_id($params, $id);        
        //format dữ liệu trả về cho front end, datatable
        foreach($data_transations as $k=>$value){           
            $dataTable[$value['students_id']]['full_name'] = $value['students']['full_name'];
            // $dataTable[$value['students_id']]['academic_terms_name'] = $value['academic_terms']['name'];
            $dataTable[$value['students_id']]['students_code'] = $value['students']['students_code'];
            $dataTable[$value['students_id']]['marjor_name'] = $value['students']['marjors']['name'];
            foreach($arr_academic as $stt=>$item){
                if(!isset($dataTable[$value['students_id']]['si_'.$stt])){
                    if($value['semesters_id'] == $stt){
                        $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                    }else{
                        $dataTable[$value['students_id']]['si_'.$stt] = $item;
                    }
                }else{
                    if($value['semesters_id'] == $stt){
                        $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                    }
                }
            }
        }

        $result = null;
        $result['academic_list'] = $academic_list ?? null;
        $result['data'] = $dataTable;
        return $result;
    }
    private function get_academic_list_not_have_academic_terms_id($params, $id) {
        $data_transations = $this->get_transations_groupped_by_student_id($params, $id);                    
        //format dữ liệu trả về cho front end, datatable
        foreach($data_transations as $k=>$value){                          
            $academic_list = $this->get_academic_semesters_by_id($value['academic_terms_id'])->toArray();                      
            $arr_academic = array();
            foreach($academic_list['semesters'] as $item){
                $arr_academic[$item['id']] = null;
            }
            
            $dataTable[$value['students_id']]['full_name'] = $value['students']['full_name'];
            // $dataTable[$value['students_id']]['academic_terms_name'] = $value['academic_terms']['name'];
            $dataTable[$value['students_id']]['students_code'] = $value['students']['students_code'];
            $dataTable[$value['students_id']]['marjor_name'] = $value['students']['marjors']['name'];
            foreach($arr_academic as $stt=>$item){
                if(!isset($dataTable[$value['students_id']]['si_'.$stt])){
                    if($value['semesters_id'] == $stt){
                        $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                    }else{
                        $dataTable[$value['students_id']]['si_'.$stt] = $item;
                    }
                }else{
                    if($value['semesters_id'] == $stt){
                        $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                    }
                }
            }
        }        
        $result = null;
        $result['academic_list'] = $academic_list ?? null;
        $result['data'] = $dataTable ?? null;        
        return $result;
    }

    // thanh toán hoa hồng cho đơn vị liên kết
    //----------------------------------------------------------------------------------
    private function get_leads_id_by_academic_terms_id(){
        $model = $this->st_repository->orderBy('id', 'desc')->get()->toArray();
        $data = [];
        foreach ($model as $item) {
            $data[$item['academic_terms_id']][] = $item['id'];
        }
        return $data;
    }
    private function set_data_leads($params){
        $academic_terms_id = $params['academic_terms_id'];
        $leads_id_by_academic_terms_id = $params['leads_id_by_academic_terms_id'];
        $data = [];
        foreach ($leads_id_by_academic_terms_id as $k => $v) {
            foreach ($academic_terms_id as $key => $value) {
                if($key == $k) {
                    $data[$value] = isset($params['type']) && $params['type'] == 'quantity' ? count($v) : $v;
                    $academic_terms_id = $this->unset_array($academic_terms_id, $key);
                } else {
                    $data[$value] = isset($params['type']) && $params['type'] == 'quantity' ? 0 : null;
                }
            }
        }
        return $data;
    }
    private function set_quantity_leads_by_academic_terms($academic_terms_id, $leads_id_by_academic_terms_id){
        $params = [
            "type"                              => 'quantity',
            "academic_terms_id"                 => $academic_terms_id,
            "leads_id_by_academic_terms_id"     => $leads_id_by_academic_terms_id,
        ];
        $data = $this->set_data_leads($params);
        return $data;
    }
    // get  sources rate by sources_id
    private function get_data_rate($sources_id, $quantity){
        $model = SourcesRates::where('sources_id', $sources_id)->get()->toArray();
        $data = [];
        foreach ($model as $value) {
            $data = $value;
        }
        return $data;
    }
    private function payment_for_sources($rate, $quantity, $employees_price){
        $total_price = ($rate * $quantity) / 100 - $employees_price;
        return $total_price;
    }
    private function payment_for_employees($quantity){
        $total_price = 300000 * $quantity;
        return $total_price;
    }
    private function payment_for_employees_by_price($price){
        $total_price = (5 * $price) / 100;
        return $total_price;
    }
    //----------------------------------------------------------------------------------
    // Lấy danh sách phân loại
    private function get_data_sources_types($output){
        $model = Sources::whereNotNull('code')->get()->pluck($output)->toArray();
        return $model;
    }
    private function get_data_sources_documents($output){
        $model = SourcesDocuments::with(['sources'])->get()->pluck($output)->toArray();
        $data = [];
        foreach ($model as $value) {
            if(!in_array($value, $data)) {
                $data[] = $value;
            }
        }
        return $data;
    }
    private function get_data_sources_rate($output){
        $model = SourcesRates::with(['sources'])->get()->pluck($output)->toArray();
        $data = [];
        foreach ($model as $value) {
            if(!in_array($value, $data)) {
                $data[] = $value;
            }
        }
        return $data;
    }
    private function get_data_payment_rate_note($key = null){
        $model = SourcesRates::with(['sources'])->get()->toArray();
        $data = [];
        foreach ($model as $value) {
            $payment_rate_note = null;
            $payment_rate_note .= $value['payment_rate'] . '% (' . $value['payment_manager_price'] . ')';
            $payment_manager_rate_note = $value['payment_manager_rate'] . '%';
            if(!in_array($payment_rate_note, $data)) {
                $data["payments_rate"] = $payment_rate_note;
                $data["payment_manager_rate"] = $payment_manager_rate_note;
            }
        }
        return $data[$key];
    }
    public function get_list_by_fields(){
        $sourcese_types     = $this->get_data_sources_types('sources_types');
        $locations_name     = $this->get_data_sources_types('location_name');
        $sources_documents  = $this->get_data_sources_documents('signed_document');
        $contracts          = $this->get_data_sources_rate('expense_name');
        $payment_terms_note = $this->get_data_sources_rate('payment_terms_note');
        $payment_rate_note  = $this->get_data_payment_rate_note("payments_rate"); //20% (300,000)
        $payment_manager_rate_note  = $this->get_data_payment_rate_note("payment_manager_rate"); //5%
        $payment_time       = $this->get_data_sources_rate('payment_note');

        $data = [
            "sourcese_types"     => $sourcese_types,
            "locations_name"     => $locations_name,
            "sources_documents"  => $sources_documents,
            "contracts"          => $contracts,
            "payment_terms_note" => $payment_terms_note,
            "payment_time"       => $payment_time,
            "payment_rate_note"         => $payment_rate_note,
            "payment_manager_rate_note" => $payment_manager_rate_note
        ];
        return $data;
    }
    public function get_cities(){
        $responseCities = file_get_contents(public_path('/assets/js/cities.json'));
        $cities = json_decode($responseCities, true);
        return $cities;
    }
    //--------------------------------------------------------------------------------------------
    // Thiết kế lại
    private function get_data_leads_id($sources_id){
        $model = Students::with(['sources'])->where('sources_id', $sources_id)->get()->pluck('id')->toArray();
        return $model;
    }
    private function get_total_price_by_students($students_id, $semesters_id){
        $model = Transactions::select(['semesters_id', DB::raw('SUM(price) as total_price')]);
        if(isset($semesters_id) && $semesters_id != null) {
            $model = $model->where('semesters_id', $semesters_id);
        }
        if(isset($semesters_id) && $semesters_id != null) {
            $model = $model->where('semesters_id', $semesters_id);
        }
        $model = $model->whereIn('students_id', $students_id)
                ->groupBy('semesters_id')
                ->get()->toArray();
        $data = null;
        foreach ($model as $item) {
            $data[$item['semesters_id']] = $item['total_price'];
        }
        return $data;
    }

    public function get_payment_for_partners($params, $sources_id){
        $student_id = $this->get_data_leads_id($sources_id);
        $params['student_id'] = $student_id;
        $semesters = Semesters::with(['academic_terms'])->get()->pluck('name', 'id')->toArray();
        $params['semesters'] = $semesters;
        $data = $this->get_data_transactions_by_students($params);        
        return [
            "data"  => $data
        ];
    }
    //--------------------------------------------------------------------------------------------
    // Thiết kế lại danh sách sinh viên của ĐVLK
    //--------------------------------------------------------------------------------------------    
    public function get_price_lists_leads_by_sources_for_ajax($params, $id) {                                     
        $new_datatable = $this->get_price_lists_leads_by_sources_news($params, $id);   
        $data = null;     
        if(isset($new_datatable) && is_array($new_datatable["data"]) && count($new_datatable['data'])){          
            foreach($new_datatable['data'] as $item){
                $data[] = (object)array_values($item);
            }
        }
        return response()->json(['data' => $data]);
    }
    public function get_price_lists_leads_by_sources($params, $id){
        $result = null;       
        if(isset($params["academic_terms_id"]) && strlen($params["academic_terms_id"]) > 0) { 
            // Chọn niên khóa            
            $result = $this->get_academic_list_have_academic_terms_id($params, $id);
        } else {
            // Lấy hết danh sách theo ĐVLK
            $result = $this->get_academic_list_not_have_academic_terms_id($params, $id);
        }
        return $result;
    }
    private function get_data_academic($params, $acedemic_term_id) {        
        $data = [];                
        foreach($params as $item){            
            $data[$item['id']] = null;
        }              
        return $data;
    }
    public function get_price_lists_leads_by_sources_news($params, $id){          
        $model = $this->s_price_list_respository
                ->with(["sources","students.marjors","academic_terms.semesters","marjors", "semesters"])
                ->where('sources_id', $id);
        if(isset($params["academic_terms_id"])) {            
            $model = $model->where('acedemic_term_id', $params["academic_terms_id"]);
        }
        $model = $model->get()->toArray();   
        $result = null;
        if(count($model) > 0) {            
            $dataTable = [];
            $academic_list = null;
            $result = null;
            foreach ($model as $k => $value) {            
                $academic_list = $value["academic_terms"]; 
                $arr_academic = $this->get_data_academic($academic_list['semesters'], $value["acedemic_term_id"] );    
                $dataTable[$value['students_id']]['full_name'] = $value['students']['full_name'];
                $dataTable[$value['students_id']]['students_code'] = $value['students']['students_code'];
                $dataTable[$value['students_id']]['marjor_name'] = $value['students']['marjors']['name'];
                foreach($arr_academic as $stt=>$item){
                    if(!isset($dataTable[$value['students_id']]['si_'.$stt])){
                        if($value['semesters_id'] == $stt){
                            $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                        }else{
                            $dataTable[$value['students_id']]['si_'.$stt] = $item;
                        }
                    }else{
                        if($value['semesters_id'] == $stt){
                            $dataTable[$value['students_id']]['si_'.$stt] = number_format($value['price'], 0, ',', '.');
                        }
                    }
                }
            }  
            $result['academic_list'] = $academic_list ?? null;
            $result['data'] = $dataTable ?? null; 
        } else {
            $result['academic_list'] = null;
            $result['data'] = null; 
        }

        return $result;
    }
    // --------------------------------------------------------------------------------------------
    private function get_data_transactions_by_students($params){        
        $data = [];
        $students_id    = $params['student_id'];        
        // $semesters      = $params['semesters'];
        $model = Transactions::with(['students.sources','students.sources.sources_documents', 'students.sources.sources_rate', 'academic_terms', 'semesters']);        
        if(isset($params['academic_terms_id']) && strlen($params['academic_terms_id'])) {
            $model = $model->where('academic_terms_id', $params["academic_terms_id"]);
        }
        $count_students = $model->whereIn('students_id', $students_id)->distinct('students_id')->count('students_id');
        $model = $model->whereIn('students_id', $students_id)->get()->toArray();                
        if(count($model) > 0) {
            foreach ($model as $item) {
                $source_rate = $this->get_sources_rate($item['students']['sources']['sources_rate'], count($students_id));
                $total_price = $this->get_total_price_by_students($students_id, $item['semesters_id']);
                $payment_for_manager   = isset($source_rate['payment_manager_price']) ? $source_rate['payment_manager_price'] * count($students_id) : 0;   // Tien cho nhan vien quan ly
                $payment_for_sources   = isset($source_rate['payment_manager_price']) ? ($source_rate['payment_rate'] * $total_price[$item['semesters_id']]) / 100 : 0; // Tien cho don vi quan ly
                $payment_for_employees = isset($source_rate['payment_manager_price']) ? ($source_rate["payment_manager_rate"] * $total_price[$item['semesters_id']]) / 100 : 0;
                if(isset($params['academic_terms_id']) &&  $item['academic_terms']['id'] == $params['academic_terms_id']){
                    // $item['semesters_id']
                    $data[] = [
                        "academic_terms_name"    => $item['academic_terms']['name'], // Tên niên khóa học
                        "semesters_name"         => $item['semesters']['name'], // Tên hoc ky
                        "from_year"              => $item['semesters']['from_year'],
                        "to_year"                => $item['semesters']['to_year'],
                        "total_quantity"         => $count_students, // Tổng số lượng sinh viên
                        "total_price"            => number_format($total_price[$item['semesters_id']],0, ',', '.'),
                        // Tinh ty le
                        "payment_for_manager"    => number_format($payment_for_manager,0, ',', '.'), // Tien cho nhan vien quan ly
                        "payment_for_sources"    => number_format($payment_for_sources - $payment_for_manager ,0, ',', '.'), // Tien cho don vi quan ly
                        "payment_for_employees"  => number_format($payment_for_employees,0, ',', '.'),
                        // Ty le
                        "payment_rate"           => $source_rate['payment_rate'] ?? null,
                        "expense_name"           => $source_rate["expense_name"] ?? null,
                        "payment_condition"      => $source_rate["payment_condition"] ?? 0,
                        "payment_rate"           => $source_rate["payment_rate"] ?? null,
                        "payment_note"           => $source_rate["payment_note"] ?? null,
                        "payment_manager_rate"   => $source_rate["payment_manager_rate"] ?? 0,
                        "payment_manager_price"  => isset($source_rate["payment_manager_price"]) ? number_format($source_rate["payment_manager_price"],0, ',', '.') : 0,
                        "payment_terms_note"     => $source_rate["payment_terms_note"] ?? null,
                        "payment_note"           => $source_rate["payment_note"] ?? null,
                    ];
                } else {
                    $data[] = [
                        "academic_terms_name"    => $item['academic_terms']['name'], // Tên niên khóa học
                        "semesters_name"         => $item['semesters']['name'], // Tên hoc ky
                        "from_year"              => $item['semesters']['from_year'],
                        "to_year"                => $item['semesters']['to_year'],
                        "total_quantity"         => $count_students, // Tổng số lượng sinh viên
                        "total_price"            => number_format($total_price[$item['semesters_id']],0, ',', '.'),
                        // Tinh ty le
                        "payment_for_manager"    => number_format($payment_for_manager,0, ',', '.'), // Tien cho nhan vien quan ly
                        "payment_for_sources"    => number_format($payment_for_sources - $payment_for_manager ,0, ',', '.'), // Tien cho don vi quan ly
                        "payment_for_employees"  => number_format($payment_for_employees,0, ',', '.'),
                        // Ty le
                        "payment_rate"           => $source_rate['payment_rate'] ?? null,
                        "expense_name"           => $source_rate["expense_name"] ?? null,
                        "payment_condition"      => $source_rate["payment_condition"] ?? 0,
                        "payment_rate"           => $source_rate["payment_rate"] ?? null,
                        "payment_note"           => $source_rate["payment_note"] ?? null,
                        "payment_manager_rate"   => $source_rate["payment_manager_rate"] ?? 0,
                        "payment_manager_price"  => isset($source_rate["payment_manager_price"]) ? number_format($source_rate["payment_manager_price"],0, ',', '.') : 0,
                        "payment_terms_note"     => $source_rate["payment_terms_note"] ?? null,
                        "payment_note"           => $source_rate["payment_note"] ?? null,
                    ];
                }
            }
        }        
        return $data;
    }
    //--------------------------------------------------------------------------------------------    
    private function get_data_sources_price_lists($params, $sources_id) {
        // ->with(["sources","students","academic_terms","marjors","semesters"])
        $model = $this->s_price_list_respository
                ->with(["sources","students","academic_terms","marjors","semesters"])
                ->where('sources_id', $sources_id);
        if(isset($params["academic_terms_id"])) {
            $model = $model->where('acedemic_term_id', $params["academic_terms_id"]);
        }        
        return $model;
    }
    private function get_data_sources_rate_by_sources($item, $quantity) {        
        // $data = "";
        $a_terms_year = $item["academic_terms"]["from_year"];        
        $model = SourcesDocuments::with(['sources_rate'])->whereYear('signed_from_date', $a_terms_year)->first();        
        $data = [];        
        if(isset($model->id)) {            
            $data_sources_rate = $model['sources_rate']->toArray();
            if(is_array($data_sources_rate) && count($data_sources_rate) > 0)            
            foreach ($data_sources_rate as $value) {
                if($quantity < $value["payment_condition"] && $value["math_sign"] == "<"){
                    $data = $value;
                } elseif($quantity >= $value["payment_condition"] && $value["math_sign"] == ">="){
                    $data = $value;
                }
            }
        }        
        return $data;
    }
    private function get_data_total_price_for_sources($params, $groups) {            
        $data = [];        
        $total_price = 0;        
        foreach ($params as $item) {                
            $total_quantity             = $groups[$item['semesters_id']]["total_quantity"] ?? 0;
            $total_price                = $groups[$item['semesters_id']]["total_price"] ?? 0;                      
            $sources_rate               = $this->get_data_sources_rate_by_sources($item, $total_quantity);
            $payment_for_manager        = $total_quantity * 300000;
            $payment_for_sources        = ($sources_rate["payment_rate"] * $total_price)/100 -  $payment_for_manager;       
            $payment_5_for_price_lists  = ($sources_rate["payment_manager_rate"] * $total_price) / 100;
            $data[$item['semesters_name']] = [               
                "from_year"                 => $item['semesters']['from_year'],
                "to_year"                   => $item['semesters']['to_year'],               
                "acedemic_terms_name"       => $item["acedemic_term_name"] ?? null,
                "semesters_name"            => $item['semesters']['name'], // Tên hoc ky
                "payment_rate"              => $sources_rate["payment_rate"],
                "payment_manager_rate"      => $sources_rate["payment_manager_rate"],
                "expense_name"              => $sources_rate["expense_name"] ?? null,
                "payment_note"              => $sources_rate["payment_note"],
                "payment_condition"         => $sources_rate["payment_condition"] ?? 0,
                "payment_terms_note"        => $sources_rate["payment_terms_note"] ?? 'sv/khoa',
                "payment_manager_price"     => number_format($sources_rate["payment_manager_price"], 0, ',', '.'),                
                "payment_for_manager"       => number_format($payment_for_manager, 0, ',', '.'),                 
                "total_quantity"            => number_format($total_quantity, 0, ',', '.'),
                "total_price"               => number_format($total_price, 0, ',', '.'),
                "payment_for_sources"       => number_format($payment_for_sources, 0, ',', '.'), // Tien cho don vi quan ly
                "payment_5_for_employees"   => number_format($payment_5_for_price_lists, 0, ',', '.'),        
            ];
        }        
        $new_data = [];
        foreach ($data as $value) {
            $new_data[] = $value;
        }
        // dd($data);
        return $new_data;
    }
    private function get_total($params){
        $model =  DB::table('source_price_lists')->whereNull('deleted_at')
                ->select('semesters_id', DB::raw('SUM(price) as total_price'), DB::raw('COUNT(DISTINCT students_id) as total_quantity'))                    
                ->groupBy('semesters_id')
                ->get();
        $data = [];
        foreach ($model as $value) {            
            $data[$value->semesters_id] = [
                "total_quantity" => $value->total_quantity,
                "total_price" => $value->total_price,
            ];
        }
        return $data;
    }      
    public function get_payment_for_partners_news($params, $sources_id){        
        //Lấy danh sách sinh viên chính thức theo đơn vị liên kết      
        $groups         = $this->get_total($params);                       
        $data           = $this->get_data_sources_price_lists($params, $sources_id)->get()->toArray();                
        $data_rate      = $this->get_data_total_price_for_sources($data, $groups);        
        return [
            "data"  => $data_rate
        ];
    }
}
