<?php

namespace App\Traits;

use App\Jobs\CreateNotificationsJobs;
use App\Jobs\SendMailJobs;
use App\Jobs\UpdateReplationshipJobs;
use App\Models\Contacts;
use App\Models\DegreeInformations;
use App\Models\DVLKSemesters;
use App\Models\Employees;
use App\Models\FamilyInformations;
use App\Models\Files;
use App\Models\Leads;
use App\Models\Notifications;
use App\Models\PriceLists;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Information
{   
    use General;
    public function getParamsContacts($params){              
        $data = [];                
        if(isset($params['prefix']) && count($params['prefix']) > 0){            
            foreach ($params['prefix'] as $value) {
                $title = $params['title_' . $value];                
                $data[] = [
                    "type"              => Contacts::CONTACTS_MAP_ID[$title] ?? null,
                    "title"             => Contacts::CONTACTS_MAP_TEXT[$title] ?? null,
                    "provinces_name"    => $params['provinces_name_'.$value] ?? null,
                    "districts_name"    => $params['districts_name_'.$value] ?? null,
                    "wards_name"        => $params['wards_name_'.$value] ?? null,
                    "address"           => $params['address_'.$value] ?? null,
                    "leads_id"          => $params['leads_id'] ?? null,
                    "students_id"       => $params['students_id'] ?? null,
                    "created_by"        => Auth::user()->id ?? null
                ];
            }             
        }
        return $data;
    }
    function get_data_items($params, $v){                
        $items = null;        
        $title = isset($params['title_' . $v]) ?  trim($params['title_' . $v]) : null;
        $items["title"]      = FamilyInformations::FAMILY_MAP_TEXT[$title];
        $items["type"]       = FamilyInformations::FAMILY_MAP_ID[$title];
        $items["created_by"] = Auth::user()->id ?? null;
        if(isset($params['leads_id'])) {                        
            $items["leads_id"] = $params['leads_id'] ?? null;
        }  
        if(isset($params['students_id'])){
            $items["students_id"]  = $params['students_id'] ?? null;
        } 
        if(isset($params['full_name_' . $v])) {
            $items["full_name" ]  = trim($params['full_name_' . $v]);
        } 
        if(isset($params['phone_number_' . $v])) {
            $items["phone_number"]     = trim($params['phone_number_' . $v]);
        } 
        if(isset($params['year_of_birth_' . $v])) {
            $items["year_of_birth"]  = trim($params['year_of_birth_' . $v]);
        } 
        if(isset($params['jobs_'. $v])) {
            $items["jobs"] = trim($params['jobs_'. $v]) ?? null;
        }  
        if(isset($params['education_id_'. $v])){
            $items["education_id"]     = trim($params['education_id_'. $v]) ?? null;
        }
        return $items;
    }
    public function getFamilyParrams($params){                
        $data = [];              
        if(isset($params['prefix']) && count($params['prefix']) > 0){            
            foreach ($params['prefix'] as $v) {                
                if(isset($params['full_name_' . $v]) && strlen($params['full_name_' . $v]) > 0) {
                    $items = $this->get_data_items($params, $v);                    
                    $data[] = $items;
                }
            }
        }                        
        return $data;  
    }
    public function get_parrams_degree($params){
        $data = [];        
        foreach ($params['prefix'] as $p) {
            $data[] = [
                "title"                 => $params['title_' . $p] ?? null,
                "leads_id"              => $params['leads_id'] ?? null,  
                "students_id"           => $params['students_id'] ?? null,  
                "type_id"               => $params['type_id_' . $p] ?? null,
                "year_of_degree"        => $params['year_of_degree_' . $p] ?? null,
                "date_of_degree"        => isset($params["date_of_degree_" . $p]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_of_degree_" . $p]) )->format('Y-m-d') : null,
                "serial_number_degree"  => $params['serial_number_degree_' . $p] ?? null,
                "place_of_degree"       => $params['place_of_degree_' . $p] ?? null,
                "created_by"            => Auth::user()->id ?? null
            ];
        }        
        return $data;
    }   
    public function get_steps($leads_id){            
        $steps = 0;
        $contacts   = Contacts::where('leads_id', $leads_id)->count();
        if($contacts > 0) $steps = Leads::CONTACTS;
        $family     = FamilyInformations::where('leads_id', $leads_id)->count();
        if($family > 0) $steps = Leads::FAMILY;
        $degree     = DegreeInformations::where('leads_id', $leads_id)->count();
        if($degree > 0) $steps = Leads::SCORE;
        $files      = Files::where('leads_id', $leads_id)->where('types', Files::TYPE_PROFILE)->count();
        if($files > 0) $steps = Leads::CONFIRM;        
        return $steps;
    }   
    function get_first_employees_id(){
        $data = $this->count_employees_in_leads();   
        if(count($data) > 0) {
            $min = array_keys($data, min($data));        
        }
        return $min[0] ?? '';       
    }
    function count_employees_in_leads(){
        $model = Employees::with(['leads'])
                ->where('roles_id', '!=', User::ACTIVE)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();  
        $data = [];
        foreach ($model as $item) {
            $data[$item['id']] = count($item['leads']);
        }        
        return $data;
    }
    function set_assignments_id($table, $codition, $params){
                
        $assignments_id = $this->get_data_by_output($table, $codition, 'assignments_id');
        if(strlen($assignments_id) <= 0 ) {
            $assignments_id = isset($params['employees_id'])  ? $params['employees_id'] : $this->get_first_employees();
        }        
        return $assignments_id;
    }
    function get_first_employees(){       
        $model =  DB::table('leads')
                ->join('employees', 'leads.assignments_id', '=', 'employees.id')
                ->select('employees.id',DB::raw('count(leads.id) as dem'))
                ->where('employees.roles_id', '!=', User::ACTIVE)
                ->groupBy('employees.id')
                ->orderBy('dem', 'asc')
                ->get();                  
        $emplyees_id = null;        
        if(count($model) > 0) {
            $emplyees_id = $model[0]->id;
        }         
        return $emplyees_id ?? null;
    }
    function create_notification($model, $content, $title){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        try {            
            $data_notifications = [
                "title"         =>  $title,
                "content"       =>  $content,
                "email"         =>  $model->employees->email,
                "obj_types"     =>  Notifications::OBJECT_EMPLOYEES,
                "send_types"    =>  Notifications::SEND_ALL,
                "is_open"       =>  Notifications::OPEN_NOT_ACTIVE,
                "status"        =>  0,
                "created_at"    =>  Carbon::now(),
                "created_by"    =>  Auth::user()->id ?? null,
            ]; 
            CreateNotificationsJobs::dispatch($data_notifications);
            return true;
        } catch (\Exception $e) {   
            Log::error('Thông báo lỗi: ' . $e->getMessage());
       }
    }
    function update_multiple_relationship($data_relationship){        
        foreach ($data_relationship as $key => $value) {
            $conditons = [
                "leads_id"  => $key
            ];
            $data = [
                "students_id"=> $value
            ];                        
            UpdateReplationshipJobs::dispatch('family_informations', $conditons, $data);
            UpdateReplationshipJobs::dispatch('contacts', $conditons, $data);
            UpdateReplationshipJobs::dispatch('price_lists', $conditons, $data);
            UpdateReplationshipJobs::dispatch('transactions', $conditons, $data);
            UpdateReplationshipJobs::dispatch('degree_informations', $conditons, $data);
            UpdateReplationshipJobs::dispatch('score_adminssions', $conditons, $data);
            UpdateReplationshipJobs::dispatch('files', $conditons, $data);
        }
    }  
    function allow_send_mail($params){        
        $status = false;
        if($params['obj_types'] == Notifications::OBJECT_LEADS || $params['obj_types']  == Notifications::OBJECT_STUDENTS || $params["send_types"] == Notifications::SEND_ALL) {
            $status = true;
        } else {
            if($params['obj_types'] == Notifications::OBJECT_EMPLOYEES &&  $params["send_types"] == Notifications::SEND_MAIL) {
                $status = true;
            }
        }        
        return $status;
    } 
    function call_jobs_send_mail($data){        
        $status = $this->allow_send_mail($data);
        if($status == true) {            
            if(isset($data['email']) && is_array($data['email'])) {                
                foreach ($data['email'] as $email) {
                    $data_sendmail = [
                        "title"         => $data['title'],
                        'subject'       => $data['title'],
                        'content'       => $data['content'],
                        'to'            => $email,
                        'email'         => $email,
                    ];
                    SendMailJobs::dispatch($data_sendmail,'includes.notifications');
                }
            } else {                
                $data_sendmail = [
                    "title"         => $data['title'],
                    'subject'       => $data['title'],
                    'contents'      => $data['content'],
                    'content'       => $data['content'],
                    'to'            => $data['email'],
                    'email'         => $data['email'],
                ];
                SendMailJobs::dispatch($data_sendmail,'includes.notifications');
            }
        }
    }
    private function check_students($params){
        $status = false;
        $dem_email = Students::where('marjors_id', $params["marjors_id"])->where('email', $params["email"])->count();
        if($dem_email > 0) {
            $status = true;
        }
        $dem_phone = Students::where('marjors_id', $params["marjors_id"])->where('phone', $params["phone"])->count();
        if($dem_phone > 0) {
            $status = true;
        }
        return $status;
    }
    function data_for_insert($item) {
        $new_data["full_name"] = $item['full_name'] ?? null;
        $new_data["code"] = $item['code'] ?? null;
        $new_data["assignments_id"] = $item['assignments_id'] ?? null;
        $new_data["email"] = $item['email'] ?? null;
        $new_data["phone"] = $item['phone'] ?? null;
        $new_data["home_phone"] = $item['home_phone'] ?? null;
        $new_data["avatar"] = $item['avatar'] ?? null;
        $new_data["date_of_birth"] = $item['date_of_birth'] ?? null;
        $new_data["gender"] = $item['gender'] ?? null;
        $new_data["identification_card"] = $item['identification_card'] ?? null;
        $new_data["date_identification_card"] = $item['date_identification_card'] ?? null;
        $new_data["place_identification_card"] = $item['place_identification_card'] ?? null;
        $new_data["place_of_birth"] = $item['place_of_birth'] ?? null;
        $new_data["place_of_wrk_lrn"] = $item['place_of_wrk_lrn'] ?? null;
        $new_data["sources_id"] = $item['sources_id'] ?? null;
        $new_data["marjors_id"] = $item['marjors_id'] ?? null;
        $new_data["academic_terms_id"] = $item['academic_terms_id'] ?? null;
        $new_data["nations_name"] = $item['nations_name'] ?? null;
        $new_data["ethnics_name"] = $item['ethnics_name'] ?? null;
        $new_data["date_of_join_youth_union"] = $item['date_of_join_youth_union'] ?? null;
        $new_data["date_of_join_communist_Party"] = $item['date_of_join_communist_Party'] ?? null;
        $new_data["company_name"] = $item['company_name'] ?? null;
        $new_data["company_address"] = $item['company_address'] ?? null;
        $new_data["lst_status_id"] = $item['lst_status_id'] ?? null;
        $new_data["tags_id"] = $item['tags_id'] ?? null;
        $new_data['students_code'] = $item['leads_code'];
        $new_data['academic_terms_id'] = $item['academic_terms_id'];
        $new_data['leads_id'] = $item['id'];
        $new_data['created_at'] = Carbon::now();
        $new_data['created_by'] = Auth::user()->id;
        return $new_data;
    }
    public function get_data_student($model){
        $data = [];
        if(!isset($model["id"]) && count($model) > 0) {
            foreach ($model as $item) {
                // $status = $this->check_students($item);
                $data[] = $this->data_for_insert($item);
            }
        } else {
            $data = $this->data_for_insert($model);
        }
        return $data;
    }
    function convert_multiple_leads_to_students($params){
        try {
            DB::beginTransaction();
            if(!isset($params['ids']) && count($params['ids']) <= 0){
                return [
                    "code"      => 422,
                    "message"   => "Vui lòng chọn sinh viên tiềm năng"
                ];
            }            
            $model = Leads::with(['students', 'contacts', 'files', 'family'])->whereIn('id', $params['ids'])->get()->toArray();            
            $data = $this->get_data_student($model);            
            $students = null;          
            if(isset($this->st_repository)) {
                $students = $this->st_repository->createMultiple($data);                            
            } else {
                // Them moi thanh cong
                Students::insert($data);   
                $students = Students::whereIn('leads_id', $params['ids'])->get();                
            }
            $result = null;
            if (count($students) > 0) {
                // Update students_id for contact, family
                $data_relationship = $students->pluck('id', 'leads_id')->toArray();                
                // Update relations
                $this->update_multiple_relationship($data_relationship);
                Leads::whereIn('id', $params['ids'])->update([
                    'active_student'    =>  Leads::ACTIVE_STUDENTS
                ]);
                $result = [
                    "code"      => 200,
                    "message"   => "Chuyển đổi thành sinh viên chính thức thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Chuyển đổi thành sinh viên chính thức không thành công"
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
    function get_random_code($table) {
        $total_length       = 6;        
        $max_id             = DB::table($table)->max('id');
        $len_max_id         = strlen($max_id);
        $str_code           = null;  
        $code               = null;
        for ($i = $len_max_id; $i < $total_length; $i++) { 
            $str_code .= '0';
        }
        $code = $str_code . ($max_id+1);        
        return $code;        
    }
    
    function get_data_dvlk_semesters($params)
    {
        $model  = DVLKSemesters::select(['id', 'types', 'note', 'academy_id',"semesters_from_year","semesters_to_year","semesters_full_year","admission_date",])->where('types', 0);        
        $model=$model->get();
        foreach ($model as $item) {
            $item->note  = preg_replace([
                '/năm (\d+)/',   // Thay "năm" + số (VD: năm 2025 → / 2025)
                '/nhập học vào/' // Thay "nhập học vào" → "-"
            ], [
                '/ $1',  // Thay "năm 2025" → "/ 2025"
                '-'      // Thay "nhập học vào" → "-"
            ], $item->note);
        }
        return $model;
    }
}