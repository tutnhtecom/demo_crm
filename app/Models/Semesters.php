<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semesters extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'semesters';
    protected $fillable = [
        'id','name','from_day','from_month','from_year','to_day','to_month','to_year', 'academic_terms_id',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];
    public function academic_terms() {
        return $this->belongsTo(AcademicTerms::class, 'academic_terms_id', 'id');
    }
}
