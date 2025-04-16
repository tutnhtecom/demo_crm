<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplateKey extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'email_template_key';
    protected $fillable = [
        "id",
        "display_name",
        "default_key",
        "customs_key",
        "email_template_types_id",
        "created_at",
        "updated_at",
        "deleted_at",
        "created_by",
        "updated_by",
        "deleted_by",
    ];
}
