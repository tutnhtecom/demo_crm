<?php

namespace App\Repositories;

use App\Models\EmailTemplates;

class EmailTemplatesRepository extends BaseRepository
{
    public $model;
    public function __construct(EmailTemplates $model)
    {        
        $this->model = $model;        
    }
    
}
