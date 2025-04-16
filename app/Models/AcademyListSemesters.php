<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademyListSemesters extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'academy_list';
    protected $fillable = [
        'id','name','academy_list_id','admission_year_id','created_at','updated_at',"deleted_at","created_by","updated_by","deleted_by"
    ];

    public function academy_list() {
        return $this->belongsTo(AcademyList::class, 'academy_list_id', 'id');
    }

    public function academy_list_terms() {
        return $this->belongsTo(AcademyListTerms::class, 'admission_year_id', 'id');
    }
}
