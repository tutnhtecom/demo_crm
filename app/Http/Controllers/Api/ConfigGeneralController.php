<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConfigVoipRequest;
use App\Http\Requests\UpdateConfigVoipRequest;
use App\Services\ConfigFilters\ConfigFilterInterface;
use Illuminate\Http\Request;

class ConfigGeneralController extends Controller
{
    protected $c_g_inteface;
    public function __construct(ConfigFilterInterface $c_g_inteface)
    {
        $this->c_g_inteface = $c_g_inteface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->c_g_inteface->index($params);     
    }
    public function details($id) {
        return $this->c_g_inteface->details($id);
    }
    public function create(Request $request) {           
        $params =  $request->all();
        return  $this->c_g_inteface->create($params);  
    }    
    
    public function update(Request $request, $id) {                
        $params = $request->all();        
        return  $this->c_g_inteface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->c_g_inteface->delete($id);  
    }
    public function create_config_voip(CreateConfigVoipRequest $request) {                
        $params = $request->all();        
        return  $this->c_g_inteface->create_config_voip($params);  
    }
    public function update_config_voip(UpdateConfigVoipRequest $request, $id) {                
        $params = $request->all();        
        return  $this->c_g_inteface->update_config_voip($params, $id);  
    }
}
