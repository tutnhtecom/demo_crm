<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademyListTerms extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'academy_list';
    protected $fillable = [
        'id','academy_list_id','admission_year','opening_day','created_at','updated_at',"deleted_at","created_by","updated_by","deleted_by"
    ];

    public function academy_list() {
        return $this->belongsTo(AcademyList::class, 'academy_list_id', 'id');
    }

}
