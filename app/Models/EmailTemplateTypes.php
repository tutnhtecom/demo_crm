<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplateTypes extends Model
{
    use SoftDeletes;
    use HasFactory;

    const TYPE_SUPPORTS = 1;
    const TYPE_NEWS = 2;
    const TYPE_PRICE_LISTS = 3;
    const TYPE_NOTIFICATIONS = 4;   
    const TYPE_TRANSACTIONS = 5;

    const TYPE_EMPLOYEES = 6;
    const TYPE_TASK = 7;
    const TYPE_KPIS = 8;

    protected $table = 'email_template_types';
    protected $fillable = [
        'id','name','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];
    public function eTemplates() {
        return $this->hasMany(EmailTemplates::class, 'types_id', 'id');
    }
}
