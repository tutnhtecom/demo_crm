<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
     // steps
     const REGISTER_PROFILE = 1;
     const INFORMATION_PROFILE = 2;
     const CONTACTS = 3;
     const FAMILY = 4;
     const SCORE = 5;
     const CONFIRM = 6;
 
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
     const GENDER_MAP_TEXT = [
         self::FEMALE => 'Nữ',
         self::MALE => 'Nam',
         self::ORTHER => 'Khác',
     ];
     use SoftDeletes;
     use HasFactory;
     protected $table = 'students';
     protected $fillable = [
            'id', 'full_name', 'code', 'email', 'phone', 'home_phone', 'avatar', 'date_of_birth', 'gender', 'identification_card', 'date_identification_card', 'place_identification_card', 
            'place_of_birth', 'place_of_wrk_lrn', 'leads_id', 'sources_id', 'marjors_id', 'nations_name', 'ethnics_name', 'date_of_join_youth_union', 'date_of_join_communist_Party', 
            'company_name', 'company_address', 'lst_status_id', 'tags_id', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'students_code', 'assignments_id',
            'academic_terms_id'

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
    public function leads()
    {
        return $this->hasMany(PriceLists::class, 'leads_id', 'id');
    }

    public function sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id');
    }
    public function new_sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id')->whereNotNull('code');
    }

    public function marjors() {
        return $this->belongsTo(Marjors::class, 'marjors_id', 'id');
    }
    public function status() {
        return $this->belongsTo(LstStatus::class, 'lst_status_id', 'id');
    }
    public function tags() {
        return $this->belongsTo(Tags::class, 'tags_id', 'id');
    }    

    public function employees() {
        return $this->belongsTo(Employees::class, 'assignments_id', 'id');
    }
    
    public function contacts() {
        return $this->hasMany(Contacts::class, 'leads_id', 'leads_id')->whereNull('deleted_at');
    }
    public function score() {
        return $this->hasMany(ScoreAdminssions::class, 'leads_id', 'leads_id');
    } 
    public function files() {
        return $this->hasMany(Files::class, 'leads_id', 'leads_id');
    } 
    public function supports() {
        return $this->belongsTo(Supports::class, 'email', 'email');
    } 
    public function family() {
        return $this->hasMany(FamilyInformations::class, 'leads_id', 'leads_id');
    } 
    // Văn bằng tốt nghiệp
    public function degree() {
        return $this->hasMany(DegreeInformations::class, 'leads_id', 'leads_id');
    }

    // Bảng học phí (prices_list)
    public function price_lists() {
        return $this->hasMany(PriceLists::class, 'leads_id', 'leads_id');
    }
    public function transactions() {
        return $this->hasMany(Transactions::class, 'leads_id', 'leads_id');
    }
    public function notifications()
    {
        return $this->belongsTo(Notifications::class, 'email', 'email');
    }
    public function academic_terms()
    {
        return $this->belongsTo(AcademicTerms::class, 'academic_terms_id', 'id');
    }

    
}
