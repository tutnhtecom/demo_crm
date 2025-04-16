<?php

namespace App\Repositories;

use App\Models\CustomFieldImports;

class CustomerFieldsImportsRepository extends BaseRepository
{
    public $model;
    public function __construct(CustomFieldImports $model)
    {        
        $this->model = $model;        
    }
    
}
