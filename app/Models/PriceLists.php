<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceLists extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'price_lists';
    protected $fillable = [
        'id','leads_id', 'students_id','code','status','title','price','from_date','to_date','note','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by',
        "academic_terms_id",  "semesters_id"
    ];   

    const AUTO_SEND_MAIL = 1;
    const AUTO_NOT_SEND_MAIL = 0;

    const STATUS_NOT_PAID = 0;
    const STATUS_PAID = 1;
    const STATUS_NOT_PAID_TEXT = 'Chưa thanh toán';
    const STATUS_PAID_TEXT = 'Đã thanh toán';
    const STATUS_MAP_TEXT = [
        self::STATUS_NOT_PAID => 'Chưa thanh toán',
        self::STATUS_PAID => 'Đã thanh toán'        
    ];
    
    const COLOR_PAID = [
        "color"         => 'rgba(30, 187, 121, 1)',
        "bg_color"      => 'rgba(30, 187, 121, 0.15)',
        "border_color"  => 'rgba(30, 187, 121, 1)',
    ];
    
    const COLOR_NOT_PAID = [
        "color"         => 'rgb(161, 165, 183)',
        "bg_color"      => 'rgba(161, 165, 183, 0.2)',
        "border_color"  => 'rgb(161, 165, 183)',
    ];
    const COLOR_MAP = [
        self::STATUS_PAID => [
            "color"         => 'rgba(30, 187, 121, 1)',
            "bg_color"      => 'rgba(30, 187, 121, 0.15)',
            "border_color"  => 'rgba(30, 187, 121, 1)',
        ],
        self::STATUS_NOT_PAID => [
            "color"         => 'rgb(161, 165, 183)',
            "bg_color"      => 'rgba(161, 165, 183, 0.2)',
            "border_color"  => 'rgb(161, 165, 183)',
        ]
    ];
    public function leads() {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }
    public function files() {
        return $this->hasOne(Files::class, 'price_list_id', 'id');
    }
    public function semesters() {
        return $this->belongsTo( DVLKSemesters::class, 'semesters_id', 'id');
    }
    
}
