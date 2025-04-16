<?php

namespace App\Services\Leads;

use App\Exports\LeadsExport;
use App\Exports\LeadsExports;
use App\Imports\LeadsImports;
use App\Imports\UpdateCodeLeadsImports;
use App\Jobs\CreateNotificationsJobs;
use App\Jobs\SendMailJobs;
use App\Models\BlockAdminssions;
use App\Models\ConfigFilter;
use App\Models\Contacts;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\FamilyInformations;
use App\Models\Files;
use App\Models\Leads;
use App\Models\LeadsAcademicTerms;
use App\Models\LstStatus;
use App\Models\LstStatusHistory;
use App\Models\Marjors;
use App\Models\Notifications;
use App\Models\PriceLists;
use App\Models\ScoreAdminssions;
use App\Models\Sources;
use App\Models\Students;
use App\Models\Tags;
use App\Models\TransactionStatus;
use App\Models\TransactionTypes;
use App\Models\User;
use App\Repositories\ContactsRepository;
use App\Repositories\DegreeRepository;
use App\Repositories\EmployeesRepository;
use App\Repositories\FamilyRepository;
use App\Repositories\FilesRepository;
use App\Repositories\LeadsRepository;
use App\Repositories\ScoreAdminssionRepository;
use App\Repositories\SourcesRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\SupportsRepository;
use App\Repositories\UserRepository;
use App\Repositories\TagsRepository;
use App\Services\Leads\LeadsInterface;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LeadsServices implements LeadsInterface{
    use General, Information;
    protected $leads_repository;
    protected $degree_repository;
    protected $contacts_repository;
    protected $family_repository;
    protected $score_repository;
    protected $file_repository;
    protected $user_repository;
    protected $support_repository;
    protected $s_repository;
    protected $st_repository;
    protected $excel;
    protected $employee;
    protected $tags_repository;
    protected $lst_status_history;
    public function __construct(
        LeadsRepository $leads_repository,
        DegreeRepository $degree_repository,
        ContactsRepository $contacts_repository,
        FamilyRepository $family_repository,
        ScoreAdminssionRepository $score_repository,
        FilesRepository $file_repository,
        UserRepository $user_repository,
        SupportsRepository $support_repository,
        SourcesRepository $s_repository,
        StudentsRepository $st_repository,
        Excel $excel,
        EmployeesRepository $employee,
        TagsRepository $tags_repository,
        LstStatusHistory $lst_status_history
    ){
        $this->leads_repository = $leads_repository;
        $this->degree_repository = $degree_repository;
        $this->contacts_repository = $contacts_repository;
        $this->family_repository = $family_repository;
        $this->score_repository = $score_repository;
        $this->file_repository = $file_repository;
        $this->user_repository = $user_repository;
        $this->support_repository = $support_repository;
        $this->s_repository = $s_repository;
        $this->st_repository = $st_repository;
        $this->excel = $excel;
        $this->employee = $employee;
        $this->tags_repository = $tags_repository;
        $this->lst_status_history = $lst_status_history;
    }
    public function create_sources($name)
    {
        try {
            DB::beginTransaction();
            $model = Sources::where('name', 'LIKE', '%' . $name . '%')->first();
            if (!isset($model->id)) {
                $new = $this->s_repository->create([
                    'name' => $name
                ]);
                $id = $new->id;
            } else {
                $id = $model->id;
            }
            DB::commit();
            return $id;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
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
    private function _create($params){
        try {
            DB::beginTransaction();
            $id = $this->get_next_id('leads') + 1;            
            $params['code'] = !empty($id) ? "TS0000" . $id : "TS" . rand(100000, 999999);
            if(!isset($params['email']) || strlen($params['email']) <= 0){
                $params['email'] = $params['phone'] . '@elo.edu.vn';
            }
            $params['lst_status_id'] = Leads::ACTIVE_STUDENTS;
            $params['assignments_id'] = $this->get_first_employees();
            $create = $this->leads_repository->create($params);            
            DB::commit();
            return $create;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }

    }
    public function register_with_sources($params, $sources){
        try {
            DB::beginTransaction();
            // $sources_id = $this->create_sources($sources);
            $params['sources_id'] = $sources;            
            $create = $this->_create($params);
            $response = null;
            if(isset($create->id)) {
                $response = [
                    "code"      => 200,
                    "message"   => "Sinh viên đăng ký thành công"
                ];
            } else {
                $response = [
                    "code"      => 422,
                    "message"   => "Sinh viên đăng ký không thành công"
                ];
            }
            DB::commit();
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
    public function create_users($params){
        $data_users = null;
        $create = null;
        if(isset($params['email'])) {
            $users = User::where('email', $params['email'])->first();
            if(!isset($users->email)) {
                $data_users = [
                    "status" => User::ACTIVE,
                    "email" => isset($params["email"]) ? trim($params["email"]) : null,
                    "type"  => User::TYPE_LEADS,
                    "password"   => isset($params["password"]) ? Hash::make(trim($params["password"])) : Str::random(16),
                ];
            }
            $create = $this->user_repository->create($data_users);
        }
        return $create;
    }

    public function create($params){
        try {            
            DB::beginTransaction();
            $result = null;
            $params['types'] = Leads::REGISTER_TYPE_ONLINE;
            $leads = $this->action_insert($params);
            if (isset($leads->id)) {
                // Gửi thông tin đăng ký
                $result = [
                    "code"              => 200,
                    "message"           => "Đăng ký hồ sơ thành công! Thông tin đăng ký đã được gửi Email " . trim($params["email"]),
                    "data"              => [
                        "id"            => $leads->id,
                        "code"          => $leads->code ?? null,
                        "full_name"     => $leads->full_name ?? null,
                        "email"         => $leads->email ?? null,
                        "date_of_birth" => $leads->date_of_birth ?? null,
                        "gender"        => $leads->gender ?? null,
                        "marjors"       => $leads->marjors->name ?? null,
                        "steps"         => $leads->steps
                    ]
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
    private function check_email_in_users($email){
        $dem = $this->user_repository->where('email', $email)->count();
        $status = false;
        if($dem > 0) $status = true;
        return $status;
    }
    private function get_parent_id($params){
        $condition = [
            "email" => $params['email']
        ];
        $condition2= [
            "parent_id" => null
        ];
        $parent_id = $this->get_data_id_by_condition_expend('leads', $condition, $condition2 );
        $d_email_status = 0;
        if(!empty($parent_id)) {
            $d_email_status = 1;
            $this->update_d_email_status_by_id('leads', $parent_id);
        }
        return [
            "parent_id"         => $parent_id,
            "d_email_status"    => $d_email_status
        ];
    }  
    private function get_assignments_id($params){
        $assignments_id = null;
        if(isset($params['employees_id'])) {            
            $assignments_id = $params['employees_id'];
        } else {            
            $assignments_id = $this->get_first_employees_id();
        }       
        return $assignments_id;
    } 
    public function action_insert($params){        
        $condition = [
            "email"     => $params['email']
        ];
        $code       = $this->get_data_by_output('leads', $condition, 'code');
        // $leads_code = isset($params['leads_code']) ? $params['leads_code'] : $this->get_data_by_output('leads', $condition, 'leads_code');
        $params["password"] = Str::random(16);
        $assignments_id = $this->get_assignments_id($params);
        if(strlen($assignments_id) <= 0) {            
            $assignments_id = $this->get_assignments_id($params);
        }
        $lst_status_id = null;
        if(!empty($params['types'])){
            if($params['types'] == Leads::REGISTER_TYPE_ONLINE){
                $lst_status_id = Leads::REGISTER_PROFILE;
            }
            if($params['types'] == Leads::REGISTER_TYPE_CRM){
                $lst_status_id = Leads::REGISTER_TYPE_CRM;
            }
        }
        // Get data parent_id;
        $data_parent_id = $this->get_parent_id($params);
        $data = [
            "steps"                 => Leads::REGISTER_PROFILE ?? 0,
            "email"                 => isset($params["email"]) ? trim($params["email"]) : null,
            "code"                  => isset($code) && strlen($code) > 0 ? $code : "TS" . rand(100000, 999999),
            // "leads_code"            => isset($leads_code) && strlen($leads_code) > 0 ? $leads_code : "SV" . rand(100000, 999999),
            "leads_code"            => isset($params["leads_code"]) ? trim($params["leads_code"]) : null,
            "full_name"             => isset($params["full_name"]) ? trim($params["full_name"]) : null,
            "gender"                => isset($params["gender"]) ? trim($params["gender"]) : null,
            "phone"                 => isset($params["phone"]) ? trim($params["phone"]) : null,
            "identification_card"   => isset($params["identification_card"]) ? trim($params["identification_card"]) : '',
            "sources_id"            => isset($params["sources_id"]) ? trim($params["sources_id"]) : null,
            "marjors_id"            => isset($params["marjors_id"]) ? trim($params["marjors_id"]) : null,
            "created_by"            => Auth::user()->id ?? NULL,
            "lst_status_id"         => $lst_status_id ?? 1,
            "tags_id"               => $params["tags_id"] ?? 1,
            "place_of_birth"        => isset($params["place_of_birth"]) ?  trim($params["place_of_birth"]) : null,
            "place_of_wrk_lrn"      => isset($params["place_of_wrk_lrn"]) ? trim($params["place_of_wrk_lrn"]) : null,
            "date_of_birth"         => isset($params["date_of_birth"]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d') : null,
            "assignments_id"        => $assignments_id,
            "academic_terms_id"     => isset($params["academic_terms_id"]) ? trim($params["academic_terms_id"] ) : null,
            "parent_id"             => isset($data_parent_id["parent_id"]) ? $data_parent_id["parent_id"] : null,
            "d_email_status"        => isset($data_parent_id["d_email_status"]) ? $data_parent_id["d_email_status"] : null,
        ]; 
        
        $leads = $this->leads_repository->create($data);
        if (isset($leads->id)) {
            $this->create_new_notification($leads);
            LstStatusHistory::insert([
                "leads_id"         => $leads->id,
                "lst_status_id"    => $lst_status_id,
                "created_at"       => Carbon::now(),
                "created_by"       => Auth::user()->id ?? NULL,
            ]);
            $status = $this->check_email_in_users($params['email']);
            if(!$status) {
                $users = $this->create_users($params);
                if(isset($users->id)) {                    
                    $types_id = $this->get_email_template_types("Tài khoản");                    
                    $file_name = $this->get_email_template($types_id);       
                    $data_sendmail = [
                        "title"             => "Thông tin đăng ký hồ sơ",
                        "subject"           => "Thông tin đăng ký hồ sơ",                        
                        "full_name"         => isset($leads["full_name"]) ? trim($leads["full_name"]) : '-',
                        "leads_code"        => isset($leads["leads_code"]) ? trim($leads["leads_code"]) : '-',
                        "email"             => isset($leads["email"]) ? trim($leads["email"]) : '-',
                        "phone"             => isset($leads["phone"]) ? trim($leads["phone"]) : '-',
                        "password"          => isset($leads["password"]) ?  trim($leads["password"]) : Str::random(16),
                        "date_of_birthday"  => isset($leads["date_of_birth"]) ? Carbon::parse($leads["date_of_birth"])->format('d/m/Y') : '-',   
                        "marjors_name"      => isset($leads["marjors"]) ? $leads["marjors"]["name"] : '-',
                        "gender"            => isset($leads["gender"]) && $leads["gender"] == 1 ? 'Nam' : (isset($leads["gender"]) && $leads["gender"] == 0 ? 'Nữ' : 'Khác'),
                        "home_phone"        => isset($leads["home_phone"]) ? trim($leads["home_phone"]) : '-',
                        "nations_name"      => isset($leads["nations_name"]) ? trim($leads["nations_name"]) : '-',
                        "ethnics_name"      => isset($leads["ethnics_name"]) ? trim($leads["ethnics_name"]) : '-',                        
                        "place_of_birth"    => isset($leads["place_of_birth"]) ? trim($leads["place_of_birth"]) : '-',                        
                        'to'                => $leads['email'] ?? '',                        
                        "identification_card"  => isset($leads["identification_card"]) ? trim($leads["identification_card"]) : '-',
                    ];                                                       
                    SendMailJobs::dispatch($data_sendmail,$file_name);
                }
            }
        }
        return $leads;
    }
    private function get_email_template($types_id){
        $model = EmailTemplates::where('types_id', $types_id)->where('is_default', 1)->first();
        $file_name = null;
        if(isset($model->file_name) && view()->exists('includes.template.' . $model->file_name))  $file_name = 'includes.template.' . $model->file_name;
        return $file_name ?? 'includes.mail';
    }
    private function get_email_template_types($name){        
        $model = EmailTemplateTypes::where('name', 'LIKE', '%'. $name .'%')->first();
        return $model->id ?? null; 
    }
    private function create_new_notification($leads) {
        if(isset($leads->employees->email) && strlen($leads->employees->email) > 0) {
            $content = "Bạn vừa được gán phụ trách cho thí sinh <a href='/crm/leads/detail_lead/".$leads->id."' target='_blank'>".$leads->full_name."</a>";
            $title = "Bạn vừa được gán phụ trách cho thí sinh " . $leads->full_name;
            $this->create_notification($leads, $content, $content);
        }
    }
    public function uAvatar($params, $id){
        try {
            DB::beginTransaction();
            $params['title'] = "Ảnh avatar";
            $data = [];
            $model = $this->leads_repository->where('id', $id);
            $dem = $model->count();
            if($dem <= 0){
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy Thí sinh này"
                ]);
            }
            $code = $model->first()->code;
            $steps = $model->first()->steps;
            $code = $model->first()->code;
            $url = "assets/upload/students/" . $code . '/';
            // upload nhiều file
            $type = config('app.data.type_leads');
            $data = $this->upload_image($params, $url, $id, $type);
            $data['types'] = Files::TYPE_AVATAR;
            Files::where('leads_id', $id)->where('types', Files::TYPE_AVATAR)->delete();
            $new_model = $this->file_repository->create($data);
            $result = null;
            if (isset($new_model->id)) {
                $result = [
                    "code"      => 200,
                    "message"   => "Tải avatar thành công",
                    "data"      => [
                        "leads_id" => $new_model->leads_id,
                        "image_url" => $new_model->image_url,
                        "steps" => $steps,
                    ]
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Tải avatar thất bại"
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
    // cập nhật leads và thêm mới thông tin văn bằng
    public function uPersonal($params, $id){
        try {
            DB::beginTransaction();
            // Kiểm tra id có tồn tại trong bảng leads không
            // -------------------------------------------------
            $dem = $this->leads_repository->where('id', $id)->count();
            if ($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Không tim thấy thí sinh trên hệ thống",
                ];
            }
            // -------------------------------------------------
            $data_leads = [
                "steps"         => Leads::INFORMATION_PROFILE,
                "avatar"        => trim($params["avatar"]),
                // "date_of_birth" => Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d'),
                "place_of_birth" => trim($params["place_of_birth"]),
                "nations_name"  => trim($params["nations_name"]),
                "ethnics_name"  => trim($params["ethnics_name"]),
                // "identification_card"       => trim($params["identification_card"]),
                // "date_identification_card"  => isset($degree["date_identification_card"]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_identification_card"]))->format('Y-m-d') : null,
                // "place_identification_card" => trim($params["place_identification_card"]),
                "date_of_join_youth_union"  => isset($params["date_of_join_youth_union"]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_of_join_youth_union"]))->format('Y-m-d') : null,
                "date_of_join_communist_party" => isset($params["date_of_join_communist_party"]) ? Carbon::createFromFormat('d/m/Y',  trim($params["date_of_join_communist_party"]))->format('Y-m-d') : null,
                "company_name" => trim($params["company_name"]),
                "company_address" => trim($params["company_address"]),
            ];
            if(isset( $params["date_of_birth"])) $data_leads ["date_of_birth"]                          = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
            if(isset( $params["identification_card"])) $data_leads ["identification_card"]              = trim($params["identification_card"]);
            if(isset( $params["date_identification_card"])) $data_leads ["date_identification_card"]    = isset($degree["date_identification_card"]) ? Carbon::createFromFormat('d/m/Y', trim($params["date_identification_card"]))->format('Y-m-d') : null;
            if(isset( $params["place_identification_card"])) $data_leads ["place_identification_card"]  = trim($params["place_identification_card"]);


            // Update lại dữ liệu thì sinh đã đăng ký trước
            $model = $this->leads_repository->updateById($id, $data_leads);
            // Thêm mới bảng văn bằng tốt nghiệp
            $params['prefix'] = config('app.data.degree_prefix') ?? null;
            $params['leads_id'] = $id ?? null;
            $data_degree = $this->get_parrams_degree($params);
            if(count($data_degree) > 0){
                $degree = $this->degree_repository->createMultiple($data_degree);
            }
            // Thêm mới văn bằng
            $result = null;
            if ($model->id && count($degree) > 0) {
                $result = [
                    "code"      => 200,
                    "message"   => "Thông tin đã cập nhật thành công",
                    "data" => [
                        "id"            => $model->id,
                        "full_name"     => $model->full_name,
                        "code"          => $model->code,
                        "email"         => $model->email,
                        "date_of_birth" => $model->date_of_birth,
                        "gender"        => $model->gender,
                        "marjors"       => $model->marjors->name,
                        "steps"         => $model->steps
                    ]
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thông tin đã được cập nhật thất bại",
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function contacts($param, $id) {
        try {
            DB::beginTransaction();
            // Kiểm tra id có tồn tại trong bảng leads không
            // -------------------------------------------------
            $dem = $this->leads_repository->where('id', $id)->count();
            if ($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Không tim thấy thí sinh trên hệ thống",
                ];
            }
            // --------------------------------------------------------
            // Bổ sung thêm
            $steps = [
                "steps"   => Leads::CONTACTS,
            ];
            $model = $this->leads_repository->updateById($id, $steps);

            // --------------------------------------------------------
            $param['prefix'] = config('app.data.contact_prefix') ?? ['hktt', 'dcll'];
            $param['leads_id'] = $id;
            Contacts::where('leads_id', $id)->delete();
            $data = $this->getParamsContacts($param, $id);
            $contacts = $this->contacts_repository->createMultiple($data);
            if (count($contacts) > 0) {
                $data = [
                    "code" => 200,
                    "message" => "Đăng ký thông tin liên lạc thành công",
                    "data" => [
                        "id"            => $model->id,
                        "full_name"     => $model->full_name,
                        "code"          => $model->code,
                        "email"         => $model->email,
                        "date_of_birth" => $model->date_of_birth,
                        "gender"        => $model->gender,
                        "marjors"       => $model->marjors->name,
                        "steps"         => $model->steps
                    ]
                ];
            } else {
                $data = [
                    "code" => 200,
                    "message" => "Đăng ký thông tin liên lạc thất bại"
                ];
            }
            DB::commit();
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function family($params, $id) {
        try {
            DB::beginTransaction();
            // Kiểm tra id có tồn tại trong bảng leads không
            // -------------------------------------------------
            $dem = $this->leads_repository->where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Không tim thấy thí sinh trên hệ thống",
                ];
            }
            // --------------------------------------------------------
            // Bổ sung thêm
            $steps = [
                "steps"         => Leads::FAMILY,
            ];
            $model = $this->leads_repository->updateById($id, $steps);
            // --------------------------------------------------------
            $params['prefix'] = config('app.data.family_prefix') ?? null;
            $params['leads_id'] = $id ?? null;
            FamilyInformations::where('leads_id', $id)->delete();
            $data = $this->getFamilyParrams($params, $id);
            $family = $this->family_repository->createMultiple($data);
            if(count($family) > 0) {
                $data = [
                    "code" => 200,
                    "message" => "Đăng ký thông tin liên lạc thành công",
                    "data" => [
                        "id"            => $model->id,
                        "full_name"     => $model->full_name,
                        "code"          => $model->code,
                        "email"         => $model->email,
                        "date_of_birth" => $model->date_of_birth,
                        "gender"        => $model->gender,
                        "marjors"       => $model->marjors->name,
                        "steps"         => $model->steps
                    ]
                ];
            } else {
                $data = [
                    "code" => 200,
                    "message" => "Đăng ký thông tin liên lạc thất bại"
                ];
            }
            DB::commit();
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    // Thông tin xét tuyển theo bảng điểm
    public function score($params, $id){
        try {
            DB::beginTransaction();
            // Kiểm tra id có tồn tại trong bảng leads không
            // -------------------------------------------------
            $dem = $this->leads_repository->where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Không tim thấy thí sinh trên hệ thống",
                ];
            }
            // --------------------------------------------------------
            // Bổ sung thêm
            $steps = [
                "steps"         => Leads::SCORE,
            ];
            $model = $this->leads_repository->updateById($id, $steps);
            // --------------------------------------------------------
            $leads = $this->leads_repository->where('id', $id)->count();
            if ($leads <= 0) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn thí sinh cần xét tuyển"
                ];
            }
            ScoreAdminssions::where('leads_id', $id)->delete();
            $params['leads_id'] = $id;
            $params['total_score'] = ($params['score1'] ?? 0) +  ($params['score2'] ?? 0) +  ($params['score3'] ?? 0);
            $params['created_by'] = Auth::user()->id ?? null;
            $score = $this->score_repository->create($params);
            $result = null;
            if (isset($score->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được thêm mới thành công",
                    "data" => [
                        "id"            => $model->id,
                        "full_name"     => $model->full_name,
                        "code"          => $model->code,
                        "email"         => $model->email,
                        "date_of_birth" => $model->date_of_birth,
                        "gender"        => $model->gender,
                        "marjors"       => $model->marjors->name,
                        "steps"         => $model->steps
                    ]
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
    // Xác nhận hồ sơ sẽ lưu vào thư mục tương ứng mới mã hồ sơ code Ts....****
    private function merge_types_to_array($params){
        $data = [];
        foreach ($params as $p) {
            $p['types'] = Files::TYPE_PROFILE;
            $data[] = $p;
        }
        return $data;
    }
    public function confirm($params, $id){
        try {
            DB::beginTransaction();
            // Kiểm tra id có tồn tại trong bảng leads không
            // -------------------------------------------------
            $dem = $this->leads_repository->where('id', $id)->count();
            if($dem <= 0) {
                return [
                    "code" => 422,
                    "message" => "Không tim thấy thí sinh trên hệ thống",
                ];
            }
            // --------------------------------------------------------
            // Bổ sung thêm
            $steps = [
                "steps" => Leads::CONFIRM,
            ];
            $model = $this->leads_repository->updateById($id, $steps);
            // --------------------------------------------------------
            $data = [];
            Files::where('leads_id', $id)->where('types', Files::TYPE_PROFILE)->delete();
            $model = $this->leads_repository->where('id', $id)->first();
            $url = "/assets/upload/students/" . $model['code'] . '/';
            $files = $this->upload_images($params, $url, $id);
            $data = $this->merge_types_to_array($files);
            // ghi vào database theo mã hồ sơ của thí sinh
            $confirm = $this->file_repository->createMultiple($data);
            $response = null;
            if(count($confirm) > 0) {
                $response = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được thêm mới thành công",
                    "data" => [
                        "id"            => $model->id,
                        "full_name"     => $model->full_name,
                        "code"          => $model->code,
                        "email"         => $model->email,
                        "date_of_birth" => $model->date_of_birth,
                        "gender"        => $model->gender,
                        "marjors"       => $model->marjors->name,
                        "steps"         => $model->steps
                    ]
                ];
            } else {
                $response = [
                    "code"      => 422,
                    "message"   => "Tải hồ sơ thất bại"
                ];
            }
            DB::commit();
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    // Phần này trong CRM
    private function filter_where_all($model, $param, $name){
        if (is_array($param)) {
            if(!in_array('all',$param)){
                $model = $model->whereIn($name, $param);
            }
        } else {
            if($param !== 'all'){
                $model = $model->where($name, $param);
            }
        }
        return $model;
    }
    private function filter($params)
    {
        $model = Leads::with([
            'sources',
            'marjors',
            'status',
            'tags',
            'contacts',
            'score',
            'user',
            "create_by",
            "update_by",
            "delete_by",
            "files",
            "supports",
            "family",
            "employees:id,name,code,roles_id",
            "transactions",
            'academic_terms'
        ]);

        if (isset($params['keyword'])) {
            $model = $model->where(
                function ($query) use ($params) {
                $query->where('full_name', 'LIKE', '%' . $params['keyword'] . '%')
                      ->orWhere('code', $params['keyword'])
                      ->orWhere('phone', 'LIKE', '%' . $params['keyword'] . '%')
                      ->orWhere('email', 'LIKE', '%' . $params['keyword'] . '%')
                      ->orWhere('leads_code', $params['keyword']);
            });
        }
        if (isset($params['sources_id'])) {
            $model = $this->filter_where_all($model, $params['sources_id'], 'sources_id');
        }
        if (isset($params['lst_status_id'])) {
            $model = $this->filter_where_all($model, $params['lst_status_id'], 'lst_status_id');
        }
        if (isset($params['tags_id'])) {
            $model = $this->filter_where_all($model, $params['tags_id'], 'tags_id');
        }
        if (isset($params['marjors_id'])) {
            $model = $this->filter_where_all($model, $params['marjors_id'], 'marjors_id');
        }
        if (isset($params['assignments_id'])) {
            $model = $this->filter_where_all($model, $params['assignments_id'], 'assignments_id');
        }
        
        if (isset($params['from_date'])) {
            $from_date = Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->startOfDay()->format('Y-m-d H:i:s');
            $model = $model->where('created_at', '>=', $from_date);
        }
        if (isset($params['to_date'])) {
            $to_date = Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->endOfDay()->format('Y-m-d H:i:s');
            $model = $model->where('created_at', '<=', $to_date);
        }
        
        return $model->where('active_student', Leads::NOT_ACTIVE_STUDENTS)->orderBy('id', 'desc');
    }
    private function get_data_config_filter($id){
        $model = ConfigFilter::where('id', $id)->first();
        return [
            "start_date"    =>  $model->start_date,
            "end_date"      =>  $model->end_date,
        ];
    }
    // Hiển thị danh sách thí sinh
    public function data($params){        
        try {            
            $model = $this->filter($params);
            $entries = $model->get();
            foreach ($entries as $entry) {
                $entry['extended_fields'] = json_decode($entry['extended_fields']);
                $contacts = $entry->contacts->where('leads_id', $entry->id)->where('type', contacts::TYPE_ADDRESS)->first();
                $entry->address = $this->getAddress($contacts);
                $entry['sources'] = $entry->sources ?? null;
                $entry['marjors'] = $entry->marjors ?? null;
                $entry['status'] = $entry->status ?? null;
                $entry['tags'] = $entry->tags ?? null;
                $entry['contacts'] = $entry->contacts ?? null;
                $entry['score'] = $entry->score ?? null;
                $entry['user'] = $entry->user ?? null;
                $entry['create_by'] = $entry->create_by ?? null;
                $entry['update_by'] = $entry->update_by ?? null;
                $entry['delete_by'] = $entry->delete_by ?? null;
                $entry['supports'] = $entry->supports ?? null;
                $entry['files'] = $entry->files ?? null;
                $entry['family'] = $entry->family ?? null;
                $entry['transactions'] = $entry->transactions ?? null;
            }
            $data = [
                'code'      => 200,
                'data'      => $entries,
                'params'    => $params
            ];            
            return $data;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    // Chi tiết thí sinh
    public function details($id){
        try {
            $model = $this->leads_repository->with([
                'sources','marjors','status','tags','contacts','score', 'score.method_adminssions', 'score.block_adminssion','user',
                "create_by","update_by","delete_by","files","supports","family","family.edutpyes",
                "price_lists.files", "transactions.status", "transactions.types","transactions.price_lists","employees.files","employees.lineVoip","degree","degree.types"
            ])->where('id', $id)->whereNull('deleted_at')->first();
            $model->avatar = $model->files->where('leads_id', $id)->where('types', Files::TYPE_AVATAR)->first()->image_url ?? 'assets/crm/media/svg/avatars/blank.svg';
            $model->url_avatar = $model->files->where('leads_id', $id)->where('types', Files::TYPE_AVATAR)->first()->image_url ?? 'assets/crm/media/svg/avatars/blank.svg';
            $contacts = $model->contacts->where('leads_id', $id)->where('type', contacts::TYPE_ADDRESS)->first();
            $model->address = $this->getAddress($contacts);

            if(isset($model->employees) && isset($model->employees->files)){
                $employees_files = $model->employees->files->where('types', Files::TYPE_AVATAR)->first();
                if(isset($employees_files['image_url'])) {
                    $model->employees->avatar = $employees_files['image_url'];
                }
            }
            foreach ($model->price_lists as $price) {
               $price->data_color = PriceLists::COLOR_MAP;
            }
            $model['extended_fields'] = json_decode($model['extended_fields']);

            if (!empty($model['tags_id'])){
                $tags_info = $this->tags_repository->where('id', $model['tags_id'])->first();
                if( !empty($tags_info->name)){
                    $model['tags_name'] = $tags_info->name;
                }
            }
            return $model;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    // Chỉnh sửa thí sinh
    private function post_update_leads_academic_terms($params, $id){
        $data = [
            "leads_id"            => $id,
            "academic_terms_id"   => $params['academic_terms_id'],
            "updated_at"          => Carbon::now(),
            "updated_by"          => Auth::user()->id
        ];
        $update = LeadsAcademicTerms::where('leads_id', $id)->where('academic_terms_id', $params['old_academic_terms_id'])->update($data);
        return $update;
    }
    public function update($params, $id){
        try {
            DB::beginTransaction();
            $result = null;
            $leads_update_status = $this->post_update_leads($params, $id);
            if($leads_update_status['code'] == 200) {
                // Trường hợp email mới có dữ liệu và không trùng với email cũ cho xử sửa đổi trong email
                if(strlen(trim($leads_update_status['new_email'])) > 0 && trim($leads_update_status['new_email']) != trim($leads_update_status['old_email'])) {
                    $params['old_email'] = trim($leads_update_status['old_email']);
                    $this->post_update_user($params);
                }
                // cập nhật thông tin gia đình
                $this->post_update_family($params, $id);
                // Cập nhật thông tin liên lạc
                $this->post_update_contacts($params, $id);

                // if(isset($params['old_academic_terms_id']) && $params['old_academic_terms_id'] != $params['academic_terms_id']){
                //     $this->post_update_leads_academic_terms($params, $id);
                // }
                $result = response() ->json([
                    "code" => 200,
                    "message" => "Cập nhật danh thông tin thí sinh thành công"
                ]);
            }
            else {
                $result = response() ->json([
                    "code" => 401,
                    "message" => "Cập nhật danh thông tin thí sinh không thành công"
                ]);
            }
            if($params['employees_id_old'] != $params['employees_id']){
                $lead = $this->leads_repository->where('id', $id)->first();
                $this->create_new_notification($lead);
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
    // Update leads
    private function post_update_leads($params, $id){        
        $data_update_leads = [];
        $old_email = null;
        // Mã số sinh viên
        if(isset($params["leads_code"]) && strlen($params["leads_code"]) > 0) {
            $data_update_leads["leads_code"] = trim($params["leads_code"]);
        }
        // Họ và tên
        if(isset($params["full_name"]) && strlen($params["full_name"]) > 0) {
            $data_update_leads["full_name"] = trim($params["full_name"]);
        }
        // Email
        if(isset($params["email"]) && strlen($params["email"]) > 0) {
            $old_email = $this->leads_repository->where('id', $id)->first()->email;
            if(trim($params["email"]) != trim($old_email)) $data_update_leads["email"] = trim($params["email"]);
        }
        // Giới tính
        if(isset($params["gender"]) && strlen($params["gender"]) > 0) {
            $data_update_leads["gender"] = trim($params["gender"]);
        }
        // Số điện thoại
        if(isset($params["phone"]) && strlen($params["phone"]) > 0) {
            $data_update_leads["phone"] = trim($params["phone"]);
        }
        // Ngày sinh
        if(isset($params["date_of_birth"]) && strlen($params["date_of_birth"]) > 0) {
            $data_update_leads["date_of_birth"] = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
        }
        // CCCD
        if(isset($params["identification_card"]) && strlen($params["identification_card"]) > 0) {
            $data_update_leads["identification_card"] = trim($params["identification_card"]);
        }
        // Trạng thái
        if(isset($params["lst_status_id"]) && strlen($params["phone"])) {
            $data_update_leads["lst_status_id"] = trim($params["lst_status_id"]);
        }
        // Nguồn tiếp cận
        if(isset($params["sources_id"]) && strlen($params["sources_id"]) > 0) {
            $data_update_leads["sources_id"] = trim($params["sources_id"]);
        }
        // Nhân viên tư vấn
        if(isset($params["employees_id"]) && strlen($params["employees_id"]) > 0) {
            $data_update_leads["assignments_id"] = trim($params["employees_id"]);
        }
        // Chuyên ngành
        if(isset($params["marjors_id"]) && strlen($params["marjors_id"]) > 0) {
            $data_update_leads["marjors_id"] = trim($params["marjors_id"]);
        }

        // Tag
        if(isset($params["tag_value"]) && strlen($params["tag_value"]) > 0) {
            $tag_value = trim($params["tag_value"]);
            $data = array();
            $data["name"] = $tag_value;

            $check_exist = $this->tags_repository->where('name', $tag_value)->count();
            if ($check_exist){
                $tag_item = $this->tags_repository->where('name', $tag_value)->first();
                $new_id = $tag_item->id;
            }else{
                $new_tag = $this->tags_repository->create($data);

            if (!empty($new_tag->id)){
                    $new_id = $new_tag->id;
                }
            }
            $data_update_leads["tags_id"] = $new_id;
        }

        $update = $this->leads_repository->updateById($id, $data_update_leads);
        $code = false;
        if(isset($update->id)) {
            $code = 200;
        } else {
            $code = 400;
        }
        return [
            "code" => $code ?? 422,
            "old_email" => $old_email ?? null,
            "new_email" => $data_update_leads["email"] ?? null
        ];
    }
    // Update users
    private function post_update_user($params){
        $data = [];
        // Họ và tên
        if(isset($params["old_email"]) && strlen($params["old_email"]) > 0 && isset($params["email"]) && strlen($params["email"]) > 0) {
            $old_email = $params['old_email'];
            $data["email"] = trim($params["email"]);
            $update = User::where('email', $old_email)->update($data);
            $result = null;
            if($update > 0) {
                $result = [
                    "code" => 200,
                    "message" => "Cập nhập email thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Cập nhập email không thành công"
                ];
            }
        }
        return $result;
    }
    // Update family
    // ------------------------------------------------------------
    private function update_family($data, $id){
        FamilyInformations::where('leads_id', $id)->update([
            "deleted_at"    => Carbon::now(),
            "deleted_by"    => Auth::user()->id
        ]);
        $model = FamilyInformations::insert($data);
        if($model){
            $result = [
                "code" => 200,
                "message" => "Cập nhật thông tin gia đình thành công"
            ];
        } else {
            $result = [
                "code" => 422,
                "message" => "Cập nhật thông tin gia đình không thành công"
            ];
        }
        return $result;
    }
    private function post_update_family($params, $id){
        $params['prefix'] = config('app.data.family_prefix') ?? null;
        $params['leads_id'] = (int)$id ?? null;
        $data = $this->getFamilyParrams($params, $id);
        $leads = $this->family_repository->where('leads_id', $id)->count();
        if($leads <= 0) {
            $result = $this->family_repository->createMultiple($data);
        } else {
            $result = $this->update_family($data, $id);
        }
        return $result;
    }
    // ------------------------------------------------------------
    private function post_update_contacts($params, $id){
        $params['prefix'] = config('app.data.contact_prefix') ?? ['hktt', 'dcll'];
        $params['leads_id'] = $id;
        $data = $this->getParamsContacts($params, $id);
        $cContacts = $this->contacts_repository->where('leads_id', $id)->count();
        if($cContacts <= 0) {
            $result =  $this->contacts_repository->createMultiple($data);
        } else {
            $result = $this->update_contacts($data, $id);
        }
        return $result;
    }
    private function update_contacts($data, $id){
        $result = [];
        $dem = 0;
        foreach ($data as $value) {
            $model = Contacts::where('leads_id', $id)->where('type', $value['type'])->update($value);
            if($model > 0) $dem += 1;
        }
        if($dem > 0){
            $result[] = [
                "code" => 200,
                "message" => "Cập nhật thông tin liên lạc thành công"
            ];
        } else {
            $result[] = [
                "code" => 422,
                "message" => "Cập nhật thông tin liên lạc không thành công"
            ];
        }
        return $result;
    }
    // Xóa bỏ thí sinh tiềm năng
    public function crm_create_lead($params){        
        $params['types'] = Leads::REGISTER_TYPE_CRM;
        $leads = $this->action_insert($params);
        if(isset($leads->id)) {
            $this->family($params, $leads->id);
            $this->contacts($params, $leads->id);
            $steps = $this->get_steps($leads->id);
            $this->leads_repository->updateById($leads->id , ["steps" => $steps]);
            $result = [
                    "code"              => 200,
                    "message"           => "Đăng ký hồ sơ thành công! Thông tin đăng ký đã được gửi Email " . trim($params["email"]),
                    "data" => [
                        "id"            => $leads->id,
                        "code"          => $leads->code ?? null,
                        "email"         => $leads->email ?? null,
                        "date_of_birth" => $leads->date_of_birth ?? null,
                        "gender"        => $leads->date_of_birth ?? null,
                        "marjors"       => $leads->marjors->name ?? null,
                    ]
            ];
        } else {
            $result = [
                "code" => 422,
                "message" => "Dữ liệu thêm mới thất bại"
            ];
        }
        return $result;
    }
    public function update_status_lead($params, $id){
        try {
            $dem = Leads::where('id', $id)->count();
            if($dem <= 0){
                return [
                    "code"      => 422,
                    "message"   => "Không tìm thấy sinh viên trên hệ thống"
                ];
            }
            $data = [
                "lst_status_id" => $params['lst_status_id'] ?? 1,
            ];
            $data_history = [
                "leads_id"          => $id,
                "lst_status_id"     => $params['lst_status_id'],
                "created_by"        => Auth::user()->id
            ];
            $this->lst_status_history->create($data_history);
            $update = $this->leads_repository->updateById($id, $data);
            $response = null;
            if(isset($update->id)) {
                $response = [
                    "code"      => 200,
                    "message"   => "Cập nhật trạng thái thành công"
                ];
            } else {
                $response = [
                    "code"      => 401,
                    "message"   => "Cập nhật trạng thái thất bại"
                ];
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
        return response()->json($response);
    }
    // xóa email tương ứng với leads cần xóa
    public function user_delete($id){
        $data = [
            "deleted_at"    => Carbon::now(),
            "deleted_by"    => Auth::user()->id ?? null
        ];
        $user_delete = $this->user_repository->updateById($id, $data);
        // Sau này phát sinh bảng liên quan thì bổ sung tại đây
        return $user_delete;
    }
    public function getLeadsEmail($id){
        $email = null;
        if(!is_array($id)) {
            $email = $this->leads_repository->where('id', $id)->first()->email;
        } else {
            $email = $this->leads_repository->whereIn('id', $id)->get()->pluck('email')->toArray();
        }
        return $email;
    }

    public function delete_relationship_lead($id) {
        $email = $this->getLeadsEmail($id);
        // Xoas bảng file
        $file_delete = $this->delete_by_condition('files', ['leads_id' => $id]);
        // Xoas bảng Yêu cầu hỗ trợ
        $support_delete = $this->delete_by_condition('supports', ['email' => $email]);
        // Xóa bảng địa chỉ
        $contacts_delete = $this->delete_by_condition('contacts', ['leads_id' => $id]);
        // Xóa dữ liệu thông tin gia đình
        $family_delete = $this->delete_by_condition('family_informations', ['leads_id' => $id]);
        // Xóa dữ liệu thông tin liên lạc
        $score_delete = $this->delete_by_condition('score_adminssions', ['leads_id' => $id]);
        // Xóa nhân viên
        $user_delete = $this->delete_by_condition('users', ['email' => $email]);

        $data =  [
            "file_delete"       => $file_delete ?? null,
            "support_delete"    => $support_delete ?? null,
            "contacts_delete"   => $contacts_delete ?? null,
            "family_delete"     => $family_delete ?? null,
            "score_delete"      => $score_delete ?? null,
            "user_delete"      => $user_delete ?? null
        ];
        return $data;
    }
    private function delete_status_leads($leads_id){
        $leads_count    = Leads::where('id', $leads_id)->where('active_student', Leads::ACTIVE_STUDENTS)->count();
        $student_count  = Students::where('leads_id', $leads_id)->count();
        $status = true; // cho phép xóa
        if($leads_count > 0 || $student_count > 0) $status = false;
        return $status;
    }
    public function delete_relationship_lead_by_ids($params) {
        $email = $this->getLeadsEmail($params['ids']);
        // Xoas bảng file
        $file_delete = $this->delete_by_list_id('files', 'leads_id' , $params['ids']);
        // Xoas bảng Yêu cầu hỗ trợ
        $support_delete = $this->delete_by_list_id('supports', 'email' , $email);
        // Xóa bảng địa chỉ
        $contacts_delete = $this->delete_by_list_id('contacts', 'leads_id' , $params['ids']);
        // Xóa dữ liệu thông tin gia đình
        $family_delete = $this->delete_by_list_id('family_informations', 'leads_id' , $params['ids']);
        // Xóa dữ liệu thông tin liên lạc
        $score_delete = $this->delete_by_list_id('score_adminssions', 'leads_id' , $params['ids']);
        // Xóa nhân viên
        $user_delete = $this->delete_by_list_id('users','email' , $email);

        $data =  [
            "file_delete"       => $file_delete ?? null,
            "support_delete"    => $support_delete ?? null,
            "contacts_delete"   => $contacts_delete ?? null,
            "family_delete"     => $family_delete ?? null,
            "score_delete"      => $score_delete ?? null,
            "user_delete"      => $user_delete ?? null
        ];
        return $data;
    }
    public function delete_multiple($params){
        try {
            DB::beginTransaction();
            // Xóa bảng quan hệ:
            $this->delete_relationship_lead_by_ids($params);
            $leads_delete =  $this->delete_by_list_id('leads', 'id' , $params['ids']);
            $result = null;
            if($leads_delete) {
                $result = [
                    "code"      => 200,
                    "message"   => "Xóa danh sách sinh viên thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Xóa danh sách sinh viên không thành công"
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
    // Xóa dữ liệu  bảng thí sinh
    public function delete($id){
        try {
            DB::beginTransaction();
            // Chỗ xóa này sau này cần thêm bảng history để lưu lại
            // Gọi hàm xóa các bảng liên quan
            $allow_delete_leads = $this->delete_status_leads($id);
            if($allow_delete_leads == false) {
                return [
                    "code"      => 422,
                    "message"   => "Sinh viên này đã chuyển chính thức! Bạn không thể xóa sinh viên này"
                ];
            }
            $this->delete_relationship_lead($id);
            $lead_delete = Leads::where('id', $id)->update([
                "deleted_at"    => Carbon::now(),
                "deleted_by"    => Auth::user()->id ?? 1
            ]);
            if($lead_delete > 0) {
                $result = [
                    "code"      => 200,
                    "message"   => "Xóa thí sinh thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Xóa thí sinh không thành công"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function export($params){
        try {
            if (!isset($params["fields"])) {
                $params["fields"] = config("data.leads.display_fields");
            }
            $query = $this->filter($params);
            $data = $query->get();
            $file_name = "danh_sach_sinh_vien_tiem_nang_" . date('d-m-Y') . '.xlsx';            
            return Excel::download(new LeadsExports($data, $params), $file_name);            
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function import($params){
        try {
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            // Excel::import(new LeadImport, $params['file']);
            Excel::import(new LeadsImports, $params['file']);
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
    public function active($params) {
        try {
            if(!isset($params['email'])) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng nhập email của thí sinh"
                ];
            }
            $model = $this->user_repository->where('email', trim($params['email']))->first();
            if(!isset($model->id)) {
                return [
                    "code" => 422,
                    "message" => "Thí sinh chưa có tài khoản truy cập!"
                ];
            }
            $active = $model->update([
                "status"        => User::ACTIVE ?? 1,
                "updated_by"    => Auth::user()->id ?? null
            ]);

            if($active){
                return [
                    "code" => 200,
                    "message" => "Email " . $params['email'] . " kích hoạt thành công"
                ];
            } else {
                return [
                    "code" => 422,
                    "message" => "Email " . $params['email'] . " kích hoạt thất bại"
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
    public function getDataFilter(){
        $sources = Sources::select(['id', 'name', 'sources_types'])->get();
        $status = LstStatus::select(['id', 'name', 'color', 'bg_color', 'border_color'])->get();
        $tags = Tags::select(['id', 'name'])->get();
        $marjors = Marjors::select(['id', 'name'])->get();
        $filters = ConfigFilter::select(['id', 'name', 'start_date', 'end_date'])->get();
        $employees = $this->employee->get();
        $transaction_status = TransactionStatus::select(['id', 'name'])->get();
        $transaction_types = TransactionTypes::select(['id', 'name'])->get();

        $responseProvinces = file_get_contents(public_path('/assets/js/provinces.json'));
        $provinces = json_decode($responseProvinces, true);

        return [
            "sources"               => $sources,
            "status"                => $status,
            "tags"                  => $tags,
            "marjors"               => $marjors,
            "filters"               => $filters,
            "employees"             => $employees,
            "transaction_status"    => $transaction_status,
            "transaction_types"     => $transaction_types,
            "provinces"             => $provinces,
        ];
    }
    public function update_employees($params, $id){
        try {
            DB::beginTransaction();
            $leads = $this->leads_repository->where('id', $id)->first();
            if (!isset($leads->id)) {
                return [
                    "code"      => 422,
                    "message"   => "Không tìm thấy sinh viên này"
                ];
            }
            if (!isset($params['assignments_id'])) {
                return [
                    "code"      => 422,
                    "message"   => "Vui lòng chọn giáo viên phụ trách"
                ];
            }
            $data = [
                    "assignments_id" => $params['assignments_id'],
                    "updated_by"     => Auth::user()->id
                ];
            $model = $this->leads_repository->updateById($id, $data);
            $result = null;
            if (isset($model->id)) {
                // Tao thông báo khi chuyên tư vấn viên
                // $content = "Bạn vừa được gán phụ trách cho thí sinh " . $model->full_name . "(".$model->id.")";
                $this->create_new_notification($model);
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật tư vấn viên cho sinh viên thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Cập nhật tư vấn viên cho sinh viên không thành công"
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
    public function create_leads_from_support($params){
        $model = $this->_create($params);
        if(isset($model->id)) {
            return [
                "code"      => 200,
                "message"   => "Thêm mới thông tin thành công"
            ];
        } else {
            return [
                "code"      => 422,
                "message"   => "Thêm mới thông tin không thành công"
            ];
        }
    }
    public function update_custom_fields($params, $id){
        $dem = Leads::where('id', $id)->count();
        if($dem <=0) {
            return [
                "code"      => 422,
                "message"   => "Không tìm thấy sinh viên này trên hệ thống"
            ];
        }
        if(count($params) <= 0) {
            return [
                "code"      => 422,
                "message"   => "Không tìm thấy dữ liệu cần cập nhật"
            ];
        }
        $data = [
            "extended_fields" => json_encode($params)
        ];
        $update = $this->leads_repository->updateById($id, $data);
        if(isset($update->id)) {
            return [
                "code"      => 200,
                "message"   => "Thêm mới thông tin thành công"
            ];
        } else {
            return [
                "code"      => 422,
                "message"   => "Thêm mới thông tin không thành công"
            ];
        }
    }
    public function get_status_history($id){
        $default_support_id = LstStatus::STATUS_DEFAULT;
        $model = LstStatusHistory::with(['status', 'leads:id,full_name'])
                    ->where('leads_id', $id)->get()->toArray();
        $data = null;
        foreach ($model as $item) {
            if(in_array($item['lst_status_id'], $default_support_id)) {
                $data[] =   $item['status']['name'];
            }
        }
        return $data;
    }
    // Chuc mung sinh nhat
    private function get_send_mail($email_list){
        if(count($email_list)) {
            foreach ($email_list as $key => $email) {
                $data_sendmail = [
                    "title"         => "Chúc mừng sinh nhật! 🎉",
                    "subject"       => "Chúc mừng sinh nhật! 🎉",
                    "email"         => $email,
                    "to"            => $email,
                    "name"          => $key
                ];
                Log::info("Gui mail chuc mung sinh nhat");
                SendMailJobs::dispatch($data_sendmail,'includes.crm.mau_gui_mail_chuc_mung_sinh_nhat');
            }
        }
    }

    public function get_notification_birthday(){
        $to_month = Carbon::now()->format('m');
        $to_day = Carbon::now()->format('d');
        $leads  = Leads::whereMonth('date_of_birth', $to_month)
                ->whereDay('date_of_birth','=',  $to_day)
                ->get()
                ->pluck('email', 'full_name')
                ->toArray();
        $students  = Students::whereMonth('date_of_birth', $to_month)
        ->whereDay('date_of_birth','=',  $to_day)
        ->get()
        ->pluck('email', 'full_name')
        ->toArray();
        if((isset($leads) && count($leads) > 0)  && (isset($students) && count($students) > 0)) {
            $data_email = array_merge($leads,$students);
        } else {
            if(isset($leads) && count($leads) > 0) {
                $data_email = $leads;
            } elseif(isset($students) && count($students) > 0) {
                $data_email = $students;
            }
        }
        $this->get_send_mail($data_email);
    }
    public function import_code_for_leads($params){
        try {
            DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }            
            Excel::import(new UpdateCodeLeadsImports, $params['file']);            
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
}




