<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'id','code','name','students_id','leads_id','tran_status_id','tran_types_id','price_lists_id','price','tran_date', 'tran_time','note',
        'created_at','updated_at','deleted_at','created_by','updated_by','deleted_by', "academic_terms_id",  "semesters_id"
    ];

    const TRANS_DRAFT       = 1;
    const TRANS_PAID        = 2;
    const TRANS_COMPLETE    = 3;

    const TRANS_MAP = [
        self::TRANS_DRAFT       =>  "Bản nháp",
        self::TRANS_PAID        =>  "Chờ chuyển khoản",
        self::TRANS_COMPLETE    =>  "Đã hoàn thành"
    ];

    const TRANS_ID_MAP = [
        self::TRANS_DRAFT       =>  "Bản nháp",
        self::TRANS_PAID        =>  "Chờ chuyển khoản",
        self::TRANS_COMPLETE    =>  "Đã hoàn thành"
    ];
    const LESS = 0;
    const EQUAL = 1;
    const GREATE = 2;
    const COMPARE_MAP = [
        self::LESS      =>  "Tổng học phí phải đóng đang ít hơn học phí phải đóng",
        self::EQUAL     =>  "Tổng học phí phải đóng đã đủ với học phí phải đóng",
        self::GREATE    =>  "Tổng học phí phải đóng đang lớn hơn học phí phải đóng"
    ];



    public function leads() {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }
    public function students() {
        return $this->belongsTo(Students::class, 'students_id', 'id');
    }
    public function status() {
        return $this->belongsTo(TransactionStatus::class, 'tran_status_id', 'id');
    }
    public function types() {
        return $this->belongsTo(TransactionTypes::class, 'tran_types_id', 'id');
    }
    public function price_lists() {
        return $this->belongsTo(PriceLists::class, 'price_lists_id', 'id');
    }
    public function semesters() {
        return $this->belongsTo(DVLKSemesters::class, 'semesters_id', 'id');
    }
}
