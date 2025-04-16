<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcesPricesLists extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'source_price_lists';
    protected $fillable = [
        'id',
        'students_id',
        'students_name',
        'students_code',
        'students_phone',
        'students_email',
        'acedemic_term_id',
        'acedemic_term_name',
        'marjors_id',
        'marjors_name',
        'sources_id',
        'sources_name',
        'sources_code',
        'semesters_id',
        'semesters_name',
        'semesters_year',
        'price',
        'old_debt',
        'note',
        'created_by',
        'tran_status',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id');
    }
    public function students() {
        return $this->belongsTo(Students::class, 'students_id', 'id');
    }
    public function academic_terms() {
        return $this->belongsTo(AcademicTerms::class, 'acedemic_term_id', 'id');
    }
    public function marjors() {
        return $this->belongsTo(Marjors::class, 'marjors_id', 'id');
    }
    public function semesters() {
        return $this->belongsTo(Semesters::class, 'semesters_id', 'id');
    }
    
}
