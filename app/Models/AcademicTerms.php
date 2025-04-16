<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicTerms extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'academic_terms';
    protected $fillable = [
        'id','name','from_year','to_year','note','created_at','updated_at'
    ];   

    public function semesters() {
        return $this->hasMany(Semesters::class, 'academic_terms_id', 'id');
    }
    public function leads() {
        return $this->hasMany(Leads::class, 'academic_terms_id', 'id');
    }
    public function students() {
        return $this->hasMany(Students::class, 'academic_terms_id', 'id');
    }
}
