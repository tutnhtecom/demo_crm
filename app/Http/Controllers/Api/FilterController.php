<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFilterRequest;
use App\Http\Requests\UpdateFilterRequest;
use App\Models\ConfigFilter;
use App\Services\ConfigFilters\ConfigFilterInterface;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    protected $config_filter_inteface;
    public function __construct(ConfigFilterInterface $config_filter_inteface)
    {
        $this->config_filter_inteface = $config_filter_inteface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->config_filter_inteface->index($params);     
    }
    public function details($id) {
        return $this->config_filter_inteface->details($id);
    }
    public function create(CreateFilterRequest $request) {           
        $params =  $request->all();
        return  $this->config_filter_inteface->create($params);  
    }    
    
    public function update(UpdateFilterRequest $request, $id) {                
        $params = $request->all();        
        return  $this->config_filter_inteface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->config_filter_inteface->delete($id);  
    }
}
