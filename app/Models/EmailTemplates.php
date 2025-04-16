<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplates extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'email_templates';
    protected $fillable = [
        'id','title','types_id','file_name', 'content','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by', 'is_default'
    ];
    const IS_DEFAULT = 1;
    const NOT_IS_DEFAULT = 0;
    const AUTO_SEND_MAIL = 1;
    const AUTO_NOT_SEND_MAIL = 0;
    public function eTemplateTypes() {
        return $this->belongsTo(EmailTemplateTypes::class, 'types_id', 'id');
    }
}
