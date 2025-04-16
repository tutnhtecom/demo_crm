<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcesRates extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'sources_rate';
    protected $fillable = [
        'id',
        'sources_id',
        'sources_documents_id',
        "academic_terms_id",
        "semesters_id",
        'expense_name',
        'payment_condition',
        'math_sign',
        'payment_rate',        
        'payment_note',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',        
        'payment_manager_rate',
        'payment_manager_price',
        'payment_terms_note'
        
    ];
    public function sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id');
    }
    public function documents() {
        return $this->belongsTo(SourcesDocuments::class, 'sources_documents_id', 'id');
    }
    public function academic_terms() {
        return $this->belongsTo(AcademicTerms::class, 'academic_terms_id', 'id');
    }
    public function semesters() {
        // return $this->belongsTo(semesters::class, 'semesters_id', 'id');
        return $this->belongsTo(DVLKSemesters::class, 'semesters_id', 'id');
        
    }
}
