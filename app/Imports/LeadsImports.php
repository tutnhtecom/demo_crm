<?php

namespace App\Imports;

use App\Jobs\CreateContactsJobs;
use App\Jobs\CreateFamilyJobs;
use App\Jobs\CreateLeadsAcademicTermJobs;
use App\Jobs\CreateUserJobs;
use App\Jobs\SendMailJobs;
use App\Models\AcademicTerms;
use App\Models\CustomFieldImports;
use Illuminate\Support\Str;
use App\Models\Employees;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\NotificationsGroups;
use App\Models\Sources;
use App\Models\User;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

// WithValidation
class LeadsImports implements ToModel, WithStartRow, WithChunkReading, WithHeadingRow, SkipsEmptyRows,WithValidation
{
    use Information, General;
    public function startRow(): int
    {
        return 4;
    }
    public function chunkSize(): int
    {
        return 500;
    }
    private function get_code_xlsx($row, $prefix){
        // Lấy id tiếp theo
        $code = isset($row[1]) ?  trim($row[1])  : null;       
        return $code;
    }
    private function get_academic_terms_id($row){                    
        $model = AcademicTerms::where('name', 'LIKE' , '%'. trim($row[25]) .'%')->first();                
        if(isset($model->id)) {
            $id = $model->id;
        } else {
            $create = AcademicTerms::create([
                "name"      => $row[25]
            ]);            
            if(isset($create->id)){
                $id = $create->id;
            }
        }           
        return $id;
    }
    private function getDataContacts($row, $leads_id){      
        $params_contacts = [];  
        if(strlen(trim($row[13])) <= 0 && strlen(trim($row[14])) <= 0 && strlen(trim($row[15])) <= 0 && strlen(trim($row[16])) <= 0 && strlen(trim($row[17])) <= 0 && strlen(trim($row[18])) <= 0 && strlen(trim($row[19])) <= 0 && strlen(trim($row[20])) <= 0){
           return $params_contacts;
        } 
        $prefix_contact = config('app.data.contact_prefix') ?? ['hktt', 'dcll'];
        $params_contacts["leads_id"]    =   $leads_id ?? null;
        $params_contacts["prefix"]      =   $prefix_contact;
        $params_contacts["title_dcll" ] =   'DCLL';
        $params_contacts["title_hktt"]  =   "HKTT";                   
        $params_contacts["created_by" ] = Auth::user()->id ?? null;
        
        // Địa chỉ liên lạc
        if(strlen(trim($row[13])) > 0) $params_contacts["address_dcll"]         =   trim($row[13]);
        if(strlen(trim($row[14])) > 0) $params_contacts["wards_name_dcll"]      =   trim($row[14]);
        if(strlen(trim($row[15])) > 0) $params_contacts["districts_name_dcll" ] =   trim($row[15]);
        if(strlen(trim($row[16])) > 0) $params_contacts["provinces_name_dcll"]  =   trim($row[16]);

        // Hộ khẩu thường trú
        if(strlen(trim($row[17])) > 0) $params_contacts["address_hktt"]         =   trim($row[17]);
        if(strlen(trim($row[18])) > 0) $params_contacts["wards_name_hktt"]      =   trim($row[18]);
        if(strlen(trim($row[19])) > 0) $params_contacts["districts_name_hktt" ] =   trim($row[19]);
        if(strlen(trim($row[20])) > 0) $params_contacts["provinces_name_hktt"]  =   trim($row[20]);
        
        return $params_contacts;
    }
    private function getDataFamily($row, $leads_id){
        $params_family = [];  
        if(strlen(trim($row[21])) <= 0 && strlen(trim($row[22])) <= 0 && strlen(trim($row[23])) <= 0 && strlen(trim($row[24])) <= 0){
            return $params_family;
        } 
        $prefix_family = config('app.data.family_prefix') ??  ['father', 'mother', 'wife'];   
        $params_family = [
            "leads_id"              =>   $leads_id ?? null,
            "prefix"                =>   $prefix_family,
            "title_father"          => "Cha",                        
            "title_mother"          => "Mẹ",                        
            "created_by"            => Auth::user()->id ?? null,
        ];            
        
        if(strlen($row[21]) > 0) $params_family["full_name_father"]         =   trim($row[21]);
        if(strlen($row[22]) > 0) $params_family["phone_number_father"]      =   trim($row[22]);
        
        if(strlen(trim($row[23])) > 0) $params_family["full_name_mother" ]  =   trim($row[23]);
        if(strlen(trim($row[24])) > 0) $params_family["phone_number_mother"]  =   trim($row[24]);        
        return $params_family;
    }
    private function get_custom_field($rows){
        $data = [];
        foreach ($rows as $k => $item) {
            if(substr($k, 0, 2) == 'cf') {
                $data[$k] = $item;
            }
        }
        return $data;   
    }
    private function get_data_custom_field($rows){     
        $get_custom_field = $this->get_custom_field($rows);
        $custom = CustomFieldImports::where('types', CustomFieldImports::TYPE_LEADS)->get()->toArray();       
        $data = [];
        if( count($get_custom_field) > 0 && count($custom) > 0 ) {
            foreach ($custom as $value) {
                foreach ($get_custom_field as $key => $item) {
                    if(strtolower($value['code']) == $key) {
                        $data[$value['name']] = $item;
                    }
                }
            }
        }        
        return $data;
    }    
    private function get_assignments_id($row) {    
        $assignments_id = null;       
        if(!isset($row[9]) && strlen($row[9]) <= 0) { 
            $assignments_id = $this->get_first_employees_id();            
        } else {   
            $condition = [
                "name"     => trim($row[9])
            ];
            $assignments_id = $this->get_data_by_output("employees", $condition, 'id');
        }        
        return $assignments_id;
    }
    public function model(array $row){   
        try {
            DB::beginTransaction();  
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }                 
            $code = $this->get_code_xlsx($row, 'TS');
            $leads_code = $this->get_code_xlsx($row, 'SV');
            $password = Str::random(16);
            $data["code"]                  = $code ?? null;
            $data["leads_code"]            = $leads_code ?? null;
            $data["full_name"]             = trim($row[2]) ?? null;                    
            $data["date_of_birth"]         = strlen(trim($row[3])) ? Carbon::createFromFormat('d/m/Y', trim($row[3]))->format('Y-m-d') : null;
            $data["phone"]                 = trim($row[4]) ?? null;
            $data["home_phone"]            = trim($row[5]) ?? null;
            $data["identification_card"]   = trim($row[6]) ?? null;                
            $data["gender"]                = strlen(trim($row[7])) > 0 ? trim($row[7])  : 0;
            $data["email"]                 = trim($row[8]) ?? null;                
            // $data["assignments_id"]        = Employees::where('name',  'LIKE', '%'.trim($row[9]).'%')->first()->id ?? null;
            $data["assignments_id"]        = $this->get_assignments_id($row);
            $data["lst_status_id"]         = LstStatus::where('name',  'LIKE', '%'.trim($row[10]).'%')->first()->id ?? null;
            $data["sources_id"]            = Sources::where('name',  'LIKE', '%'.trim($row[11]).'%')->first()->id ?? null;
            $data["marjors_id"]            = Marjors::where('name', 'LIKE', '%'.trim($row[12]).'%')->first()->id ?? null;
            $data["created_by"]            = Auth::user()->id ?? null;
            $data["tags_id"]               = $tags->id ?? null;
            $data["place_of_birth"]        = trim($row[14]) ?? null;
            $data["place_of_wrk_lrn"]      = trim($row[15]) ?? null;    
            $custom_data = $this->get_data_custom_field($row);
            $data['extended_fields'] = json_encode($custom_data);
            // $data['academic_terms_id'] = $academic_terms_id;            
            // Load custom field           
            $model = Leads::create($data);           
            if(isset($model->id)){
                // Data users
                $data_user = [
                    "email"         => trim($row[8]),
                    "password"      => Hash::make(trim($password)),
                    "status"        => User::ACTIVE,                    
                    "type"          => User::TYPE_LEADS,
                    "created_by"    => Auth::user()->id ?? null,
                ];  
                CreateUserJobs::dispatch($data_user);
                $gender_name =  strlen(trim($row[7])) > 0 ? Leads::GENDER_MAP[trim($row[7])] : 'Nam';                
                // Địa chỉ - Contacts
                $params_contacts = $this->getDataContacts($row, $model->id);         
                if(count($params_contacts)){
                    $data_contacts = $this->getParamsContacts($params_contacts);
                    CreateContactsJobs::dispatch($data_contacts);
                }
                // Thông tin gia đình
                $params_family = $this->getDataFamily($row, $model->id);    
                
                if(isset($params_family['leads_id'])) {
                    $data_family = $this->getFamilyParrams($params_family);                          
                    CreateFamilyJobs::dispatch($data_family);
                }
                // Thêm mới niên khóa               
                $steps = $this->get_steps($model->id); 
                $params['file_name'] = null;
                $file_name = $this->get_file_name($params, 'includes.crm.mau_thong_bao_dang_ky_tai_khoan_cho_sinh_vien');                
                Leads::where('id', $model->id)->update(["steps" => $steps]);                
                $data_sendmail = [                    
                    "title"         => "Thông tin đăng ký hồ sơ",  
                    'subject'       => "Thông tin đăng ký hồ sơ",              
                    "full_name"     => trim($row[2]) ?? null,  
                    "email"         => trim($row[8]) ?? null, 
                    "phone"         => trim($row[4]) ?? null,           
                    "gender"        => $gender_name,
                    "password"      => isset($data["password"]) ?  trim($data["password"]) : Str::random(16),               
                    'to'            => trim($row[8]) ?? null, 
                    "date_of_birth" => strlen(trim($row[3])) ? Carbon::createFromFormat('d/m/Y', trim($row[3]))->format('d/m/Y') : null,
                    "created_by"    => Auth::user()->id ?? null,
                ];
                SendMailJobs::dispatch($data_sendmail, $file_name);
            }          
            DB::commit();  
            return $model;
        } catch (\Exception $e) {             
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
    public function rules(): array
    {    
        return [
            '1' => ['nullable','max:255', 'min:1', 'unique:leads,leads_code'],
            '2' => ['required','max:255', 'min:1'],
            '3' => ['nullable', 'date_format:d/m/Y', 'before:now'],
            '4' => ['required', 'unique:leads,phone'],
            '5' => ['nullable', 'unique:leads,home_phone', 'max:12', 'min:10'],
            '6' => ['nullable', 'size:12', 'unique:leads,identification_card', 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/'],
            '7' => ['nullable', 'regex:/^[0,1,2]+$/'],
            '8' => ['required','max:255', 'min:1', 'email', 'unique:leads,email', function ($attribute, $value, $fail) {
                $users = User::where('email', $value)->count();                
                if ($users > 0) {
                    $fail('Email: ' . $value .' đã tồn tại');
                }
            }],                       
            '9' => ['nullable',  function ($attribute, $value, $fail) {
                $employees = Employees::where('name', $value)->count();                
                if ($employees <= 0) {
                    $fail('Nhân viên có tên: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '10' => ['required',  function ($attribute, $value, $fail) {
                $status = LstStatus::where('name', $value)->count();                
                if ($status <= 0) {
                    $fail('Trạng thái: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '11' => ['nullable',  function ($attribute, $value, $fail) {
                $sources = Sources::where('name', $value)->count();                
                if ($sources <= 0) {
                    $fail('Nguồn tiếp cận: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '12' => ['nullable',  function ($attribute, $value, $fail) {
                $marjors = Marjors::where('name', $value)->count();                
                if ($marjors <= 0) {
                    $fail('Ngành học: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            // Địa chỉ thường trú
            '13'  => ['nullable'],
            '14'  => ['nullable'],
            '15'  => ['nullable'],
            '16'  => ['nullable'],
            // Hộ khẩu 
            '17'  => ['nullable'],
            '18'  => ['nullable'],
            '19'  => ['nullable'],
            '20'  => ['nullable'],
            // Thông tin gia đình
            '21'  => ['nullable'],            
            '22'  => ['nullable'],
            '23'  => ['nullable'],            
            '24'  => ['nullable'],
            '25'  => ['nullable'],
            '26'  => ['nullable'],
            '27'  => ['nullable'],
            '28'  => ['nullable'],
        ];
    }
    public function customValidationMessages()
    {        
        return [
            // Mã số sinh viên            
            '1.required'        => 'Vui lòng nhập đầy đủ Mã số sinh viên',
            '1.min'             => 'Độ dài tối thiểu 1 ký tự',
            '1.max'             => 'Độ dài tối đa 255 ký tự',
            '1.unique'          => 'Mã số sinh viên đã tồn tại',
            // Họ và tên
            '2.required'        => 'Vui lòng nhập đầy đủ Họ và tên',
            '2.min'             => 'Độ dài tối thiểu 1 ký tự',
            '2.max'             => 'Độ dài tối đa 255 ký tự',           
            // Ngày sinh
            '3.required'        => 'Vui lòng nhập ngày sinh',
            '3.date_format'     => 'Ngày sinh không đúng định dạng d/m/Y',
            '3.before'          => 'Ngày sinh phải nhỏ hơn ngày hiện tại',
            // Số điện thoại
            '4.required'        => 'Vui lòng nhập số điện thoại',
            '4.min'             => 'Độ dài tối thiểu 10 ký tự',
            '4.max'             => 'Độ dài tối đa 12 ký tự',            
            '4.unique'          => 'Số điện thoại đã tồn tại trên hệ thống',
            // Số điện thoại nhà riêng
            '5.required'        => 'Vui lòng nhập Số điện thoại nhà riêng',
            '5.min'             => 'Độ dài tối thiểu 10 ký tự',
            '5.max'             => 'Độ dài tối đa 12 ký tự',            
            '5.unique'          => 'Số điện thoại nhà riêng đã tồn tại trên hệ thống',
            // CCCD
            '6.required'        => 'Vui lòng nhập Căn cước công dân',           
            '6.size'            => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            '6.regex'           => 'Căn cước công dân không đúng định dạng',
            '6.unique'          => 'Căn cước công dân đã tồn tại trên hệ thống',
            // Gender
            '7.required'        => 'Vui lòng chọn giới tính',
            '7.regex'           => 'Giá trị của giới tính thuộc 1 trong các giá trị [0, 1, 2]',   
            // Email
            '8.required'        => 'Vui lòng nhập đầy đủ Email',
            '8.min'             => 'Email phải có ít nhất 1 ký tự',
            '8.max'             => 'Email phải có tối đa 255 ký tự',
            '8.email'           => 'Email không đúng định dạng',
            '8.unique'          => 'Email đã tồn tại trên hệ thống',
            // tư vấn viên
            '9.required'        => 'Vui lòng nhập đầy đủ Tư vấn viên',

            '10.required'       => 'Vui lòng nhập đầy đủ Trạng thái',
            '11.required'       => 'Vui lòng nhập đầy đủ Nguồn tiếp cận',
            '12.required'       => 'Vui lòng nhập đầy đủ Ngành học',
            '13.required'       => 'Vui lòng nhập đầy đủ Địa chỉ thường trú',
            '14.required'       => 'Vui lòng nhập đầy đủ Phường / xã',
            '15.required'       => 'Vui lòng nhập đầy đủ Quận / Huyện',
            '16.required'       => 'Vui lòng nhập đầy đủ Tỉnh / Thành Phố',
            '17.required'       => 'Vui lòng nhập đầy đủ Địa chỉ thường trú',
            '18.required'       => 'Vui lòng nhập đầy đủ Phường / xã',
            '19.required'       => 'Vui lòng nhập đầy đủ Quận / Huyện',
            '20.required'       => 'Vui lòng nhập đầy đủ Tỉnh / Thành Phố',
            '21.required'       => 'Vui lòng nhập đầy đủ Họ tên Cha',            
            '23.required'       => 'Vui lòng nhập đầy đủ Họ tên Mẹ',
            '22.required'       => 'Vui lòng nhập số điện thoại Cha',
            '22.min'            => 'Độ dài tối thiểu 10 ký tự',
            '22.max'            => 'Độ dài tối đa 12 ký tự',            
            // '22.unique'         => 'Số điện thoại Cha đã tồn tại trên hệ thống',
            '24.required'       => 'Vui lòng nhập Số điện thoại Mẹ',
            '24.min'            => 'Độ dài tối thiểu 10 ký tự',
            '24.max'            => 'Độ dài tối đa 12 ký tự',            
            // '24.unique'         => 'Số điện thoại Mẹ đã tồn tại trên hệ thống',
        ];
    }
}
