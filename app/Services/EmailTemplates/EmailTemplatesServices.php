<?php

namespace App\Services\EmailTemplates;

use App\Console\Commands\CreateEmailTemplateBladeView;
use App\Imports\KeyEmailTemplatesImports;
use App\Jobs\EmailTemplatesJobs;
use App\Models\EmailTemplateKey;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Repositories\EmailTemplatesRepository;
use App\Repositories\EmailTemplateTypesRepository;
use App\Traits\General;
use App\Models\Files;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EmailTemplatesServices implements EmailTemplatesInterface
{
    use General;
    protected $e_tmp_repository;
    protected $email_types_repository;
    public function __construct(EmailTemplatesRepository $e_tmp_repository, EmailTemplateTypesRepository $email_types_repository)
    {
        $this->e_tmp_repository = $e_tmp_repository;
        $this->email_types_repository = $email_types_repository;
    }
    public function index($params)
    {
        try {
            $model = $this->e_tmp_repository;
            if (isset($params['name'])) {
                $model = $model->where('name', 'like', '%' . $params['name'] . '%');
            }
            $model = $model->orderBy('id', 'desc')->get()->toArray();
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
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
        return response()->json($result);
    }
    public function details($id)
    {
        try {
            $model = $this->e_tmp_repository->where('id', $id, '=')->first();
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "data" => $model
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }
        return response()->json($result);
    }
    private function update_is_default($type){
        $model = EmailTemplates::where('types_id', $type)->update(["is_default" => EmailTemplates::NOT_IS_DEFAULT]);
        return $model;
    }
    private function get_file_name($file_name) {        
        $max_id         = $this->get_next_id('email_templates');
        $new_file_name  = null;
        if(view()->exists('includes.template.' . $file_name)) {                
            $new_file_name = $file_name . '_' .$max_id;
        } else {
            $new_file_name = $file_name;
        }   
        return $new_file_name;
    }
    public function create($params)
    {
        try {
            DB::beginTransaction();
            if(isset($params['is_default']) && $params['is_default'] == 1) {
                $this->update_is_default($params['types_id']);
            }
            $params['content']      = json_encode($params['content']);
            $params["created_at"]   = Carbon::now();
            $params["created_by"]   = Auth::user()->id ?? NULL;
            $tilte                  =  isset($params['title']) ? $this->slug($params['title']) : 'mau_email_template_' . rand(1, 999999);
            $params["file_name"]    = $this->get_file_name($tilte);            
            $model = $this->e_tmp_repository->create($params);
            //Tạo email plate
            EmailTemplatesJobs::dispatch($params);
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
    private function remove_file_blade($path){            
        $filePath = resource_path($path);        
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    public function update($params, $id) {
        try {        
            DB::beginTransaction();
            $file_name = "includes.template." . $params["file_name"];
            $path      = "views/includes/template/" . $params["file_name"] . '.blade.php';
            // remove mãu cũ
            if(view()->exists($file_name)) {
                $this->remove_file_blade($path);
            }  
            $tilte                  =  isset($params['title']) ? $this->slug($params['title']) : 'mau_email_template_' . rand(1, 999999);
            $params["file_name"]    = $this->get_file_name($tilte);
            $params['updated_by'] = Auth::user()->id ?? null;
            $params['content'] = json_encode($params['content']);            
            $model = $this->e_tmp_repository->updateById($id, $params);
            EmailTemplatesJobs::dispatch($params);
            $result = null;
            if (isset($model->id)) {
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
    public function delete($id)
    {
        try {
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->e_tmp_repository->updateById($id, $data);
            $result = null;
            if ($model) {
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }
    }
    public function emailTemplates()
    {
        $email_templates   = $this->e_tmp_repository->get();
        return $email_templates;
    }
    public function emailType()
    {
        $email_types   = $this->email_types_repository->get();
        return $email_types;
    }
    public function uploadImageContent($params){
        $id = Auth::user()->id ?? null;
        try {
            $datefolder = date('dmY');
            $datetime = date('dmYHis');
            $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $image_name = $datetime.'_'.$randomNumber;
            $params['title'] = "Ảnh content tinymce ".$datetime;
            $data = [];
            $url = "/assets/upload/emailtemplate/" .$datefolder.'/';
            $type = config('app.data.type_emloyees') ?? 2;
            // $data = $this->upload_image($params, $url, $id, $type, $image_name);
            $data = $this->upload_image($params, $url, $id, $type);
            // dd($data);
            if (isset($data)) {
                $result = [
                    "code"      => 200,
                    "location"   => $data['image_url'],
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "location"   => false,
                ];
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => 'catch:'.$e->getMessage()
            ]);
        }

    }
    public function import_key_email_template($params) {
        try {
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new KeyEmailTemplatesImports($params["email_template_types_id"]), $params['file']);
            DB::commit();
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
            DB::rollBack();
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    public function get_data_email_template_key(){
        $model = EmailTemplateKey::get()->toArray();
        return $model;
    }
    public function get_data_email_template_type(){
        $model = EmailTemplateTypes::get()->toArray();
        return $model;
    }

}
