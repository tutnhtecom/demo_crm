<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use SoftDeletes;    
    const DRAFT = 0;
    const SEND = 1;    
    const NOTIFICATION_MAP = [
        self::DRAFT => 'Nháp',
        self::SEND => 'Đã gửi'        
    ];

    const OBJECT_LEADS = 0;
    const OBJECT_STUDENTS = 1;
    const OBJECT_EMPLOYEES = 2;
    const OBJECT_GROUPS = 3;
    
    const OBJECT_MAP = [
        self::OBJECT_LEADS => 'Thí sinh mới',
        self::OBJECT_STUDENTS => 'Sinh viên',
        self::OBJECT_EMPLOYEES => 'Nhân sự',
        self::OBJECT_GROUPS => 'Nhóm thông báo'
    ];

    const SEND_ALL = 0;
    const SEND_MAIL = 1;
    const SEND_SYSTEM = 2;
    
    const SEND_MAP = [
        self::SEND_ALL => 'Tất cả',
        self::SEND_MAIL => 'Mail',
        self::SEND_SYSTEM => 'Hệ thống'
    ];

    const CREATE_LEADS = 0;
    const CREATE_STUDENTS = 1;
    const CREATE_EMPLOYEES = 2;
    
    const CREATE_MAP = [
        self::CREATE_LEADS      => 'Tạo từ Sinh viên tiềm năng',
        self::CREATE_STUDENTS   => 'Tạo từ Sinh viên chính thức',
        self::CREATE_EMPLOYEES  => 'Tạo từ Nhân viên',
    ];

    const OPEN_ACTIVE = 1;
    const OPEN_NOT_ACTIVE = 0;
    protected $table = 'notifications';
    protected $fillable = [
        'id', 'topic', 'email', 'title', 'content', 'obj_types', 'send_types', 'obj_create',
        'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'is_open'
    ];

    public function employees(){
        return $this->hasOne(Employees::class, 'email', 'email');
    }
    public function leads(){
        return $this->hasOne(Leads::class, 'email', 'email');
    }
    public function students(){
        return $this->hasOne(Students::class, 'email', 'email');
    }

    public function createBy(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updateBy(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function deleteBy(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
