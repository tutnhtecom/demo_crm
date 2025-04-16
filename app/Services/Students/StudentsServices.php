<?php

namespace App\Services\Students;

use App\Exports\OfficeStudentsExports;
use App\Exports\StudentsExports;
use App\Imports\StudentImports;
use App\Imports\StudentsImports;
use App\Jobs\UpdateContactsJobs;
use App\Models\Files;
use App\Models\PriceLists;
use App\Jobs\UpdateReplationshipJobs;
use App\Models\ConfigFilter;
use App\Models\Contacts;
use App\Models\FamilyInformations;
use App\Models\Leads;
use App\Models\Students;
use App\Models\Sources;
use App\Models\LstStatus;
use App\Models\LstStatusHistory;
use App\Models\Marjors;
use App\Models\Transactions;
use App\Models\Tags;
use App\Models\TransactionStatus;
use App\Models\TransactionTypes;
use App\Models\User;
use App\Repositories\ContactsRepository;
use App\Repositories\FamilyRepository;
use App\Repositories\LeadsRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\EmployeesRepository;
use App\Repositories\TagsRepository;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StudentsServices implements StudentsInterface
{
    use General, Information;
    protected $st_repository;
    protected $ld_repository;
    protected $family_repository;
    protected $contacts_repository;
    protected $employee;
    protected $lst_status_history;
    protected $tags_repository;
    public function __construct(
        LstStatusHistory $lst_status_history,
        StudentsRepository $st_repository,
        LeadsRepository $ld_repository,
        FamilyRepository $family_repository,
        EmployeesRepository $employee,
        TagsRepository $tags_repository,
        ContactsRepository $contacts_repository
    ) {
        $this->st_repository = $st_repository;
        $this->ld_repository = $ld_repository;
        $this->family_repository = $family_repository;
        $this->contacts_repository = $contacts_repository;
        $this->employee = $employee;
        $this->tags_repository = $tags_repository;
        $this->lst_status_history = $lst_status_history;
    }

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
        $model = Students::with([
            "create_by",
            "update_by",
            "delete_by",
            "user",
            "leads",
            "sources",
            "marjors",
            "status",
            "tags",
            "contacts",
            "score",
            "files",
            "supports",
            "family",
            "employees",
            "degree",
            "price_lists",
            "transactions",
            "notifications"
        ]);

        if (isset($params['keyword'])) {
            $model = $model->where('full_name', 'LIKE', '%' . $params['keyword'] . '%',)
                ->orWhere('code', $params['keyword'])
                ->orWhere('phone', 'LIKE', '%' . $params['keyword'] . '%')
                ->orWhere('email', 'LIKE', '%' . $params['keyword'] . '%')
                ->orWhere('students_code', $params['keyword']);
            if (isset($params['assignments_id'])) {
                $model = $model->where('assignments_id', $params['assignments_id']);
            }
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
            $from_date = Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->startOfDay()->format('Y-m-d H:i:s');;
            $model = $model->where('created_at', '>=', $from_date);
        }
        if (isset($params['to_date'])) {
            $to_date = Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->endOfDay()->format('Y-m-d H:i:s');;
            $model = $model->where('created_at', '<=', $to_date);
        }
        return $model->orderBy('id', 'desc');
    }
    // Hiển thị danh sách thí sinh
    public function data($params)
    {
        try {
            $model = $this->filter($params);
            $entries = $model->get();
            foreach ($entries as $entry) {
                $entry['extended_fields'] = json_decode($entry['extended_fields']);
                $contacts = $entry->contacts->where('students_id', $entry->id)->where('type', contacts::TYPE_ADDRESS)->first();
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
            return [
                'code' => 200,
                'data' => $entries
            ];
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function getDataFilter(){
        $sources = Sources::select(['id', 'name'])->get();
        $status = LstStatus::select(['id', 'name', 'color', 'bg_color', 'border_color'])->get();
        $tags = Tags::select(['id', 'name'])->get();
        $marjors = Marjors::select(['id', 'name'])->get();
        $employees = $this->employee->get();
        $transaction_status = TransactionStatus::select(['id', 'name'])->get();
        $transaction_types = TransactionTypes::select(['id', 'name'])->get();
        $responseProvinces = file_get_contents(public_path('/assets/js/provinces.json'));
        $provinces = json_decode($responseProvinces, true);
        $filters = ConfigFilter::select(['id', 'name', 'start_date', 'end_date'])->get();
        return [
            "sources"               => $sources,
            "status"                => $status,
            "tags"                  => $tags,
            "marjors"               => $marjors,
            "employees"             => $employees,
            "transaction_status"    => $transaction_status,
            "transaction_types"     => $transaction_types,
            "provinces"             => $provinces,
            "filters"               => $filters,
        ];
    }
    // Chi tiết thí sinh
    public function details($id){
        try {
            $model = $this->st_repository->with([
                'sources','marjors','status','tags','contacts','score','user',
                "create_by","update_by","delete_by","files","supports","family",
                "price_lists.files", "transactions.status", "transactions.types","transactions.price_lists", "employees.files","employees.lineVoip"
            ])->where('id', $id);
            $model  = $model->first();
            $model->avatar = $model->files->where('leads_id', $id)->where('types', Files::TYPE_AVATAR)->first()->image_url ?? 'assets/crm/media/svg/avatars/blank.svg';
            $contacts = $model->contacts->where('leads_id', $id)->where('type', contacts::TYPE_ADDRESS)->first();
            // $model->attach_file = $model->files->where('leads_id', $id)->where('types', Files::TYPE_PRICE)->first()->image_url ?? null;
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
    // Hàm xóa phân tử trong mảng
    public function unset_data($data)
    {
        unset($data["id"]);
        unset($data["deleted_at"]);
        unset($data["created_by"]);
        unset($data["updated_by"]);
        unset($data["deleted_by"]);
        unset($data["leads_code"]);
        unset($data["steps"]);
        unset($data["remember_token"]);
        unset($data["created_at"]);
        unset($data["updated_at"]);
    }
    public function stExists($leads_id){
        $status = false;
        $dem = $this->st_repository->where('leads_id', $leads_id)->count();
        if ($dem) $status = true;
        return $status;
    }
    public function count_transactions($leads_id){
        $status = false;
        $dem = Transactions::where('leads_id', $leads_id)->count();
        if ($dem > 0) $status = true;
        return $status;
    }
    public function convert($params){
        try {
            DB::beginTransaction();
            $dem = Leads::where('id', $params['id'])->where('active_student', Leads::ACTIVE_STUDENTS)->count();
            if ($dem > 0) {
                return [
                    "code" => 422,
                    "message" => "Thí sinh này đã trở thành sinh viên chính thức"
                ];
            }
            $check = $this->count_transactions($params['id']);
            if ($check == false) {
                return [
                    "code" => 422,
                    "message" => "Thí sinh này chưa hoàn thiện đầy đủ học phí"
                ];
            }
            // Xóa bỏ những trường không dùng
            $key = [
                "id", "steps", "created_at", "updated_at", "deleted_at", "created_by", "updated_by", "deleted_by", "sources", "marjors", "status", "user", "create_by",
                "update_by", "delete_by", "supports", "files", "family", "contacts", "remember_token", "tags", "score"
            ];
            $data = $this->unset_array($params, $key);
            $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
            $data['students_code'] = $params['leads_code'];
            $data['leads_id'] = $params['id'];
            $model = $this->st_repository->create($data);
            // Update trạng thái chuyển sinh viên chính thức
            Leads::where('id', $params['id'])->update([
                "active_student" => Leads::ACTIVE_STUDENTS
            ]);
            $result = null;
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Chuyển đổi sinh viên chính thức thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Chuyển đổi sinh viên chính thức không thành công"
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
    // Chỉnh sửa thí sinh
    public function update($params, $id){
        try {
            DB::beginTransaction();
            $result = null;
            $update_students = $this->post_update_students($params, $id);
            $leads_id = $update_students['data']['leads_id'];
            $old_email = $update_students['data']['old_email'];
            $new_email = $update_students['data']['new_email'];

            if ($update_students['code'] == 200) {
                // Trường hợp email mới có dữ liệu và không trùng với email cũ cho xử sửa đổi trong email
                if (strlen(trim($new_email)) > 0  && strlen(trim($old_email)) && trim($new_email) != trim($old_email)) {
                    $params['old_email'] = trim($old_email);
                    $this->post_update_user($params);
                }
                // cập nhật thông tin gia đình
                $params['students_id'] = $id;
                if(!isset($params['leads_id'])) $params['leads_id'] = $leads_id;
                $this->post_update_family($params, $leads_id);
                // Cập nhật thông tin liên lạc

                $this->post_update_contacts($params, $id);
                $result = response()->json([
                    "code" => 200,
                    "message" => "Cập nhật danh thông tin thí sinh thành công"
                ], 200);
            } else {
                $result = response()->json([
                    "code" => 401,
                    "message" => "Cập nhật danh thông tin thí sinh không thành công"
                ], 401);
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
    private function post_update_students($params, $id)
    {        $data_update_students = [];
        $old_email = null;
        // Họ và tên
        if (isset($params["full_name"]) && strlen($params["full_name"]) > 0) {
            $data_update_students["full_name"] = trim($params["full_name"]);
        }
        // Email
        if (isset($params["email"]) && strlen($params["email"]) > 0) {
            $old_email =  $this->st_repository->where('id', $id)->first()->email;
            if (trim($params["email"]) != trim($old_email)) $data_update_students["email"] = trim($params["email"]);
        }
        // Giới tính
        if (isset($params["gender"]) && strlen($params["gender"]) > 0) {
            $data_update_students["gender"] = trim($params["gender"]);
        }
        // Số điện thoại
        if (isset($params["phone"]) && strlen($params["phone"]) > 0) {
            $data_update_students["phone"] = trim($params["phone"]);
        }
        // Ngày sinh
        if (isset($params["date_of_birth"]) && strlen($params["date_of_birth"]) > 0) {
            $data_update_students["date_of_birth"] = Carbon::createFromFormat('d/m/Y', trim($params["date_of_birth"]))->format('Y-m-d');
        }
        // CCCD
        if (isset($params["identification_card"]) && strlen($params["identification_card"]) > 0) {
            $data_update_students["identification_card"] = trim($params["identification_card"]);
        }
        // Trạng thái
        if (isset($params["lst_status_id"]) && strlen($params["phone"])) {
            $data_update_students["lst_status_id"] = trim($params["lst_status_id"]);
        }
        // Nguồn tiếp cận
        if (isset($params["sources_id"]) && strlen($params["sources_id"]) > 0) {
            $data_update_students["sources_id"] = trim($params["sources_id"]);
        }
        // Nhân viên tư vấn
        if (isset($params["employees_id"]) && strlen($params["employees_id"]) > 0) {
            $data_update_students["employees_id"] = trim($params["employees_id"]);
        }
        // Chuyên ngành
        if (isset($params["marjors_id"]) && strlen($params["marjors_id"]) > 0) {
            $data_update_students["marjors_id"] = trim($params["marjors_id"]);
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
            $data_update_students["tags_id"] = $new_id;
        }

        $update =  $this->st_repository->updateById($id, $data_update_students);
        $result = null;
        if (isset($update->id)) {
            $result = [
                "code"      => 200,
                "message"   => "Cập nhật thông tin sinh viên thành công",
                "data"      => [
                    "leads_id"  => $update["leads_id"] ?? null,
                    "old_email" => $old_email ?? null,
                    "new_email" => $update["email"] ?? null
                ]
            ];
        } else {
            $result = [
                "code"      => 200,
                "message"   => "Cập nhật thông tin sinh viên không thành công"
            ];
        }
        return $result;
    }
    // Update users
    private function post_update_user($params)
    {
        $data = [];
        // Họ và tên
        if (isset($params["old_email"]) && strlen($params["old_email"]) > 0 && isset($params["email"]) && strlen($params["email"]) > 0) {
            $old_email = trim($params['old_email']);
            $data["email"] = trim($params["email"]);
            $update = User::where('email', $old_email)->update($data);
            $result = null;
            if ($update > 0) {
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
    // -----------------------------------------------------------------
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
    private function post_update_family($params, $leads_id)
    {
        $params['prefix'] = config('app.data.family_prefix') ?? null;
        $params['leads_id'] = (int)$leads_id ?? null;
        $data = $this->getFamilyParrams($params, $leads_id);
        $family = $this->family_repository->where('leads_id', $leads_id)->count();
        $result = null;
        if ($family <= 0) {
            // Chưa có thì tạo mới
            $result = $this->family_repository->createMultiple($data);
        } else {
            // cập nhật
            $result = $this->update_family($data, $leads_id);
        }
        return $result;
    }
    // ------------------------------------------------------------------
    public function getParamsContacts($params, $id)
    {
        $data = [];
        $prefix = config('app.data.contact_prefix') ?? ['hktt', 'dcll'];
        if (count($prefix) > 0) {
            foreach ($prefix as $value) {
                $title = $params['title_' . $value];
                $data[] = [
                    "type" => Contacts::CONTACTS_MAP_ID[$title],
                    "title" => Contacts::CONTACTS_MAP_TEXT[$title],
                    "provinces_name"    => $params['provinces_name_' . $value],
                    "districts_name"    => $params['districts_name_' . $value],
                    "wards_name"        => $params['wards_name_' . $value],
                    "address"           => $params['address_' . $value],
                    "leads_id"          => $params['leads_id'],
                    "students_id"       => $params['students_id']
                ];
            }
        }
        return $data;
    }
    private function post_update_contacts($params, $id)
    {
        $data = $this->getParamsContacts($params, $id);
        $result = null;
        $model = Contacts::where('students_id', $id)->delete();
        $result =  $this->contacts_repository->createMultiple($data);
        // if(count($model)>0) {
        //     // Contacts::where('leads_id', $params['leads_id'])->delete();
        //     $model->delete();
        //     $result =  $this->contacts_repository->createMultiple($data);
        // } else {
        //     $result =  $this->contacts_repository->createMultiple($data);
        // }
        return $result;
    }
    // -------------------------------------------------------------------
    public function import($params)
    {
        try {
            if (!isset($params['File'])) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }
            Excel::import(new StudentImports, $params['File']);

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
    public function export($params){
        try {
            if (!isset($params["fields"])) {
                $params["fields"] = config("data.students.display_fields");
            }
            $query = $this->filter($params);
            $data = $query->get();
            $file_name = "danh_sach_sinh_vien_chinh_thuc_" . date('d-m-Y') . '.xlsx';
            // return Excel::download(new StudentsExports($data, $params["fields"]), $file_name);
            return Excel::download(new OfficeStudentsExports($data, $params), $file_name);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function convert_to_leads($id)
    {
        $details = $this->details($id);
        $data = $details['data'];
        $leads_id = $data['leads_id'];
        $data = [
            "active_student"  =>  Leads::NOT_ACTIVE_STUDENTS,
        ];
        // Cập nhật
        Leads::where('id', $leads_id)->update($data);
        $student_delete = $this->st_repository->deleteById($id);
        if ($student_delete == true) {
            return [
                "code"      => 200,
                "message"   => "Sinh viên chính thức đã chuyển sinh viên tiềm năng thành công"
            ];
        } else {
            return [
                "code"      => 422,
                "message"   => "Sinh viên chính thức đã chuyển sinh viên tiềm năng không thành công"
            ];
        }
    }
    private function check_exist_code($code)
    {
        $status = false;
        $count = Students::where('code', $code)->count();
        if ($count > 0) $status = true;
        return $status;
    }
    private function data_for_insert($item) {
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
                $data[] = $this->data_for_insert($item);
            }
        } else {
                $data = $this->data_for_insert($model);
        }

        return $data;
    }
    public function convert_multiple($params) {
        return $this->convert_multiple_leads_to_students($params);
    }
    public function update_multiple_academic_terms($params){
        try {
            DB::beginTransaction();
            $dem = Students::whereIn('id', $params['students_id'])->update([
                "academic_terms_id"     =>   $params['academic_terms_id']
            ]);
            if($dem > 0) {
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật cho niên khóa cho sinh viên thành công"

                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Cập nhật cho niên khóa cho sinh viên không thành công"

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
    //-----------------------------------------------------------------------------
    public function update_status_students($params, $id){
        try {
            $dem = Students::where('id', $id)->count();
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
                "students_id"          => $id,
                "lst_status_id"     => $params['lst_status_id'],
                "created_by"        => Auth::user()->id
            ];
            $history_count = $this->lst_status_history->where('students_id', $id)->where('lst_status_id')->count();
            if($history_count <= 0) {
                $this->lst_status_history->create($data_history);
            }
            $update = $this->st_repository->updateById($id, $data);
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
    private function get_data_ids($params) {
        $ids = Students::whereIn('id', $params['ids'] )->get()->pluck('id')->toArray();
        return $ids;        
    }
    public function convert_multiple_students_to_leads($params) {
        try {
            DB::beginTransaction();
            // if(!isset($params["ids"])) {
            //     return [
            //         "code"      => 422,
            //         "message"   => "Vui lòng chọn danh sách sinh viên chính thức"
            //     ];
            // }       
             $ids = $this->get_data_ids($params);
             $params['ids'] = $ids;
             if(!isset($params["ids"])) {
                return [
                    "code"      => 422,
                    "message"   => "Vui lòng chọn ít nhất 1 Sinh viên"
                ];
             }elseif( count($params["ids"]) <= 0) {
                return [
                    "code"      => 423,
                    "message"   => "Sinh viên được chọn không có trên hệ thống"
                ];
            }
            // Update leads        
            $leads_id = $this->get_output_by_array_id("students", "id", $params["ids"], "leads_id");        
            Leads::whereIn('id', $leads_id)->update([
                'active_student'    =>  Leads::NOT_ACTIVE_STUDENTS
            ]);   
            // delete students
            $model = $this->delete_by_list_id("students", "id" ,$params["ids"] );
            $result = null;
            if ($model == true) {            
                $result = [
                    "code"      => 200,
                    "message"   => "Chuyển đổi sinh viên chính thức thành sinh viên tiềm năng thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Chuyển đổi sinh viên chính thức thành sinh viên tiềm năng không thành công"
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
