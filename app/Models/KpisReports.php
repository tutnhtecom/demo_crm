<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpisReports extends Model
{
    use SoftDeletes;
    use HasFactory;    

    protected $table = 'kpis_reports';    
    protected $fillable = [
        'id',
        'kpis_id',
        'employees_id',
        'leads_id',
        'price',
        'date_for_price',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'status',
        'transactions_id',
        "semesters_id",
        "academy_list_id",
        "to_date",
        "from_date",
        "semesters_name",
    ];
    const TRANS_DRAFT       = 1;
    const TRANS_PAID        = 2;
    const TRANS_COMPLETE    = 3;

    const TRANS_MAP = [
        self::TRANS_DRAFT       =>  "Bản nháp",
        self::TRANS_PAID        =>  "Chờ chuyển khoản",
        self::TRANS_COMPLETE    =>  "Đã hoàn thành"
    ];
    public function employees() {
        return $this->belongsTo(Employees::class, 'employees_id', 'id');
    }
}
