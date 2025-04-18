<?php

namespace App\Services\Employees;

use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use App\Jobs\SendMailJobs;
use App\Models\DVLKSemesters;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Employees;
use App\Models\Files;
use App\Models\Kpis;
use App\Models\KpisReports;
use App\Models\KpisStatus;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Notifications;
use App\Models\Tasks;
use App\Models\User;
use App\Models\UserRolePermissions;
use Illuminate\Support\Str;
use App\Repositories\EmployeesRepository;
use App\Repositories\FilesRepository;
use App\Repositories\KpisRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\RolesRepository;
use App\Repositories\UserRepository;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class EmployeesServices implements EmployeesInterface
{
    use General;
    protected $emplyees_repository;
    protected $user_repository;
    protected $file_repository;
    protected $rl_per_repository;
    protected $roles_repository;
    protected $kpis_repository;
    public function __construct(
        EmployeesRepository $emplyees_repository,
        UserRepository $user_repository,
        FilesRepository $file_repository,
        RolePermissionRepository $rl_per_repository,
        RolesRepository $roles_repository,
        KpisRepository  $kpis_repository
    )
    {
        $this->emplyees_repository = $emplyees_repository;
        $this->user_repository = $user_repository;
        $this->file_repository = $file_repository;
        $this->rl_per_repository = $rl_per_repository;
        $this->roles_repository = $roles_repository;
        $this->kpis_repository = $kpis_repository;
    }
    private function filter($params){        
        $model = Employees::with(["user","leads","students","roles", "tasks", "files"]);
        if(isset($params["semesters_id"])) {
            $model =  $model->with(["kpis" => function ($q) use($params){
                $q->where('semesters_id', $params["semesters_id"]);
            }]);
        }
        if (isset($params['keyword'])) {
            $model = $model->where('name', 'LIKE', '%' . $params['keyword'] . '%', )
                ->orWhere('code', $params['keyword'])
                ->orWhere('phone', 'LIKE', '%' . $params['keyword'] . '%')
                ->orWhere('email', 'LIKE', '%' . $params['keyword'] . '%');
        }
        return $model->orderBy('id', 'desc');
    }
    private function set_date_time_for_semesters($params){                
        $model = DVLKSemesters::where("types" , 0);
        if(isset($params["semesters_id"])) {
            $model = $model->where('id', $params["semesters_id"]);
        } else {
            if(isset($params["academy_id"]) && isset($params["current_year"])) {                
                $model = $model->where('academy_id', $params["academy_id"]);                
                if(in_array($params["academy_id"], [1,2])) {
                    $model = $model->where('semesters_to_year', $params["current_year"]);
                } elseif(in_array($params["current_year"], [3,4])) {{
                    $model = $model->where('semesters_from_year', $params["current_year"]);
                }}
            }
        }        
        $model = $model->orderBy('id', 'desc')->first();
        $data = null;
        if($model){
            $data = [
                "semesters_id"  =>  $model->id,
                "from_date"     =>  $model->admission_date,
                "to_date"       =>  Carbon::parse( $model->admission_date)->addMonths(3)->format('Y-m-d')
            ];
        }
        return $data;
    }
    private function get_data_first_semesters(){
        $model = DVLKSemesters::with(['dvlk_transactions'])->where("types", 0)->first();
        return $model->id ?? null;
    }
    public function index($params) {            
        try {
            if(isset($params["semesters_id"])) {
                $data = $this->set_date_time_for_semesters($params);                
                $params["from_date"] = $data["from_date"];
                $params["to_date"]   = $data["to_date"];
            } else {      
                // $model = $this->get_data_first_semesters();                       
                $params["academy_id"] = 1;
                $params["current_year"]   = Carbon::now()->format('Y');  
                $data = $this->set_date_time_for_semesters($params);
                if($data) {
                    $params["semesters_id"] = $data["semesters_id"] ?? null;                
                    $params["from_date"] = $data["from_date"];
                    $params["to_date"]   = $data["to_date"];
                }
            }                              
            
            $model = $this->filter($params);
            $entries = $model->get();
            foreach ($entries as $entry) {   
                $entry['roles_name']        = $entry->roles->name;                                
                $kpis_report                = $this->get_kpis_report_for_employees($params, $entry->id);                               
                $rate                       = isset($params["semesters_id"]) ? $this->get_data_rate_kpis($kpis_report, $entry->id, $params["semesters_id"]) : null;                  
                // Tính tỷ lệ             
                $entry['total_price']       = isset($kpis_report['total_price']) ? number_format($kpis_report['total_price'], 0, ',','.') : 0;
                $entry['total_quantity']    = isset($kpis_report['total_quantity']) ? number_format($kpis_report['total_quantity'] , 0, ',','.') : 0;
                $entry['rate_price']        = isset($rate['rate_price']) ? number_format($rate['rate_price'], 0, ',','.')  : 0;
                $entry['rate_quantity']     = isset($rate['rate_quantity']) ? number_format($rate['rate_quantity'], 0, ',','.') : 0;                
            }   
            return response()->json([
                'code' => 200,
                'data' => $entries
            ]);
        } catch (\Exception $e) {            
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    private function get_kpis_report_for_employees($params, $id) {        
        $model = KpisReports::with(["employees"]);

        if(isset($params["semesters_id"])) {
            $model = $model->where('semesters_id', $params["semesters_id"]);
        }        
        if(isset($params["from_date"])) {            
            $model = $model->where('from_date','>=',$params["from_date"]);
        }
        if(isset($params["to_date"])) {            
            $model = $model->where('to_date', '<=' ,$params["to_date"]);
        }
        $model = $model->groupBy('employees_id') ->select('employees_id',DB::raw('SUM(price) as total_price'), DB::raw('COUNT(DISTINCT leads_id) as total_quantity'))->get();         
        $data = [];
        foreach ($model as $item) {
            $data[$item->employees_id] = [
                "total_price"       =>  $item->total_price ?? 0,
                "total_quantity"    =>  $item->total_quantity ?? 0,
            ];
        }                
        if(isset($data[$id])) {
            return $data[$id];
        } else {
            return null;
        }        
    }
    private function get_total_price($employee, $to_month){        
        $total_price = 0;
        $kpis_reports = $employee->kReports->where('status', KpisReports::TRANS_COMPLETE) ?? null;
        if(isset($kpis_reports)) {
            foreach ($kpis_reports as $item) {
                if($item->created_at->month == $to_month) {
                    $total_price += $item['price'];
                }
            }
        }
        return $total_price;
    }
    private function get_data_reports_by_leads($id = null){            
        $model = Leads::with(['employees']);
        $result = null;
        if(isset($id) && $id !== null) {
            $model = $model->where('assignments_id', $id);
        }         
        $model = $model ->groupBy('assignments_id')
                        ->select('assignments_id',DB::raw('count(id) as count'))
                        ->get()
                        ->pluck('count','assignments_id')
                        ->toArray();
        $result =  0;
        if(isset($model) && count($model) > 0) {
            $result = $model;
            if(isset($id) && $id !== null) {            
                $result = $model[$id];
            }  
        }
        
      
        return $result;
    }
    private function get_data_rate_kpis($kpis_report, $employees_id, $semesters_id) {    
         
        if(!isset($kpis_report['total_quantity'])) $kpis_report['total_quantity'] = 0;
        $data = null;
        $kpis =  Kpis::where('employees_id', $employees_id)->where('semesters_id', $semesters_id)->first();
        
        // dd($kpis_report, $kpis);
        // $kpis = Kpis::where('employees_id', $employees_id)->whereMonth('created_at', Carbon::now()->format('m'))->first();        
        if(isset($kpis->id)){            
            $rate_price = isset($kpis_report['total_price']) && isset($kpis['price']) && $kpis['price'] > 0 ? ($kpis_report['total_price']/$kpis['price'])*100 : 0;            
            $rate_quantity = isset($kpis_report['total_quantity']) && isset($kpis['quantity']) && $kpis['quantity'] > 0 ? ($kpis_report['total_quantity']/$kpis['quantity'])*100 : 0;
            $data = [
                "rate_price"    => $rate_price,
                "rate_quantity" => $rate_quantity
            ];
        }                
        return $data;
    }
    public function details($id) {
        try {            
            $model = Employees::with(["user","leads.contacts","leads.one_contacts","students","roles", "kpis", "tasks", "files", 'kReports', 'lineVoip'])->where('id', $id)->first();
            $kpis_report = $this->get_kpis_report_for_employees($model, $model->id, null);
            // Lấy tổng kpis đạt đượng
            // Tính tỷ lệ
            $rate = $this->get_data_rate_kpis($kpis_report, $model->id, null);
            $model['total_price']       = isset($kpis_report['total_price'])  ? number_format($kpis_report['total_price'],0) : 0;
            $model['total_quantity']    = isset($kpis_report['total_quantity'] ) ? number_format($kpis_report['total_quantity'],0): 0;
            $model['rate_price']        = isset($rate['rate_price'] ) ? number_format($rate['rate_price'] , 0, ',','.') : 0;
            $model['rate_quantity']     = isset($rate['rate_quantity'] ) ? number_format($rate['rate_quantity'], 0, ',','.') : 0;
            if(isset($model->id)){
                $result = [
                    "code"      => 200,
                    "message"   => "Chi tiết nhân viên được tải thành công",
                    "data"      => $model
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Không tìm thấy bản ghi nào"
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
    public function aEmployeeAvatar($employees, $params){
        try {
            $params['title'] = "Ảnh avatar nhân viên";
            $data = [];
            $url = "/assets/upload/employees/" . $employees->code . '/';
            // upload nhiều file
            $type = config('app.data.type_emloyees') ?? 2;
            $data = $this->upload_image($params, $url, $employees->id, $type);
            $data['types'] = Files::TYPE_AVATAR;
            $new_model = Files::create($data);
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

    public function create($params) {
        try {            
            DB::beginTransaction();
            $password               = $params["password"] ?? Str::random(16);
            $maxId                  = Employees::max('id') ? "NV00000" . Employees::max('id') + 1 : "NV" . rand(100000, 999999);
            $data["name"]           = $params["name"] ?? null;
            $data['code']           = $maxId;
            $data["email"]          = $params["email"] ?? null;
            $data['status']         = Employees::ACTIVE ?? 1;
            $data["date_of_birth"]  = isset($params["date_of_birth"]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d') : null;
            $data["phone"]          = $params["phone"] ?? null;
            $data['roles_id']       = $params['roles_id'] ?? 3;            
            $data['line_id']        = $params['line_id_voip'] ?? null;            
            
            if(isset($params["image"]) && $params["image"] != 'undefined' ) {
                $data["image"]      = $params["image"];
            }                       
            $employees = $this->emplyees_repository->create($data);                        
            if (isset($employees->id)) {
                // Kiểm tra email xem có trong bảng user chưa
                $users = User::where('email', $params["email"])->first();
               
                // Thêm mới bảng users
                if (!isset($users->id)) {
                    $data_users = [
                        "status"    => User::ACTIVE,
                        "types"     => User::TYPE_EMPLOYEES,
                        "email"     => $params["email"],
                        "password"  => Hash::make($password)
                    ];
                    $this->user_repository->create($data_users);                    
                }
                // Upload Avatar Employees
                if (isset($params['image'])) {
                    $this->aEmployeeAvatar($employees, $params);
                }

                $data_kpis = [
                    "employees_id" =>  $employees->id,
                    "price"         =>  0,
                    "quantity"      =>  0,
                    "from_date"     =>  Carbon::now()->startOfMonth()->format('Y-m-d'),
                    "to_date"       =>  Carbon::now()->endOfMonth()->format('Y-m-d'),
                    "created_by"    =>  Auth::user()->id ?? NULL,
                ];
                Kpis::create($data_kpis);
                $file_name = null;                       
                if( isset($params["auto_send_mail"]) && $params["auto_send_mail"] == EmailTemplates::AUTO_SEND_MAIL) {                    
                    if(isset($params["file_name"])) {
                        $file_name = isset($params["file_name"]) && view()->exists('includes.template.' . $params["file_name"]) ? 'includes.template.' . $params["file_name"] : 'includes.employee_mail';
                    } else {
                        $types_id = EmailTemplateTypes::where('name', 'LIKE', '%Tài khoản%')->first()->id ?? 5;                        
                        $file_name = $this->get_file_name($types_id);
                    }                    
                    $data_sendmail = [
                        "title"          => "Thông tin đăng ký nhân sự",
                        "subject"        => "Thông tin đăng ký nhân sự",
                        "full_name"      => trim($employees["name"]),
                        "email"          => trim($employees["email"]),
                        "phone"          => trim($employees["phone"]),
                        "date_of_birth"  => trim($employees["date_of_birth"]),
                        "gender"         => $employees["gender"] == 1 ? 'nam' : 'nữ',
                        "password"       => trim($password),
                        'to'             => $params['email'],
                        "date_of_birth"  => trim($employees["date_of_birth"]),
                    ];
                    SendMailJobs::dispatch($data_sendmail, $file_name);
                }
                
                $result = [
                    "code"      => 200,
                    "message"   => "Thêm mới thành công! Thông tin tài khoản đã được gửi về mail " . $params['email'],
                    "data"      => $employees
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thêm mới nhân viên không thành công",
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    private function get_file_name($types_id){        
        $email_template = EmailTemplates::where('title', 'LIKE', '%Nhan su%')->orWhere('types_id', $types_id)->first();
        return 'includes.template.'. $email_template->file_name ?? 'includes.employee_mail';
    }
    public function uEmployeeAvatar($employees, $params) {
        // Remove file ảnh cũ
        $old_image_url = Files::where('employees_id', $employees->id)->first();
        if (isset($old_image_url->id) && file_exists(public_path($old_image_url->image_url))) {
            unlink(public_path($old_image_url->image_url));
            $old_image_url->delete();
        }
        $this->aEmployeeAvatar($employees, $params);
        return true;
    }
    private function compare_roles_id($new_roles_id, $employees_id){
        $status = false; // Trạng thái không thay đổi
        $employees = $this->emplyees_repository->where('id', $employees_id)->first();
        if(isset($employees->id)) {
            if ($employees->roles_id == $new_roles_id) $status = true;
        }
        return $status;
    }
    public function update($params, $id) {
        try {   
            DB::beginTransaction();                 
            $result = null;
            // Email
            $old_email = null;
            $params['date_of_birth'] = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
            $params['roles_id'] = $params['roles_id'] ?? 3;
            $params['line_id']  = $params['line_id_voip'] ?? NULL;
            if(isset($params["email"]) && strlen($params["email"]) > 0) {
                $employees = $this->emplyees_repository->where('id', $id)->first();
                $old_email = $employees['email'];
            }
            $model = $this->emplyees_repository->updateById($id, $params);            
            if(isset($model->id)) {
                // Cập nhật bảng Users dự theo quan hệ
                $update_user = null;
                if((isset($params['email']) && strlen($params['email']) > 0) || (isset($params['password']) && strlen($params['password']) > 0)) {
                    if(isset($params['email']) && strlen($params['email']) > 0) {
                        $update_user['email'] = $params['email'];
                    }
                    if(isset($params['password']) && strlen($params['password']) > 0) {
                        $update_user['password'] = Hash::make($params['password']);
                    }                    
                    $users = User::where('email', $old_email)->first();                    
                    if(isset($users->id)) {
                        $users->update($update_user);                        
                    }
                }
                // cập nhật avatar
                if(isset($params['image'])) {
                    $this->uEmployeeAvatar($model, $params);
                }
                // Cập nhật vai trò và quyền
                // $this->set_users_roles_permission($params['roles_id'], $users->id);
                $result = response() ->json([
                    "code" => 200,
                    "message" => "Cập nhật thành công"
                ]);
            }
            else {
                $result = response() ->json([
                    "code" => 422,
                    "message" => "Cập nhật không thành công"
                ]);
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    private function remove_folder_file($employees){
        // Lấy thư mục image
        $url = public_path("/assets/upload/employees/" . $employees->code);
        $deleted = File::deleteDirectory($url);
        if ($deleted) {
            Files::where('employees_id', $employees->id)->update([
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id,
            ]);
        }
    }
    public function getLeadsEmail($id){
        $email = null;
        if(!is_array($id)) {
            $email = $this->emplyees_repository->where('id', $id)->first()->email;
        } else {
            $email = $this->emplyees_repository->whereIn('id', $id)->get()->pluck('email')->toArray();
        }
        return $email;
    }
    private function delete_relationship_lead_by_ids($params){
        $email = $this->getLeadsEmail($params['ids']);
        // Delete user by email
        $user_delete = $this->delete_by_list_id('users','email' , $email);
        // Delete Thong bao
        $notifications_delete = $this->delete_by_list_id('notifications','email' , $email);
        // Delete kpis for employees
        $kpis_delete = $this->delete_by_list_id('kpis','employees_id' , $params['ids']);
        // Delete Task
        $task_delete = $this->delete_by_list_id('tasks','employees_id' , $params['ids']);
        return [
            "user_delete"           => $user_delete,
            "notifications_delete"  => $notifications_delete,
            "kpis_delete"           => $kpis_delete,
            "task_delete"           => $task_delete,
        ];
    }
    public function delete_multiple($params) {
        try {
            DB::beginTransaction();
            // Xóa bảng user
            $relationship = $this->delete_relationship_lead_by_ids($params);
            $employees_delete = $this->delete_by_list_id('employees','id' , $params['ids']);
            $result = null;
            if($employees_delete == true) {
                $result = [
                    "code"      => 200,
                    "message"   => "Xóa danh sách thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Xóa danh sách không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function delete($id) {
        try {
            DB::beginTransaction();
            $model = $this->emplyees_repository->with(['user', 'files'])->updateById($id, [
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id,
            ]);
            $model->user->update([
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id,
            ]);
            $users_id = $model->user->id;
            // Xóa file
            $this->remove_folder_file($model);
            // Xóa phân quyền
            UserRolePermissions::where('users_id', $users_id)->delete();
            Notifications::where('email', $model->email)->update([
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id
            ]);
            Kpis::where('employees_id', $model->id)->update([
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id
            ]);
            Tasks::where('employees_id', $model->id)->update([
                "deleted_at" => Carbon::now(),
                "deleted_by" => Auth::user()->id
            ]);

            $result = null;
            if(strlen($model->deleted_at)) {
                $result = response() ->json([
                    "code" => 200,
                    "message" => "Xóa bỏ nhân sự thành công"
                ]);
            } else {
                $result = response() ->json([
                    "code" => 422,
                    "message" => "Xóa bỏ nhân sự không thành công"
                ]);
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }


    }
    public function exports($params){
        $query = $this->filter($params);
        $data = $query->get();
        $file_name = "danh_sach_nhan_su_" . date('d-m-Y'). '.xlsx';
        return Excel::download(new EmployeesExport($data), $file_name);
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
            Excel::import(new EmployeesImport, $params['file']);
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
    public function change_status($id){
        $result = null;
        $model = Employees::where('id', (int)$id)->where('status', Employees::ACTIVE)->first();
        if(isset($model->id)) {
            $model =  $model->update(['status' => Employees::NOT_ACTIVE]);
            $result = [
                "code"      => 200,
                "message"   => "Cập nhật trạng thái thành công"
            ];
        } else {
            $result = [
                "code"      => 422,
                "message"   => "Cập nhật trạng thái không thành công! Nhân viên đã ở trạng thái ngừng hoạt động"
            ];
        }
        return $result;
    }
    public function dataRole(){
        // $role = DB::table('roles')->select(['id', 'name'])->get();
        $role   = $this->roles_repository->get();
        return $role;
    }

    public function dataStatus(){
        $status = LstStatus::select(['id', 'name', 'color', 'bg_color', 'border_color'])->get();
        return [
            "status" => $status,
        ];
    }

    public function active_system($params){
        try {
            DB::beginTransaction();
            if(!isset($params['email'])) {
                return [
                    "code"      => 422,
                    "message"   => "Vui lòng nhập email của nhân viên"
                ];
            }
            $employees = Employees::where('email', $params['email'])->first();
            if(!isset($employees->id)) {
                return [
                    "code"      => 422,
                    "message"   => "Email không tồn tại trên hệ thống"
                ];
            }

            $users = User::where('email', $params['email'])->where('types', User::TYPE_EMPLOYEES)->first();
            if(!isset($users->id)) {
                return [
                    "code"      => 422,
                    "message"   => "Nhân viên chưa có tài khoản"
                ];
            }        
            $update = 0;
            $result = null;
            $data = [
                "status"    =>   1
            ];            
            $update =  $users->update($data);                        
            if($update) {
                $result = response()->json([
                    "code" => 200,
                    "message" => "Kích hoạt tài khoản thành công"
                ]);
            } else {
                $result = response()->json([
                    "code" => 422,
                    "message" => "Kích hoạt tài khoản không thành công"
                ]);
            }    
            
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
        
    }
}
