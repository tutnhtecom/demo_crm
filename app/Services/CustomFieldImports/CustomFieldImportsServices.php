<?php

namespace App\Services\CustomFieldImports;

use App\Imports\AcademicTermsImports;
use App\Models\LeadsAcademicTerms;
use App\Models\CustomFieldImports;
use App\Repositories\CustomerFieldsImportsRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\General;
class CustomFieldImportsServices implements CustomFieldImportsInterface
{
    use General;
    protected $cf_imports_repository;
    public function __construct(CustomerFieldsImportsRepository $cf_imports_repository)
    {
        $this->cf_imports_repository = $cf_imports_repository;
    }
    public function create($params){                      
        $params['slug'] = $this->slug($params['name']);        
        $params['code'] = CustomFieldImports::max('id') ? "CF" . CustomFieldImports::max('id')+1 : 'CF1' ;        
        $model = $this->cf_imports_repository->create($params);
        $result = null;
        if(isset($model->id)) {
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
        return $result;
    }
    public function filter($params){
        $model = $this->cf_imports_repository;
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
        $model = $this->cf_imports_repository->whereById('id', $id, '=')->first();
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
        $model = $this->cf_imports_repository->updateById($id, $params);
        $result = null;
        if(isset($model->id)){
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
        return $result;
    }
    public function delete($id){
        $result = null;
        $dem =  $this->cf_imports_repository->where('id', $id, '=')->count();
        if($dem <= 0) {
           return [
                "code"      => 422,
                "message"   => "Không tìm thấy bản ghi này",
            ];
        }
        // Kiểm tra dữ liệu bảng leads_academic_year
        $l_ac_term = LeadsAcademicTerms::where('academic_terms_id', $id)->count();
        if($l_ac_term > 0) {
            return [
                 "code"      => 422,
                 "message"   => "Niên khóa này không thể xóa! Niên khóa đã được gán nhiều sinh viên",
             ];
         }
        $model = $this->cf_imports_repository->deleteById($id);
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
}
