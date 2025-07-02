<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadsHistory extends Model
{
     // steps
    const REGISTER_PROFILE = 4;
    const REGISTER_TYPE_ONLINE = 1;
    const STATUS_LEADS_CRM = 1;
    const REGISTER_TYPE_CRM = 0;
    const INFORMATION_PROFILE = 2;
    const CONTACTS = 3;
    const FAMILY = 4;
    const SCORE = 5;
    const CONFIRM = 6;
    // Kích hoạt sinh viên
    const ACTIVE_STUDENTS = 1;
    const NOT_ACTIVE_STUDENTS = 0;
    //gender
    const FEMALE = 0;
    const MALE = 1;
    const ORTHER = 2;    
    const APPLY_GENDER_NUMBER = [0,1,2];    
    const GENDER_MAP = [
        self::FEMALE => 'Nữ',
        self::MALE => 'Nam',
        self::ORTHER => 'Khác',
    ];    
    use SoftDeletes;
    use HasFactory;
    protected $table = 'leads_histories';
    protected $fillable = [
        'id', 'full_name','leads_code','code','email','phone','home_phone','avatar','date_of_birth','gender','identification_card','date_identification_card', 'academic_terms_id',
        'place_identification_card','place_of_birth','place_of_wrk_lrn','sources_id','marjors_id','nations_name','ethnics_name','date_of_join_youth_union','date_of_join_communist_party', 'active_student',
        'company_name','company_address','lst_status_id','tags_id','remember_token','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by', 'assignments_id', 'steps',
        'extended_fields', 'parent_id', 'd_email_status', "sources_register_failed"
    ];
    public function create_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function update_by()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function delete_by()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
    public function students()
    {
        return $this->belongsTo(Students::class, 'leads_id', 'id');
    }
    public function sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id');
    }
    public function marjors() {
        return $this->belongsTo(Marjors::class, 'marjors_id', 'id');
    }
    public function status() {
        return $this->belongsTo(LstStatus::class, 'lst_status_id', 'id');
    }
    public function history() {
        return $this->hasMany(LstStatusHistory::class, 'leads_id', 'id');
    }
    public function tags() {
        return $this->belongsTo(Tags::class, 'tags_id', 'id');
    }    
    public function contacts() {
        return $this->hasMany(Contacts::class, 'leads_id', 'id');
    }
    public function one_contacts() {
        return $this->hasMany(Contacts::class, 'leads_id', 'id')->where('type', Contacts::TYPE_ADDRESS);
    }
    public function score() {
        return $this->hasMany(ScoreAdminssions::class, 'leads_id', 'id');
    } 
    public function scores() {
        return $this->belongsTo(ScoreAdminssions::class, 'leads_id', 'id');
    } 
    public function files() {
        return $this->hasMany(Files::class, 'leads_id', 'id');
    } 
    public function supports() {
        return $this->belongsTo(Supports::class, 'email', 'email');
    } 
    public function family() {
        return $this->hasMany(FamilyInformations::class, 'leads_id', 'id');
    } 
    // Văn bằng tốt nghiệp
    public function degree() {
        return $this->hasMany(DegreeInformations::class, 'leads_id', 'id');
    }
    public function employees() {
        return $this->belongsTo(Employees::class, 'assignments_id', 'id');
    }
    // Bảng học phí (prices_list)
    public function price_lists() {
        return $this->hasMany(PriceLists::class, 'leads_id', 'id');
    }
    public function transactions() {
        return $this->hasMany(Transactions::class, 'leads_id', 'id');
    }
    public function notifications()
    {
        return $this->belongsTo(Notifications::class, 'email', 'email');
    }
    public function academic_terms()
    {
        return $this->belongsTo( AcademyList::class, 'academic_terms_id', 'id')->orderBy('id', 'desc');
    }
}
