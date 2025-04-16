<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sources extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'sources';
    protected $fillable = [
        'id','sources_types','name','code','sources_employees_name','sources_manager_name','location_name','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];
    public function leads() {
        return $this->hasMany(Leads::class, 'sources_id', 'id');
    }
    public function students() {
        return $this->hasMany(Students::class, 'sources_id', 'id');
    }
    public function sources_rate() {
        return $this->hasMany(SourcesRates::class, 'sources_id', 'id');
    }
    public function sources_documents() {
        return $this->hasMany(SourcesDocuments::class, 'sources_id', 'id');
    }
}
