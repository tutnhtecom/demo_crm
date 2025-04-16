<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DVLKSemesters extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'dvlk_semesters';
    protected $fillable = [
        'id',
        'academy_id',
        'semesters_name',
        'semesters_from_year',
        'semesters_to_year',
        'semesters_full_year',
        'admission_date',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'types'
    ];  
    
    const SEMESTERS_NAME = ["Học kỳ 1", "Học kỳ 2", "Học kỳ 3"];

    const ACADEMY_1 = 1;
    const ACADEMY_2 = 2;
    const ACADEMY_3 = 3;
    const ACADEMY_4 = 4;
    
    const SEMESTERS_NAME_MAP = [
        self::ACADEMY_1 => 'Học kỳ 2',
        self::ACADEMY_2 => 'Học kỳ 3',
        self::ACADEMY_3 => 'Học kỳ 1',
        self::ACADEMY_4 => 'Học kỳ 2',
    ];
    public function dvlk_transactions() {
        return $this->hasMany(DVLKTransactions::class, 'id', 'semesters_id');
    }
    public function price_lists() {
        return $this->hasMany(PriceLists::class, 'id', 'semesters_id');
    }
    public function acadmy_list() {
        return $this->belongsTo(AcademyList::class, 'academy_id', 'id');
    }
}
