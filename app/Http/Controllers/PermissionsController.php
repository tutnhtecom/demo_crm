<?php

namespace App\Http\Controllers;

use App\Services\Permissions\PermissionsInterface;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    protected $per_inteface;
    public function __construct(PermissionsInterface $per_inteface)
    {
        $this->per_inteface = $per_inteface;
    }

    public function index(Request $request) {
        $params = $request->all();
        return $this->per_inteface->index($params);
    }
    public function details($id) {        
        return $this->per_inteface->details($id);
    }
    public function get_list_id_by_show_data_all() {        
        return $this->per_inteface->get_id_by_data_all();
    }
    public function set_permission_for_router_name(Request $request) {     
        $params = $request->all();   
        return response()->json($this->per_inteface->set_permission_for_router_name($params));
    }
}
