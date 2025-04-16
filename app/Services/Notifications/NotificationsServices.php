<?php

namespace App\Services\Notifications;

use App\Events\NotificationEvent;
use App\Imports\NotificationImports;
use App\Imports\NotificationsImports;
use App\Jobs\CreateNotificationsJobs;
use App\Jobs\SendMailJobs;
use App\Models\Employees;
use App\Models\Leads;
use App\Models\Notifications;
use App\Models\NotificationsGroups;
use App\Models\Students;
use App\Repositories\NotificationsRepository;
use App\Repositories\TagsRepository;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class NotificationsServices implements NotificationsInterface
{
    use General, Information;
    protected $noti_repository;
    public function __construct(NotificationsRepository $noti_repository)
    {
        $this->noti_repository = $noti_repository;
    }
    public function getNoti($search = null){
        $query = DB::table('notifications')->select(['id', 'created_at', 'title', 'email', 'content']);
        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }
        $query->whereNull('deleted_at');

        return $query->orderBy('created_at', 'DESC')->paginate(10);
    }
    public function index($search) {
        try {
            $record = $params['record'] ?? 10;
            $model = Notifications::select(['id', 'created_at', 'title', 'email', 'content']);
            if($search && strlen($search) > 0) {
                $model = $model->where('title','like', '%'. $search .'%');
            }
            $model = $model->orderBy('id', 'desc')->paginate($record);
            return $model;
          } catch (\Exception $e) {
               Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
               return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
          }
    }
    public function notification_heads() {
        $email = Auth::user()->email;
        $record = 10;
        
        $model = Notifications::with('employees')->where('email', $email)
                    ->where('is_open', Notifications::OPEN_NOT_ACTIVE)
                    ->where('obj_types', Notifications::OBJECT_EMPLOYEES)
                    ->whereIn('send_types', [Notifications::SEND_ALL, Notifications::SEND_SYSTEM]);
        $model = $model->orderby('id', 'desc')
                        ->paginate($record);
        return $model;
    }
    public function details($id) {
       try {
         $model = $this->noti_repository->where('id', $id, '=')->first();
         if(isset($model->id)) {
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
    private function single($params){
        $model = null;
        if(isset($params["email"]) && is_array($params["email"])) {
            $model = $this->multiple($params);
        } else {
            if(isset($params["email"]) && !is_array($params["email"])) {
                $data = [
                    "topic"         => trim($params["topic"]) ?? null,
                    "title"         => trim($params["title"]) ?? null,
                    "content"       => trim($params["content"]) ?? null,
                    "status"        => (int)trim($params["status"]) ?? null,
                    "email"         => trim($params["email"]) ?? null,
                    "obj_types"     => (int)trim($params["obj_types"]) ?? null,
                    "obj_create"    => (int)trim($params["obj_create"]) ?? null,
                    "send_types"    => (int)trim($params["send_types"]) ?? null,
                    "created_by"    => Auth::user()->id ?? 1,
                    "created_at"    => Carbon::now(),
                ];
                $model = $this->noti_repository->create($data);
            }
        }
        return $model;
    }    
    private function multiple($params){        
        // Get data để insert        
        date_default_timezone_set('Asia/Ho_Chi_Minh');        
        if(isset($params['email']) && count($params['email']) > 0) {
            foreach ($params['email'] as $e) {
                $data = [
                    "topic"         => trim($params["topic"]) ?? null,
                    "title"         => trim($params["title"]) ?? null,
                    "content"       => trim($params["content"]) ?? null,
                    "status"        => (int)trim($params["status"]) ?? null,
                    "email"         => trim($e) ?? null,
                    "obj_types"     => (int)trim($params["obj_types"]) ?? null,
                    "obj_create"    => (int)trim($params["obj_create"]) ?? null,
                    "send_types"    => (int)trim($params["send_types"]) ?? null,
                    "created_at"    => Carbon::now(),
                    "created_by"    => Auth::user()->id,
                ];
                CreateNotificationsJobs::dispatch($data);
                $data_sendmail = [
                    "title"         => $data['title'],
                    'subject'       => $data['title'],
                    'content'       => $data['content'],
                    'to'            => $e,
                    'email'         => $e,
                ];              
                SendMailJobs::dispatch($data_sendmail,'includes.notifications');
            }   
        }
        return true;
        // return $model;
    }
    public function single_sendmail($data){
        if(isset($data['email']) && count($data['email']) > 1) {
            $email = explode(', ', $data['email']);
            foreach ($email as $e) {
                $data['email'] = $e;
                $data['to'] = $e;
                $this->call_jobs_send_mail($data);
            }
        } else {
            $this->call_jobs_send_mail($data);
        }
    }
    public function action_by_types($model){

        if($model["send_types"] == Notifications::SEND_ALL || in_array($model['obj_types'], [Notifications::OBJECT_LEADS, Notifications::OBJECT_STUDENTS, Notifications::OBJECT_GROUPS]) ||($model['obj_types'] == Notifications::OBJECT_EMPLOYEES && $model["send_types"] == Notifications::SEND_MAIL)) {
            $this->single_sendmail($model);
        }
    }
    public function get_email_in_notification_groups($id){
        $model  = NotificationsGroups::where('id', $id)->first();        
        if(!isset($model->id)) {
            return [
                "code"      => 422,
                "message"   => "Không tìm thấy nhóm này trên hệ thống"
            ];
        }
        $types  = $model->types;
        $ids    = explode(',', json_decode($model->list_id));      
        if(count($ids) <= 0 ) {
            return [
                "code"      => 422,
                "message"   => "Nhóm này chưa có thành viên nào!"
            ];
        }

        $email = [];
        switch ($types) {
            case 0:
                $email = Leads::whereIn('id', $ids)->get()->pluck('email')->toArray();
                break;
            case 1:
                $email = Students::whereIn('id', $ids)->get()->pluck('email')->toArray();
                break;
            case 2:
                $email = Employees::whereIn('id', $ids)->get()->pluck('email')->toArray();
                break;
        }        
        return $email;
    }
    public function update($params, $id) {
        try {
            $params['updated_by'] = Auth::user()->id ?? null;
            $model = $this->noti_repository->updateById($id, $params);
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
            return response()->json($result);
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }


    }
    public function delete($id) {
        try {
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->noti_repository->updateById($id, $data);
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }

    }   
    private function get_data_notifications() {
        $model = $this->noti_repository->with(['leads', 'students', 'employees', "createBy.employees","updateBy","deleteBy"]);
        return $model;
    }
    private function get_data_notificaions_all($model) {
        $data = [];
        $model = $model->orderBy('id', 'desc')->get()->toArray();        
        foreach ($model as $item) {                   
            switch ($item["obj_create"]) {
                case Notifications::CREATE_LEADS:
                    $item["noti_receiver"] = $item["leads"]["full_name"] ??  '';                    
                    break;
                case Notifications::CREATE_STUDENTS:
                    $item["noti_receiver"] = $item["students"]["full_name"] ?? '';
                    break;
                case Notifications::CREATE_EMPLOYEES:
                    $item["noti_receiver"] = $item["employees"]["name"] ?? '';                    
                    break;
            }                     
            if(isset($item["created_by"]) && $item["created_by"] != null ) {                                                                
                if($item["created_by"] == 1) {                                        
                    $item['sender'] = "Admin";                   
                } else {                    
                    if(isset($item["create_by"]['employees'])) {
                        $item['sender'] = $item["create_by"]['employees']['name'] ?? '';                        
                    }
                }
            } else {
                $item['sender'] = '';
            } 
            $data[] = $item;
        }            
        return $data;
    }
    private function get_data_notificaions_draft($model) {
        $data = [];        
        $model  = $model->where('status', Notifications::DRAFT)->orderBy('id', 'desc')->get()->toArray();    
        foreach ($model as $item) {
            switch ($item["obj_types"]) {
                case Notifications::OBJECT_LEADS:
                    $item["noti_receiver"] = $item["leads"]["full_name"] ??  $item["email"] ;                    
                    break;
                case Notifications::OBJECT_STUDENTS:
                    $item["noti_receiver"] = $item["students"]["full_name"] ?? '';
                    break;
                case Notifications::OBJECT_EMPLOYEES:
                    $item["noti_receiver"] = $item["employees"]["name"] ?? '';
                    break;
            }                     
            if(isset($item["created_by"]) && $item["created_by"] != null ) {                                                                
                if($item["created_by"] == 1) {                                        
                    $item['sender'] = "Admin";                   
                } else {                    
                    if(isset($item["create_by"]['employees'])) {
                        $item['sender'] = $item["create_by"]['employees']['name'] ?? '';                        
                    }
                }
            } else {
                $item['sender'] = '';
            } 
            $data[] = $item;
        }              
        return $data;
    }
    private function get_data_notificaions_send($model) {
        $data = [];        
        $model  = $model->where('status', Notifications::SEND)->orderBy('id', 'desc')->get()->toArray();
        foreach ($model as $item) {                        
            switch ($item["obj_types"]) {
                case Notifications::OBJECT_LEADS:
                    $item["noti_receiver"] = $item["leads"]["full_name"] ??  $item["email"] ;                    
                    break;
                case Notifications::OBJECT_STUDENTS:
                    $item["noti_receiver"] = $item["students"]["full_name"] ?? '';
                    break;
                case Notifications::OBJECT_EMPLOYEES:                   
                    $item["noti_receiver"] = $item["employees"]["name"] ?? '';
                    break;
            }                     
            if(isset($item["created_by"]) && $item["created_by"] != null ) {                                                                
                if($item["created_by"] == 1) {                                        
                    $item['sender'] = "Admin";                   
                } else {                    
                    if(isset($item["create_by"]['employees'])) {
                        $item['sender'] = $item["create_by"]['employees']['name'] ?? '';                        
                    }
                }
            } else {
                $item['sender'] = '';
            } 
            $data[] = $item;
        }
        return $data;
    }
    public function getData(){
        $employees          = DB::table('employees')->select(['id', 'name', 'email'])->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        $students           = DB::table('students')->select(['id', 'full_name', 'email'])->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        $leads              = DB::table('leads')->select(['id', 'full_name', 'email'])->whereNull('deleted_at')->where('active_student', 0)->orderBy('created_at', 'desc')->get();
        $group              = DB::table('notifications_groups')->select(['id', 'name', 'list_id'])->where('list_id','!=',"")->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        
        $notificationsAll = [];
        $notificationsDraft = [];
        $notificationsSend = [];
        
        $notifications      = $this->get_data_notifications();        
        $notificationsAll   = $this->get_data_notificaions_all($notifications);
        $notificationsDraft = $this->get_data_notificaions_draft($notifications);
        $notificationsSend  = $this->get_data_notificaions_send($notifications);        
        $data = [
            'employees'         => $employees,
            'students'          => $students,
            'leads'             => $leads,
            'group'             => $group,
            'notifications_all' => $notificationsAll,
            'notificationsDraft'=> $notificationsDraft,
            'notificationsSend' => $notificationsSend
        ];        
        return $data;
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
            Excel::import(new NotificationsImports, $params['file']);
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
    private function get_data_create($params){
        $types = 0;        
        $obj_create = 0;        
        switch ($params["obj_types"]) {
            case Notifications::OBJECT_LEADS:
                $types = Notifications::OBJECT_LEADS;
                break;
            case Notifications::OBJECT_STUDENTS:
                $types = Notifications::OBJECT_STUDENTS;
                break;
            case Notifications::OBJECT_EMPLOYEES:
                $types = Notifications::OBJECT_EMPLOYEES;
            case Notifications::OBJECT_GROUPS: 
                if(isset($params["groups_id"])) {
                    $model = NotificationsGroups::where('id', $params["groups_id"])->first();
                    if(isset($model->id) && isset($model->types)) {
                        $types = $model->types;
                    }
                }                
                break;                            
        }
        $obj_create = $types;
        return $obj_create;
    }
    // Sửa tạo notification
    // -----------------------------------------------------------------------------------
    public function create($params) {     
        try {
            DB::beginTransaction();            
            $result = null;
            // Xét thêm mới nhiều bản ghi một lúc
            if(isset($params['groups_id']) && !isset($params['email'])) {
                $params['email'] = $this->get_email_in_notification_groups($params['groups_id']);                     
            }  

            $params["obj_create"]   =  $this->get_data_create($params);                  

            
            if(isset($params['File']) || (isset($params['email']) && is_array($params['email']))) {
                if (isset($params['email']) && !is_array($params['email'])) {                    
                    if (str_contains($params['email'], ', '))  $params['email'] = explode(', ', trim($params['email']));
                    if (str_contains($params['email'], ','))  $params['email'] = explode(',', trim($params['email']));
                }                                     
                $status = $this->multiple($params);
                if ($status == true) {
                    // $this->call_jobs_send_mail($params);
                    $result = [
                        "code" => 200,
                        "message" => "Tạo thông báo mới thành công"
                    ];
                } else {
                    $result = [
                        "code" => 422,
                        "message" => "Tạo thông báo mới không thành công"
                    ];
                }
            } else {            
                               
                $model = $this->single($params);
                if (isset($model->id) || count($model) > 0) {
                    $this->call_jobs_send_mail($params);
                    $result = [
                        "code" => 200,
                        "message" => "Tạo thông báo mới thành công"
                    ];
                } else {
                    $result = [
                        "code" => 422,
                        "message" => "Tạo thông báo mới không thành công"
                    ];
                }
            }
            
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }    
    // -----------------------------------------------------------------------------------

}
