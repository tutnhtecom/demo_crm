<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourcesDocuments extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'sources_documents';
    protected $fillable = [
        'id',
        'code',
        'sources_id',
        'signed_document',
        'signed_content',
        'signed_from_date',
        'signed_to_date',
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
    public function details() {
        return $this->hasMany(Students::class, 'sources_id', 'id');
    }
    public function sources_rate() {
        return $this->hasMany(SourcesRates::class, 'sources_documents_id', 'id');
    }
}
