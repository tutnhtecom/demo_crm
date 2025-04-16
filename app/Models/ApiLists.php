<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiLists extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'api_lists';
    protected $fillable = [
       "id","name","request_url","method_name","controller_name","action_name","auth_type","body",
        "created_at","updated_at","deleted_at","created_by","updated_by","deleted_by"
    ];   
}
