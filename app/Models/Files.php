<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'files';
    protected $fillable = [
        'id','title', 'email', 'types', 'leads_id', 'price_list_id', 'employees_id', 'students_id', 'image_url','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];

    const TYPE_AVATAR = 0;
    const TYPE_PROFILE = 1;
    const TYPE_FILES = 2;
    const TYPE_PRICE = 3;
    const TYPE_EMAIL_TEMPLAE = 4;

    public function leads() {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }
    public function students() {
        return $this->belongsTo(Students::class, 'students_id', 'id');
    }
    public function supports() {
        return $this->belongsTo(Supports::class, 'email', 'email');
    }
}
