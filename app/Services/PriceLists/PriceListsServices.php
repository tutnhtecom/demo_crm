<?php

namespace App\Services\PriceLists;

use App\Imports\PriceListImports;
use App\Jobs\CreatePriceListJobs;
use App\Jobs\SendMailJobs;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Files;
use App\Models\Leads;
use App\Models\NotificationsGroups;
use App\Models\PriceLists;
use App\Repositories\FilesRepository;
use App\Repositories\PriceListRepository;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PriceListsServices implements PriceListsInterface
{
    use General;
    protected $price_list_repository;
    protected $file_repository;
    protected $price_list_leads_repository;
    public function __construct(
      PriceListRepository $price_list_repository,
      FilesRepository $file_repository
    )
    {
      $this->price_list_repository = $price_list_repository;
      $this->file_repository = $file_repository;
    }
    public function filter($params) {
        $model = PriceLists::with('leads');
        if(isset($params['leads_id']) && strlen($params['leads_id']) >  0) {
            $model= $model->where('leads_id', $params['leads_id']);
        }
        return $model->orderBy('id', 'desc');
    }
    public function index($params){
        try {
            $record = $params['record'] ?? 15;
            $entries = $this->filter($params)->paginate($record);
            if (count($entries) > 0) {
                $result = [
                    "code" => 200,
                    "data" => $entries
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Hệ thống chưa có bản ghi nào"
                ];
            }
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
    }
    public function details($id) {
        try {
            $model = $this->price_list_repository->where('id', $id)->first();
            if (isset($model->id)) {
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
    }
    private function multiple($params) {
        $params['data_date'] = $this->get_date($params);
        if(isset($params['groups_id'])) {
            $list_id = $this->get_data_id('notifications_groups', $params['groups_id'], 'list_id');
            $params['leads_id'] = explode(',', json_decode($list_id));
        }
        $params['email'] = $this->get_data_email('leads', $params['leads_id']);
        $from_date = isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y-m-d') : null;
        $to_date = isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y-m-d') : null;
        $data = [];
        foreach ($params['leads_id'] as $item) {
            $data = [
                "leads_id"              => $item ?? null,
                "code"                  => rand(1000, 999999) ?? null,
                "title"                 => $params["title"] ?? null,
                "price"                 => $params["price"] ?? null,
                "from_date"             => $from_date,
                "to_date"               => $to_date,
                "status"                => PriceLists::STATUS_NOT_PAID,
                "created_by"            => Auth::user()->id ?? null,
                "academic_terms_id"     => $params['academic_terms_id'] ?? null,
                "semesters_id"          => $params['semesters_id'] ?? null,
            ];
            CreatePriceListJobs::dispatch($data);
        }
        // $model =  $this->price_list_repository->createMultiple($data);
        if(isset($params["auto_send_mail"]) && $params["auto_send_mail"] == PriceLists::AUTO_SEND_MAIL) {              
            if(isset($params['groups_id'])) $this->send_mail_by_groups($params);
            else {
                $this->get_data_sendmail($params);
            }
        }        
        return response()->json([
                "code"      => 200,
                "message"   => "Thêm mới thông báo học phí thành công",
        ]);
    }
    private function send_mail_by_groups($params){
        if(!isset($params['types_id'])) $params['types_id'] = EmailTemplateTypes::with(['eTemplates'])->where('name', 'like', '%hoc phi%' )->orderBy('id', 'desc')->first()->id;
        $params["file_name"] = $this->get_file_name($params,'includes.crm.mau_thong_bao_hoc_phi');
        $this->get_data_sendmail($params);
    } 
    private function get_data_sendmail($params){        
        $file_name = $this->get_file_name($params,'mau_thong_bao_hoc_phi');         
        if(is_array($params['email'])) {
            foreach ($params['email'] as $email) {
                $data_sendmail = [
                    'title'         => $params["title"] ?? 'Thông báo đóng học phí',
                    'subject'       => $params["title"] ?? 'Thông báo đóng học phí',
                    'full_name'     => $params["full_name"]?? null,
                    'leads_code'    => $params["leads_code"]?? null,
                    'price'         => $params['price'] ?? 0,
                    'phone'         => $params['phone'] ?? null,
                    "from_date"     => $params['data_date']['from_date'] ?? null,
                    "to_date"       => $params['data_date']['to_date'] ?? null,
                    "status"        => PriceLists::STATUS_NOT_PAID,
                    'to'            => $email,
                    'email'         => $email,
                ];
                SendMailJobs::dispatch($data_sendmail,  $file_name);
            }
        } else {
            $data_sendmail = [
                'title'         => $params["title"] ?? 'Thông báo đóng học phí',
                'subject'       => $params["title"] ?? 'Thông báo đóng học phí',
                'full_name'     => $params["full_name"]?? null,
                'leads_code'    => $params["leads_code"]?? null,
                'price'         => number_format($params['price'], 0, ',', '.') ?? 0,
                'phone'         => $params['phone'] ?? null,
                "from_date"     => $params['data_date']['from_date'] ?? null,
                "to_date"       => $params['data_date']['to_date'] ?? null,
                "status"        => PriceLists::STATUS_NOT_PAID,
                'to'            => $params['email'],
                'email'         => $params['email'],
            ];
            SendMailJobs::dispatch($data_sendmail,  $file_name);
        }

    }
    private function single($params) {        
        $params['data_date'] = $this->get_date($params);
        $data = [
            "leads_id"              => $params["leads_id"] ?? null,
            "code"                  => "HP" . rand(100000, 999999) ?? null,
            "title"                 => $params["title"] ?? null,
            "price"                 => $params["price"] ?? null,
            "from_date"             => $params['data_date']['from_date'] ?? null,
            "to_date"               => $params['data_date']['to_date'] ?? null,
            "status"                => PriceLists::STATUS_NOT_PAID,
            "note"                  => $params['note'],
            "created_by"            => Auth::user()->id ?? null,
            "academic_terms_id"     => $params['academic_terms_id'] ?? null,
            "semesters_id"          => $params['semesters_id'] ?? null,
        ];
        $model =  $this->price_list_repository->create($data);
        $leads = Leads::where('id', $params["leads_id"])->first();
        $params['email'] = $leads['email'];
        $params['leads_code'] = $leads['leads_code'];
        $params['full_name'] = $leads['full_name'];
        $params['phone'] = $leads['phone'];
        // Gui mail thông báo đóng học
        if(isset($params["auto_send_mail"]) && $params["auto_send_mail"] == PriceLists::AUTO_SEND_MAIL) {            
            $this->get_data_sendmail($params);
        }        
        
        if(isset($params['File']) && $params['File'] !='undefined') {
            $this->update_file_pdf($params, $model);
        }
        if(isset($model->id)) {
            return response()->json([
                "code"      => 200,
                "message"   => "Thêm mới thông báo học phí thành công",
                "data"      => $model
            ]);
        } else {
            return response()->json([
                "code"      => 422,
                "message"   => "Thêm mới thông báo học phí không thành công",
            ]);
        }
    }
    public function create($params) {        
        try {
            DB::beginTransaction();
            if (isset($params['leads_id']) && strpos($params['leads_id'], ',') == true) {
                $params['leads_id'] = explode(',', $params['leads_id']);
            }
            if (isset($params['groups_id']) || (isset($params['leads_id']) && is_array($params['leads_id']))) {                
                $data = $this->multiple($params);
            } else {
                $data = $this->single($params);
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function create_multiple($params) {
        try {
            DB::beginTransaction();
            $data = [];
            foreach ($params as $item) {
                $data_date = $this->get_date($item);
                $item['from_date'] = $data_date['from_date'];
                $item['to_date'] = $data_date['to_date'];
                $data[] = $item;
            }
            if(count($data) > 0) CreatePriceListJobs::dispatch($data);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Success"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function check_exist($id){
        $status = false;
        $price_list = PriceLists::where('id', $id)->count();
        if($price_list > 0) {
            $status = true;
        }
        return $status;
    }
    public function update($params, $id) {
        try {
            // Xóa dữ liệu cũ
            $from_date = isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y-m-d') : null;
            $to_date = isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y-m-d') : null;
            $params["from_date"] = $from_date;
            $params["to_date"] = $to_date;
            $params['updated_by'] = Auth::user()->id ?? null;
            $exist = $this->check_exist($id);
            if($exist == false) {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy bản ghi cần sửa"
                ]);
            }
            $model = $this->price_list_repository->updateById($id, $params);
            if(isset($model->id)) {
                return response()->json([
                    "code" => 200,
                    "message" => "Cập nhật phiếu báo giá thành công"
                ]);
            } else {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy phiếu báo giá hỗ trợ này"
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function delete($id) {
        $exist = $this->check_exist($id);
        if($exist == false) {
            return response()->json([
                "code" => 422,
                "message" => "Không tìm thấy bản ghi cần xóa"
            ]);
        }
        $params['deleted_at'] = now();
        $params['deleted_by'] = Auth::user()->id ?? null;
        $model = $this->price_list_repository->updateById($id,$params);
        if($model  == true) {
            return response()->json([
                "code" => 200,
                "message" => "Xóa phiếu báo giá thành công"
            ]);
        } else {
            return response()->json([
                "code" => 422,
                "message" => "Xóa phiếu báo giá thất bại"
            ]);
        }
    }
    public function update_status($params, $id){
        try {

            $model = $this->price_list_repository->where('id', $id)->count();
            if($model <=0) {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy bản ghi này"
                ]);
            }
            $model = $this->price_list_repository->updateById($id, $params);
            if(isset($model->id)) {
                return response()->json([
                    "code" => 200,
                    "message" => "Cập nhật phiếu báo giá thành công"
                ]);
            } else {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy phiếu báo giá hỗ trợ này"
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function update_file_pdf($params, $model){
        try {
            $params['title'] = "Upload File PDF";
            $data = [];
            $code = $model->leads->code;
            $params['email'] = $model->leads->email;
            $url = "/assets/upload/students/" . $code . "/";
            //Xóa file cũ
            $data = $this->upload_file($params, $url, $params['leads_id']);
            $data['price_list_id'] = $model->id;
            $data['types'] = Files::TYPE_PRICE;
            Files::where('email',  $params['email'])
                    ->where('price_list_id', $model->id)
                    ->where('types', $data['types'])
                    ->delete();
            $new_model = $this->file_repository->create($data);
            $result = null;
            if (isset($new_model->id)) {
                $result = [
                    "code"      => 200,
                    "message"   => "Tải avatar thành công",
                    "data"      => [
                        "leads_id" => $new_model->leads_id,
                        "image_url" => $new_model->image_url,
                    ]
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Tải avatar thất bại"
                ];
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }

    }
    public function update_note($params, $id){
        try {
            $params['updated_by'] = Auth::user()->id ?? null;
            $exist = $this->check_exist($id);
            if($exist == false) {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy bản ghi cần sửa"
                ]);
            }
            $model = $this->price_list_repository->updateById($id, $params);
            $result = null;
            if(isset($model->id)){
                $result = [
                    "code"      => 200,
                    "message"   => "Thông tin đã được cập nhật thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thông tin đã được cập nhật không thành công"
                ];
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }

    }
    public function imports($params){
        try {            
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }            
            Excel::import(new PriceListImports($params["auto_send_mail"]), $params['file']);
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::info('Có lỗi xảy ra');
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
}
