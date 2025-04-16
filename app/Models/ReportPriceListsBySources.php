<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportPriceListsBySources extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'report_price_lists_by_sources';
    protected $fillable = [
        'id',
        'sources_id',
        'sources_name',
        'students_id',
        'students_name',
        'students_code',
        'acedemic_term_id',
        'acedemic_term_name',
        'marjors_id',
        "marjors_name",
        'price_lists',
        'created_by',
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
    public function acedemic_term() {
        return $this->belongsTo(AcademicTerms::class, 'acedemic_term_id', 'id');
    }
    public function marjors() {
        return $this->belongsTo(Marjors::class, 'marjors_id', 'id');
    }
}
