<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademyList extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'academy_list';
    protected $fillable = [
        'id','name','created_at','updated_at',"deleted_at","created_by","updated_by","deleted_by"
    ];
    const ACADEMY_BEFORE = [1,2];
    const ACADEMY_AFTER = [3,4];
    public function academy_list_semesters() {
        return $this->hasMany(AcademyListSemesters::class, 'id', 'academy_list_id');
    }

    public function academy_list_terms() {
        return $this->hasMany(AcademyListTerms::class, 'id', 'academy_list_id');
    }
}
