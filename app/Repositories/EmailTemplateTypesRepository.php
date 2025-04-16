<?php

namespace App\Repositories;

use App\Models\EmailTemplateTypes;
use App\Models\Sources;

class EmailTemplateTypesRepository extends BaseRepository
{
    public $model;
    public function __construct(EmailTemplateTypes $model)
    {        
        $this->model = $model;        
    }
    
}
