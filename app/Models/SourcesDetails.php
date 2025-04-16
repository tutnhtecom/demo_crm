<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcesDetails extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'sources_details';
    protected $fillable = [
        'id','sources_id','sources_details_id','sources_date','quantity'
    ];
    public function sources() {
        return $this->belongsTo(Sources::class, 'sources_id', 'id');
    }
    public function details() {
        return $this->hasMany(Students::class, 'sources_details_id', 'id');
    }
}
