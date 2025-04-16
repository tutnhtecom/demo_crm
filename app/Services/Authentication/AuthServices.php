<?php

namespace App\Services\Authentication;

use App\Jobs\SendMailJobs;
use App\Models\BlockAdminssions;
use App\Models\EducationsTypes;
use App\Models\Employees;
use App\Models\Leads;
use App\Models\Marjors;
use App\Models\MethodAdminssions;
use App\Models\Sources;
use App\Models\Students;
use App\Models\User;
use App\Repositories\LeadsRepository;
use App\Repositories\UserRepository;
use App\Services\Employees\EmployeesServices;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthServices implements AuthInterface
{
    use General;
    protected $user_repository;
    protected $leads_repository;
    protected $employees_repository;
    public function __construct(UserRepository $user_repository, LeadsRepository $leads_repository, EmployeesServices $employees_repository)
    {
        $this->user_repository = $user_repository;
        $this->leads_repository = $leads_repository;
        $this->employees_repository = $employees_repository;
    }
    public function get_data_login($params)
    {
        $user = null;
        switch (Auth::user()->types) {
            case User::TYPE_LEADS:
                $user = Leads::with(['marjors', 'user'])->where('email', Auth::user()->email)->orWhere('phone', $params['email'])->first();
                break;
            case User::TYPE_STUDENTS:
                $user = Students::with(['marjors', 'user'])->where('email', $params['email'])->orWhere('phone', $params['email'])->first();
                break;
            case User::TYPE_EMPLOYEES:
                $user = Employees::with('roles')->where('email', $params['email'])
                       ->orWhere('phone', $params['email'])
                       ->first();
                       if(isset($user) && isset($user->name) ) $user->full_name = $user->name;
                break;
        }
        if (isset($user) && $user->user->status == User::NOT_ACTIVE) {
            return ['code' => 422, 'message' => 'Tài khoản chưa được kích hoạt!'];
        }
        $data_leads = null;
        if (isset($user->id)) {
            $data_leads = [
                "id"            => $user->id ?? null,
                "full_name"     => $user->full_name ?? null,
                "code"          => $user->code ?? null,
                "email"         => $user->email ?? null,
                "date_of_birth" => $user->date_of_birth ?? null,
                "gender"        => $user->gender ?? null,
                "marjors"       => $user->marjors ? $user->marjors->name : null,
                "steps"         => $user->steps ?? null,
                "roles_name"    => $user->roles ? $user->roles->name : null,
            ];
        }
        return $data_leads;
    }
    public function login($params){
        $str = $params['email'];
        // Kiểm tra đăng nhập phải email hay không
        $is_email = $this->is_email($str);
        if($is_email == false) {
            switch ($params['types']) {
                case User::TYPE_LEADS:
                    $params['email'] = Leads::where('phone', $str)->first()->email;
                    break;
                case User::TYPE_STUDENTS:
                    $params['email'] = Students::where('phone', $str)->first()->email;
                    break;
                case User::TYPE_EMPLOYEES:
                    $params['email'] = Employees::with(['roles'])->where('phone', $str)->first()->email;
                    break;
            }
        }
        $data_login = [
            "email"     =>  $params['email'],
            "password"  =>  $params['password'],
        ];
        $token = auth()->attempt($data_login);
        session(['tta' => 'tta2']);
        try {
            if (!$token ) {
                return response()->json(['code' => 401, 'message' => 'Tài khoản hoặc mật khẩu chưa đúng' ]);
            }
            $data = null;
            // Kiểm tra trạng thái đăng nhập
            $data_leads = $this->get_data_login($params);
            if(isset($data_leads['code']) && $data_leads['code'] == 422) {
                return $data_leads;
            }

            $data_token = $this->createNewToken($token);

            if(Auth::user()->id !== User::IS_ROOT) {
                $data_token['user']['full_name'] = $data_leads['full_name'];
                $data_token['user']['steps'] = $data_leads['steps'];
                $data = [
                    "code" =>  200,
                    "message" => "Đăng nhập thành công",
                    "data" => $data_token,
                    "data_leads" => $data_leads
                ];
            } else {
                $data_token['user']['full_name'] = "Administrator";
                $data = [
                    "code" =>  200,
                    "message" => "Đăng nhập thành công",
                    "data" => $data_token,
                ];
            }

            return response()->json($data, 200)->cookie('jwt_token', $token, 360, '/', null, false, true, false, 'Lax');
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ], 422);
        }

    }
    private function create_user_for_employees($params){
        $dataUser['status']   = User::NOT_ACTIVE;
        // $params['types']    = User::TYPE_EMPLOYEES;
        $dataUser['types'] = User::TYPE_EMPLOYEES;
        $dataUser['email'] = $params['email'];
        $dataUser['password'] = $params['password'];
        $model = $this->user_repository->create($dataUser);
        return $model;
    }
    private function create_data_employees($params){        
        $data_employees = [
            'name'          => $params['name'],
            'email'         => $params['email'],
            'phone'         => $params['phone'],
            'date_of_birth' => '01/01/2000',
            'password'      => $params["password"]      
            // 'roles_id' => 3,
        ];
        $model = $this->employees_repository->create($data_employees);
        return $model;
    }
    public function register($params){        
        $model = $this->create_user_for_employees($params);
        $this->create_data_employees($params);
        if($model->id) return response()->json(["code" => 200,"message" => "Đăng ký tài khoản thành công" ]);
        else return response()->json([ "code" => 422,"message" => "Đăng ký tài khoản không thành công"]);
    }
    public function logout(){
        session()->flush();
        auth()->logout();
        return response()->json([
            "code" => 200,
            'message' => 'Tài khoản đã đăng xuất thành công'
        ]);
    }
    public function refresh(){
        return $this->createNewToken(auth()->refresh());
    }
    public function userProfile(){
        return response()->json(auth()->user());
    }
    public function changePassWord($params){
        try {
            DB::beginTransaction();
            if(isset($params['old_password']) && isset($params['new_password']) && trim($params['old_password']) === trim($params['new_password'])) {
                return [
                    "code" => 422,
                    "message" => "Mật khẩu mới không được trùng với mật khẩu cũ"
                ];
            }
            $data = [
                'password' => Hash::make(trim($params['new_password']))
            ];
            $userId = auth()->user()->id;
            $user = $this->user_repository->updateById($userId, $data);
            DB::commit();
            return response()->json([
                "code" => 200,
                'message' => 'Người dùng đã thay đổi mật khẩu thành công',
                'user' => $user->toArray(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    // Bổ sung thêm hàm
    protected function createNewToken($token){
        $data = [
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 1440, // 1 ngày
            'user'          => auth()->user()

        ];
        return  $data;
    }
    public function getDataRegister(){
        // $marjors = DB::table('marjors')->select(['id', 'name'])->get();
        $marjors = Marjors::select(['id', 'name'])->get();
        $block_adminssions = BlockAdminssions::select(['id', 'name', 'marjors_id', 'subject'])->get()->toArraY();
        // $sources = DB::table('sources')->select(['id', 'name'])->get();
        $sources = Sources::select(['id', 'name'])->get();
        $blockAdminssions = DB::table('block_adminssions')->select(['id', 'name', 'subject'])->get();
        // $educationTypes = DB::table('educations_types')->select(['id', 'name'])->get();
        $educationTypes = EducationsTypes::select(['id', 'name'])->get();

        // $responseCities = Http::get('https://provinces.open-api.vn/api/?depth=1');
        // $cities = $responseCities->json();
        $responseCities = file_get_contents(public_path('/assets/js/cities.json'));
        $cities = json_decode($responseCities, true);
        $jsonString = file_get_contents(public_path('/assets/js/e.json'));
        $ethnics = json_decode($jsonString, true);
        // $ethnics = [];

        // $responseProvinces = Http::get('https://provinces.open-api.vn/api/?depth=3');
        // $provinces = $responseProvinces->json();
        $responseProvinces = file_get_contents(public_path('/assets/js/provinces.json'));
        $provinces = json_decode($responseProvinces, true);
        $method_adminssions = MethodAdminssions::select(['id', 'name'])->get();
        return [
            "marjors"           => $marjors,
            "block_adminssions" => $block_adminssions,
            "sources"           => $sources,
            "cities"            => $cities,
            "ethnics"           => $ethnics,
            "provinces"         => $provinces,
            // "blockAdminssions"  => $blockAdminssions,
            "educationTypes"    => $educationTypes,
            "method_adminssions"=> $method_adminssions,
        ];

    }
    public function update_profile($params, $id){
        try {
            // Lấy email cũ
            $old_email = null;
            $employees = Employees::where('id', $id)->first();
            $old_email = $employees->email;
            if(Auth::user()->email != $old_email &&  Auth::user()->id != User::IS_ROOT) {
                return [
                    "code"      => 422,
                    "message"   => "Bạn không thể thay đổi thông tin của nhân sự khác"
                ];
            }

            $params['date_of_birth'] = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
            $status_update = $employees->update($params);
            if($status_update) {
                // User::where('email', $old_email)->update([ 'email' => $params['email']]);
                // $this->logout();
                return [
                    "code"      => 200,
                    "message"   => "Cập nhật thông tin thành công"
                ];
            } else {
                return [
                    "code"      => 422,
                    "message"   => "Cập nhật thông tin không thành công"
                ];
            }

        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function getInfoUserLogin(){
        $data = Employees::with(['roles', 'files', 'user'])->where('email', Auth::user()->email)->first();
        return $data;
    }
    public function forgot_password($params){
        $password       = Str::random(16);
        $users = User::where('email', $params['email'])->first();
        if(!isset($users->id)) {
            return [
                "code"      => 200,
                "message"   => "Không tìm thấy email trên hệ thống"
            ];
        }
        $update = $users->update([
            "password"      =>      $password
        ]);
        if(!$update) {
            return [
                "code"      => 422,
                "message"   => "Khôi phục mật khẩu không thành công"
            ];
        }
        // Gửi email thông báo
        $data_sendmail = [
            "title"         => "Khôi phục mật khẩu",
            'subject'       => "Khôi phục mật khẩu",
            'email'         => $params['email'],
            "password"      => $password,
            'to'            => $params['email'],
        ];

        SendMailJobs::dispatch($data_sendmail,'includes.forgot_password');

        return [
            "code"      => 200,
            "message"   => "Khôi phục mật khẩu thành công, mật khẩu đã được gửi về email của bạn."
        ];
    }
    public function send_mail_link_reset($params)
    {
        try {
            if (!isset($params['email'])) {
                return [
                    "code"      => 200,
                    "message"   => "Vui lòng nhập Email"
                ];
            }
            $encode_email = base64_encode($params['email']);
            $data_sendmail = [
                "title"         => "Thông tin thay đổi mật khẩu CRM",
                'subject'       => "Thông tin thay đổi mật khẩu CRM",
                "email"         => trim($params["email"]),
                "to"            => trim($params["email"]),
                "content"       => "Khôi phục mật khẩu",
                "url"           => env('APP_URL') . "/crm/change-password?email=" . $encode_email
            ];
            SendMailJobs::dispatch($data_sendmail, "includes.crm.reset_password_template");
            return [
                "code"      => 200,
                "message"   => "Hệ thống " . env("APP_NAME") . " đã gửi thông tin khôi phục mật khẩu về mail của bạn."
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function reset_password($params){
        try {
            DB::beginTransaction();
            $email = $params['email'];
            $new_password = Hash::make($params['new_password']);
            $data_update = [
                "password"  =>  $new_password
            ];
            $update = User::where('email', $email)->update($data_update);
            $result = null;
            if($update > 0){
                $result = [
                    "code"      => 200,
                    "message"   => "Thay đổi mật khẩu thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thay đổi mật khẩu không thành công"
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
}
