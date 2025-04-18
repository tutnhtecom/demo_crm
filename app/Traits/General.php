<?php

namespace App\Traits;

use App\Jobs\CreateUserRolesPermissionsJobs;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Files;
use App\Models\NotificationsGroups;
use App\Models\RolePermissions;
use App\Models\Sources;
use App\Models\User;
use App\Models\UserRolePermissions;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isEmpty;
trait General
{
    protected $POST = 'POST';
    protected $GET  = 'GET';
    protected $CONTENT_TYPE_JSON =  'application/json';
    protected $CONTENT_TYPE_JS =  'application/javascript';
    protected $CONTENT_MULTI_FORM_DATA = 'multipart/form-data';
    protected $CONTENT_FORM_URLENCODED = 'application/x-www-form-urlencoded';

    // Loại bỏ dấu
    function removeVietnameseAccents($str) {
        $accents = [
            'a' => ['à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ'],
            'A' => ['À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ'],
            'e' => ['è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ'],
            'E' => ['È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ'],
            'i' => ['ì', 'í', 'ị', 'ỉ', 'ĩ'],
            'I' => ['Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ'],
            'o' => ['ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ'],
            'O' => ['Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ'],
            'u' => ['ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ'],
            'U' => ['Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ'],
            'y' => ['ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ'],
            'Y' => ['Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ'],
            'd' => ['đ'],
            'D' => ['Đ']
        ];
        foreach ($accents as $nonAccent => $accentedChars) {
            $str = str_replace($accentedChars, $nonAccent, $str);
        }
        return $str;
    } 
    function remove_one_space($new_name) {
        $str = null;
        for ($i = 0; $i < strlen($new_name); $i++) {
            if($new_name[$i] == ' ') $str .= $new_name[$i+1];
        }  
        return $str;
    }
    function remove_prefix($str){
        $new_str = null;              
        if(strlen(strpos(strtoupper($str), "TINH")) > 0) {
            $new_str = str_replace(strtoupper("TINH"),"",strtoupper($str));  
        } elseif(strlen(strpos(strtoupper($str), "THANH PHO")) > 0) {   
            $new_str = str_replace(strtoupper("THANH PHO"),"",strtoupper($str));  
        } elseif(strlen(strpos(strtoupper($str), "TP")) > 0) {   
            $new_str = str_replace(strtoupper("TP"),"",strtoupper($str));  
        } else {
            $new_str = $str;
        }
        return strtoupper(trim($new_str));
    }
    function get_code_from_name($name) {
        // Xoa dau ky tu
        $rm_name = $this->removeVietnameseAccents($name);        
        $rm_prefix_name = $this->remove_prefix($rm_name);                        
        $code = str_replace(' ', '', $rm_prefix_name);
        $dem = Sources::where('code', 'LIKE', '%'.$code.'%')->count();         
        $new_code = $code . ($dem < 10 ? '0' . ($dem+1) : $dem+1);          
        return $new_code;
    } 
    function get_prefix_from_name($name){
        $rm_name = $this->removeVietnameseAccents($name);
        $code = null;
        $first_name = $rm_name[0];
        $last_name  = null;
        for ($i=0; $i < strlen($rm_name) ; $i++) { 
            if($rm_name[$i] == ' ') {
                $last_name .= $rm_name[$i+1];
            }
        }
        $code = $first_name . $last_name;        
        return strtoupper($code);
    }
    function slugify($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    function slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '_', $string);
        $string = strtolower($string);
        return $string;
    }
    function rand_str($strength = 16)
    {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }
    function sendmail($data, $view)
    {        
        try {
            Mail::send($view, $data, function ($message) use ($data) {
                $message->to($data['to'])->subject($data['subject']);
            });            
            return response()->json([
                "code" => 200,
                "message" => "Gửi mail đăng ký thành công"
            ]);
        } catch (\Exception $e) {            
            Log::error("Thông báo lỗi gửi mail: " . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => "Gửi mail đăng ký thất bại"
            ]);
        }
    }
    function upload_file($param, $url, $id = null)
    {
        $image = $param['File'];
        $name = str_replace(' ', '_', $image->getclientoriginalname());
        $image->move(public_path($url), $name);
        $data = [
            "title"     => $param['title'],
            "image_url" => $url . $name,
            "created_by" => $id
        ];
        if (isset($id) && strlen($id) > 0) {
            $data["leads_id"] = $id;
        }
        if (isset($param['email']) && strlen($param['email']) > 0) {
            $data["email"] = trim($param['email']);
        }
        return $data;
    }
    // Upload 1 ảnh
    // Có thể truyền tên ảnh $tinymceUpload để đảm bảo tính duy nhất
    function upload_image($param, $url, $id, $type, $tinymceUpload = false)
    {
        $image = $param['image'];
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            $name = $tinymceUpload ? $tinymceUpload : str_replace(' ', '_', $image->getclientoriginalname());
            $image->move(public_path($url), $name);
            $data = [
                "title"     => $param['title'],
                "image_url" => $url . $name,
                "created_by" => $id
            ];
            switch ($type) {
                case config('app.data.type_leads'):
                    $data["leads_id"] = $id;
                    $data['types'] = Files::TYPE_AVATAR;
                    break;
                case config('app.data.type_students'):
                    $data["students_id"] = $id;
                    $data['types'] = Files::TYPE_AVATAR;
                    break;
                case config('app.data.type_emloyees'):
                    $data["employees_id"] = $id;
                    $data['types'] = Files::TYPE_AVATAR;
                    break;
                default:
                    $data["leads_id"] = $id;
                    $data['types'] = Files::TYPE_AVATAR;
                    break;
            }
            return $data;
        }
    }
    // Upload nhiều ảnh
    function upload_images($params, $url, $id)
    {      
        $data = [];
        if(isset($params['images'])) {            
            foreach ($params['images'] as $image) {              
                $name = str_replace(' ', '_', $image->getclientoriginalname());               
                $image->move(public_path($url), $name);
                $data[] = [
                    "title" => "Hồ sơ và văn bằng",
                    "leads_id" => $id ?? null,
                    "image_url" => $url . $name ?? null,
                    "created_by" => Auth::user()->id ?? 1
                ];
            }
        }
        return $data;
    }
    function import_file_txt($files)
    {
        // Open the file
        $file = fopen($files->getRealPath(), 'r');
        $params = [];
        while (($row = fgetcsv($file)) !== false) {
            if ($row[array_keys($row)[0]] !== null) $params[] = $row;
        }
        $data = [];
        foreach ($params as $key => $value) {
            $data[] = $value[0];
        }
        fclose($file);
        return  $data;
    }
    function import_file_xls($files)
    {
        // Đọc file Excel
        $spreadsheet = IOFactory::load($files);
        $params = $spreadsheet->getActiveSheet()->toArray();
        $data = [];
        foreach ($params as $key => $value) {
            $data[] = $value[0];
        }
        return  $data;
    }
    function unset_array($data, $key)
    {
        if(is_array($key)){
            foreach ($key as $k) {
                unset($data[$k]);
            }
        } else {
            unset($data[$key]);
        }                    
        return $data;
    }
    // Xóa folder
    function remove_folder_file($url)
    {
        // Lấy thư mục image
        $url = public_path($url);
        $delete = File::deleteDirectory($url);
        return $delete;
    }
    // get reponse api
    protected function apiBase($url, $method, $postData, $content_type)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,   // CURLOPT_TIMEOUT => 30 (Image upload may need)
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type:' . $content_type,
                'Access-Control-Allow-Origin: *',
                'token:' . session('store.token'),
            ),
            // CURLOPT_SSL_VERIFYPEER => false, // Image upload may need
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    protected function apiDataNotification($url)
    {
        $response = $this->apiBase($url, $this->GET, null, $this->CONTENT_TYPE_JSON);
        return $response;
    }
    function getAddress($contacts)
    {
        $address = null;
        $districts_name = isset($contacts->districts_name) ? $contacts->districts_name . ', ' : '';
        $provinces_name = isset($contacts->provinces_name) ? $contacts->provinces_name : '';
        $address = $districts_name . $provinces_name;
        return $address;
    }
    function check_email($email)
    {
        $status = false;
        $check_email = User::where('email', $email)->count();
        if ($check_email > 0) {
            $status = true;
        }
        return $status;
    }
    function is_email($str)
    {
        $status = false;
        $str_email = str_contains($str, '@');
        if ($str_email) $status = true;
        return $status;
    }
    function get_next_id($table)
    {
        $next_id = null;
        $next_id = DB::table($table)->max('id')+1 ?? 1;
        return $next_id;
    }
    function get_code($string){
        $str = isset($string) ? $this->get_code_from_name($string) : null;
        return $str;
    }
    function get_code_xlsx($row, $prefix)
    {        
        // Lấy id tiếp theo
        $id = $this->get_next_id('leads');
        $code = !isEmpty(trim($row[1])) ? trim($row[1]) : (isEmpty($id) ? $prefix . "0000" . $id : $prefix . rand(100000, 999999));
        return $code;
    }
    function delete_by_condition($table, array $condition)
    {
        $model = DB::table($table)->whereNull('deleted_at')->where($condition);
        $delete = null;
        if (isset($model->first()->id)) {
            $delete = $model->update([
                "deleted_at"    => Carbon::now(),
                "deleted_by"    => Auth::user()->id
            ]);
        }
        return $delete;
    }
    function delete_by_list_id($table, $fields,  array $values)
    {
        $model = DB::table($table)->whereNull('deleted_at')->whereIn($fields, $values)
            ->update([
                "deleted_at"    => Carbon::now(),
                "deleted_by"    => Auth::user()->id
            ]);
        if ($model > 0) {
            return true;
        } else {
            return false;
        }
    }
    function get_date($params)
    {
        return [
            "from_date" => isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y-m-d') : null,
            "to_date"   => isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y-m-d') : null
        ];
    }
    function get_leads_id($params)
    {
        $groups = NotificationsGroups::where('id', $params['groups_id'])->first();
        $leads_id = explode(',', json_decode($groups->list_id));
        return $leads_id ?? null;
    }
    function get_data_by_output($table, $condition, $output){
        $model = DB::table($table)->whereNull('deleted_at');        
        if($condition !== null) {
            $model = $model->where($condition);
        }        
        $model = $model->first();        
        return $model->$output ?? null;
    }
    function get_data_by_fields($table, $condition){
        $model = DB::table($table)->whereNull('deleted_at');        
        if($condition !== null) {
            $model = $model->where($condition);
        }        
        $model = $model->first();        
        return $model ?? null;
    }
    function get_data_id($table, $id, $output)
    {
        $model = DB::table($table)->whereNull('deleted_at')->where('id', $id)->first();
        return $model->$output ?? null;
    }
    function get_data_id_by_condition_expend($table, $condition, $condition2 = null){        
        $model = DB::table($table)->whereNull('deleted_at')->where($condition);        
        if(isset($condition2) && $condition2 != null) {
            $model = $model->where($condition2);
        }
        $model = $model->first();
        return $model->id ?? null;
    }
    function update_d_email_status_by_id($table, $id)
    {
        $model = DB::table($table)
                ->where('id', $id)
                ->update(['d_email_status' => 1]);
        return $model ?? null;
    }
    function get_data_id_by_condition($table, $condition){        
        $model = DB::table($table)->whereNull('deleted_at')->where($condition)->first();                    
        return $model->id ?? null;
    }
    function get_data_array_id($table, $fields , $array){
        $model = DB::table($table)->whereNull('deleted_at')->whereIn($fields, $array)->get()->pluck('id')->toArray();
        return $model ?? null;
    }
    function get_output_by_array_id($table, $fields ,$array, $output){
        $model = DB::table($table)->whereNull('deleted_at')->whereIn($fields, $array)->get()->pluck($output)->toArray();
        return $model ?? null;
    }
    function get_data_email($table, $ids){
        $email = DB::table($table)->whereNull('deleted_at')->whereIn('id', $ids)->get()->pluck('email')->toArray();
        return $email ?? null;
    }
    function group_by($model, $field_group, $field_select, $str_command)
    {
        $model  = $model->groupBy($field_group)->select($field_select, DB::raw($str_command))->get()->toArray();
        return $model;
    }
    function set_users_roles_permission($roles_id, $users_id)
    {           
        $result = null;
        $data = [];       
        if(isset($users_id)) {
            // UserRolePermissions::where('users_id', $users_id)->delete();
            $permissions = RolePermissions::where('roles_id', (int)$roles_id)->get()->pluck('permissions_id')->toArray();            
            if (count($permissions) > 0) {
                foreach ($permissions as $item) {
                    $data[] = [
                        "users_id"          =>  $users_id ?? 0,
                        "roles_id"          =>  $roles_id,
                        "permissions_id"    =>  $item
                    ];
                }
                // Thêm mới                
                CreateUserRolesPermissionsJobs::dispatch($data);
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật phân quyền cho người dùng"
                ];
            }
        }

        return $result;
    }
    function check_exist_file_template($params){    
        $new_file_name = null;          
        if (isset($params["file_name"]) && view()->exists($params["file_name"])) {
            $new_file_name = $params["file_name"];
        } else {
            if (view()->exists($params["tmp_default"])) {
                $new_file_name = $params["tmp_default"];
            }
        }        
        return $new_file_name;
    }
    function get_day_of_month(){
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('n', mktime(0, 0, 0, $i, 1));
        }
        return $months;        
    }
    function check_data_exits($table, $conditions) {
        $status = false;
        $dem = DB::table($table)->whereNull('deleted_at')->where($conditions)->count();
        if($dem > 0) $status = true;
        return $status;
    }
    function less_than($from_date, $to_date){        
        $status = false;
        $d1 = Carbon::createFromFormat('d/m/Y', $from_date);
        $d2 = Carbon::createFromFormat('d/m/Y', $to_date);
        if ($d1->lessThan($d2)) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }
    function greate_than($from_date, $to_date){        
        $status = false;
        $d1 = Carbon::createFromFormat('d/m/Y', $from_date);
        $d2 = Carbon::createFromFormat('d/m/Y', $to_date);
        if ($d1->lessThanOrEqualTo($d2)) {
            $status = false;
        } else {
            $status = true;
        }
        return $status;
    }
    function get_email_template_id($name) {
        $model = EmailTemplateTypes::where('name', 'LIKE', '%'.$name.'%')->first();
        return $model->id ?? null;
    }
    // Lấy thông tin file name    
    private function get_data_file_name_by_types($types)
    {
        $file_name = null;
        // $params["types_id"] = $types;
        $email_tmp = EmailTemplates::where('types_id', $types)->where('is_default', EmailTemplates::IS_DEFAULT)->first();
        if (isset($email_tmp->file_name)) {
            $file_name = $this->get_new_file_name("includes.template." . $email_tmp->file_name, 'includes.crm.mau_thong_bao_kpi_het_han');
        } else {
            $file_name = "includes.crm.mau_thong_bao_kpi_het_han";
        }
        if (!isset($file_name) || $file_name == null) {
            return false;
        }
        return $file_name;
    }
    function get_new_file_name($file_name, $tmp_default){
        $new_file_name = null;          
        if (view()->exists($file_name)) {
            $new_file_name = $file_name;
        } elseif(view()->exists($tmp_default)) {
                $new_file_name = $tmp_default;            
        } else {
            $new_file_name = null;
        }               
        return $new_file_name;
    }
    function get_file_tmp($tmp_file){
        $str_file = '';
        if(strpos($tmp_file,'.crm.') <= 0) {
            $str_file = 'includes.crm.' . $tmp_file;
        } else {
            $str_file = $tmp_file;
        }
        return $str_file;
    }
    function get_file_name($params, $tmp_default){             
        $temp_file = $this->get_file_tmp($tmp_default);
        
        if(isset($params['file_name']) && view()->exists("includes.template." . $params["file_name"]) == true) {            
            $file_name = "includes.template." . $params["file_name"];
        } else {                        
            if(view()->exists($temp_file) == true) {
                $file_name = $temp_file;            
            } else {
                $model = EmailTemplates::where('types_id', EmailTemplateTypes::TYPE_PRICE_LISTS)                        
                        ->where('is_default', 1)
                        ->first();                
                if(isset($model->id) && isset($model->file_name)) {
                    $file_name = $model->file_name;
                }
            }        
        }                 
        return $file_name;
    }

    private function get_email_admin(){
        $email = null;
        $model = User::where('id', User::IS_ROOT)->first();
        if(isset($model->email)) {
            $email = $model->email;
        }        
        return $email;
    }
}
