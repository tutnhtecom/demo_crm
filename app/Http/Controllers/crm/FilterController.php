<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\ConfigFilters\ConfigFilterInterface;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    protected $config_filter_interface;
    public function __construct(ConfigFilterInterface $config_filter_interface){
        $this->config_filter_interface = $config_filter_interface;
    }

    public function index(Request $request){
        $param      = $request->all();        
        $data       = $this->config_filter_interface->index($param);    
                    
        // $dataFilter = $this->config_filter_interface->getDataFilter();
        return view('crm.content.filters.index', compact("data"));
    }
}
