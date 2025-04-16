<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadsAcademicTerms extends Model
{
    use SoftDeletes;
    use HasFactory;    

    protected $table = 'leads_academic_terms';    
    protected $fillable = [
        "updated_at","leads_id","id","deleted_at","created_at","academic_terms_id"
    ];
    public function leads() {
        return $this->belongsTo(Leads::class, 'leads_id', 'id');
    }
    public function academic_terms() {
        return $this->belongsTo(AcademicTerms::class, 'academic_terms_id', 'id');
    }
}
