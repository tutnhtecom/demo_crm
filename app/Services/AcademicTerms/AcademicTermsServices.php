<?php

namespace App\Services\AcademicTerms;

use App\Imports\AcademicTermsImports;
use App\Imports\ApiListImports;
use App\Jobs\CreateSemestersConfigsJobs;
use App\Models\Leads;
use App\Models\LeadsAcademicTerms;
use App\Models\Semesters;
use App\Repositories\AcademicTermsRepository;
use App\Repositories\ApiListsRepository;
use App\Services\Semesters\SemestersInterface;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AcademicTermsServices implements AcademicTermsInterface
{
    use General;
    protected $academic_terms_repository;
    protected $semesters_interface;
    public function __construct(
        AcademicTermsRepository $academic_terms_repository,
        SemestersInterface $semesters_interface
    )
    {
        $this->academic_terms_repository = $academic_terms_repository;
        $this->semesters_interface = $semesters_interface;
    }
    private function data_semesters_config($model, $params){
        $config = $this->semesters_interface->data_config();
        $data = [];
        $academic_terms_id = $model->id;        
        foreach ($config as $key => $item) {
            $item['academic_terms_id'] = $academic_terms_id;
            $item['from_year'] = $params["from_year"];
            $item['to_year'] = $params["to_year"];
            $data[] = $this->unset_array($item, ['id','updated_at']);
        }        
        return $data;
    }
    private function data_semesters_config_1($model){
        $config = $this->semesters_interface->data_config();
        $data = [];
        $academic_terms_id = $model->id;
        $from_year = $model->from_year;
        $to_year = $model->to_year;
        while ($from_year < $to_year) {
            foreach ($config as $key => $item) {
                $item['academic_terms_id'] = $academic_terms_id;
                $item['from_year'] = $from_year;
                if($key !== 0) {
                    $item['from_year'] = $from_year+1;
                }
                $item['to_year'] = $from_year+1;
                $data[] = $this->unset_array($item, ['id','updated_at']);
            }
            $from_year += 1;
        }
        return $data;
    }
    public function create($params){
        try {
            DB::beginTransaction();
            $params["to_year"] = $params["from_year"];
            $model = $this->academic_terms_repository->create($params);
            $result = null;
            if (isset($model->id)) {
                $config = $this->data_semesters_config($model, $params);                
                Semesters::insert($config);
                // CreateSemestersConfigsJobs::dispatch($config);
                $result = [
                    "code"      => 200,
                    "message"   => "Thông tin đã được thêm mới thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thông tin đã được thêm mới không thành công"
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
    public function filter($params){
        $model = $this->academic_terms_repository;
        if(isset($params['keyword'])){
            $model = $model->where('name', '%' . $params['keyword'] . '%', 'LIKE');
        }
        if(isset($params['sort'])){
            $model = $model->orderBy('created_at', $params['sort']);
        } else {
            $model = $model->orderBy('created_at', 'desc');
        }
        return $model;
    }
    public function index($params){
        $model = $this->filter($params);
        $data = $model->get()->toArray();
        $result = null;
        if(count($data) > 0) {
            $result = [
                "code"      => 200,
                "message"   => "Tải dữ liệu thành công",
                "data"      => $data
            ];
        } else {
            $result = [
                "code"      => 200,
                "message"   => "Không tìm thấy bản ghi trên hệ thống",
            ];
        }
        return $result;
    }
    public function details($id){

        $model = $this->academic_terms_repository->with(['semesters'])->where('id', $id, '=')->first();
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
    public function update($params, $id){
        try {
            DB::beginTransaction();
            $model = $this->academic_terms_repository->updateById($id, $params);
            $result = null;
            if (isset($model->id)) {
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật thông tin thành công",
                ];
            } else {
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật thông tin thành công",
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
    public function delete($id){
        $result = null;
        $dem =  $this->academic_terms_repository->where('id', $id, '=')->count();
        if($dem <= 0) {
           return [
                "code"      => 422,
                "message"   => "Không tìm thấy bản ghi này",
            ];
        }
        // Kiểm tra dữ liệu bảng leads_academic_year
        $l_ac_term = Leads::where('academic_terms_id', $id)->count();
        if($l_ac_term > 0) {
            return [
                 "code"      => 422,
                 "message"   => "Niên khóa này không thể xóa! Niên khóa đã được gán nhiều sinh viên",
             ];
         }
        $data_update = [
            "deleted_at"    =>  Carbon::now(),
            "deleted_by"    =>  Auth::user()->id
        ];
        // Xóa học kỳ
        Semesters::where("academic_terms_id", $id)->update($data_update);
        $this->academic_terms_repository->updateById($id, $data_update);
        // Xóa niên khóa
        $model = $this->academic_terms_repository->deleteById($id);
        // Trả về kết quả
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
    public function import($params){
        try {
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new AcademicTermsImports, $params['file']);
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
    public function update_leads_to_academic($params, $id){
        try {
            DB::beginTransaction();
            $dem = $this->academic_terms_repository->where('id', $id)->count();
            if ($dem <= 0) {
                return [
                    "code"      => 422,
                    "message"   => "Cập nhật thông tin thành công",
                ];
            }
            if (!isset($params['leads_code'])) {
                return [
                    "code"      => 422,
                    "message"   => "Vui lòng chọn sinh viên",
                ];
            }
            $delete = $this->academic_terms_repository->where('id', $id)->first();
            if (isset($delete->id)) {
                $delete->update([
                    "deleted_at"    =>      Carbon::now(),
                    "deleted_by"    =>      Auth::user()->id
                ]);
            }
            $data = [];
            if (is_array($params['leads_code'])) {
                $leads_id = $this->get_data_array_id('leads', 'code', $params['leads_code']);
                $data = [];
                foreach ($leads_id as $item) {
                    $data[] = [
                        "leads_id"          => $item,
                        'academic_terms_id' => $id
                    ];
                }
                $add = LeadsAcademicTerms::insert($data);
                if ($add == true) {
                    $result = [
                        "code"      => 200,
                        "message"   => "Cập nhật thông tin thành công",
                    ];
                } else {
                    $result = [
                        "code"      => 422,
                        "message"   => "Cập nhật thông tin thành công",
                    ];
                }
            }
            DB::commit();
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
