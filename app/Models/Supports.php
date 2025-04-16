<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supports extends Model
{
    use SoftDeletes;
    use HasFactory;

    const TYPE_LEADS = 0;
    const TYPE_STUDENTS = 1;
    const TYPE_EMPLOYEES = 2;

    const PRIORITY_HIGHT = 1;
    const PRIORITY_LOW = 0;
    
    const PRIORITY_TEXT_MAP = [
        self::PRIORITY_HIGHT => 'Cao',
        self::PRIORITY_LOW => 'Thấp',
    ];
    const PRIORITY_COLOR_MAP = [
        self::PRIORITY_LOW => 'rgb(0, 0, 255)',
        self::PRIORITY_HIGHT => 'rgb(252, 5, 5)',
    ];

    protected $table = 'supports';
    protected $fillable = [
        'id','code','full_name','phone','email','subject','descriptions', 'answers','tags_id','employees_id','send_to','send_cc',
        'sp_status_id','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by', 'types', 'priority_level', 'file_url'
    ];
    public function files() {
        return $this->hasOne(Files::class, 'email', 'email');
    }   
    public function leads() {
        return $this->hasOne(Leads::class, 'email', 'email');
    }   
    public function students() {
        return $this->hasOne(Students::class, 'email', 'email');
    }   
    public function employees() {
        return $this->belongsTo(Employees::class, 'employees_id', 'id');
    }
    public function status() {
        return $this->belongsTo(SupportsStatus::class, 'sp_status_id', 'id');
    }
    public function tags() {
        return $this->belongsTo(Tags::class, 'tags_id', 'id');
    }
}
