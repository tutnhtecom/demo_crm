<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LstStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'lst_status_history';
    protected $fillable = [
        'id',
        'leads_id',
        'students_id',
        'lst_status_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function leads() {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }
    public function students() {
        return $this->belongsTo(Students::class, 'lst_status_id', 'id');
    }
    public function status() {
        return $this->belongsTo(LstStatus::class, 'lst_status_id', 'id');
    }

}
