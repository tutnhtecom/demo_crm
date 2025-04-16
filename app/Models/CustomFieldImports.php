<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomFieldImports extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'custom_fields_imports';
    protected $fillable = [
        'id','code','name','slug','types','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];   

    const TYPE_LEADS = 0;
    const TYPE_STUDENTS = 1;
    const TYPE_EMPLOYEES = 2;

    const TYPE_MAP = [
        self::TYPE_LEADS => "Sinh viên tiềm năng",
        self::TYPE_STUDENTS => "Sinh viên chính thức",
        self::TYPE_EMPLOYEES => "Nhân viên",
    ];

    const LIST_TYPE = [ self::TYPE_LEADS,self::TYPE_STUDENTS,self::TYPE_EMPLOYEES];
}
