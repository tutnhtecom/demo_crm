<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'tasks';

    const PRIORITY_LOW = 0;
    const PRIORITY_NORMAL = 1;
    const PRIORITY_HIGHT = 2;  
    
    const PRIORITY_IN = [
        self::PRIORITY_LOW ,
        self::PRIORITY_NORMAL ,
        self::PRIORITY_HIGHT
    ];

    const PRIORITY_MAP = [
        self::PRIORITY_LOW => "Thấp",
        self::PRIORITY_NORMAL => "Trung bình",
        self::PRIORITY_HIGHT => "Cao",        
    ];

    const STATUS_NOT_PROCESSING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;  

    const STATUS_MAP = [
        self::STATUS_NOT_PROCESSING => "Chưa bắt đầu",
        self::STATUS_PROCESSING => "Đang diễn ra",
        self::STATUS_COMPLETED => "Hoàn thành",        
    ];

    const STATUS_MAP_ID = [
        self::STATUS_NOT_PROCESSING,
        self::STATUS_PROCESSING,
        self::STATUS_COMPLETED
    ];
    protected $fillable = [
       'id','employees_id','name','description','from_date','to_date','status','priority',
       'created_at','status','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];
    public function employees() {
        return $this->belongsTo(Employees::class, 'employees_id', 'id');
    }
}
