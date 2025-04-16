<?php

namespace App\Repositories;

use App\Models\SourcesDocuments;

class SourcesDocumentsRepositoy extends BaseRepository
{
    public $model;
    public function __construct(SourcesDocuments $model)
    {        
        $this->model = $model;        
    }
    
}
