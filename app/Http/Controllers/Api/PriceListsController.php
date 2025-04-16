<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePriceListRequest;
use App\Http\Requests\UpdateNotePriceListsRequest;
use App\Http\Requests\UpdatePriceListRequest;
use App\Services\PriceLists\PriceListsInterface;
use Illuminate\Http\Request;

class PriceListsController extends Controller
{
    protected $price_list_interface;
    public function __construct(PriceListsInterface $price_list_interface)
    {   
        $this->price_list_interface = $price_list_interface;
    }
    public function create(CreatePriceListRequest $request) {
        $params = $request->all();                
        return $this->price_list_interface->create($params);
    }
    public function create_multiple(Request $request) {        
        $params = $request->all();                
        return $this->price_list_interface->create_multiple($params);
    }
    
    public function index(Request $request) {
        $params = $request->all();
        return  $this->price_list_interface->index($params);
    }

    public function details($id) {        
        return  $this->price_list_interface->details($id);
    }
    public function update(UpdatePriceListRequest $request, $id){            
        $params = $request->all();        
        return  $this->price_list_interface->update($params, $id);
    }

    public function delete($id){                           
        return  $this->price_list_interface->delete($id);
    }

    public function update_status(Request $request, $id){                           
        $params = $request->all();
        return  $this->price_list_interface->update_status($params,$id);
    }
    public function update_file_pdf(Request $request, $id){                           
        $params = $request->all();
        return  $this->price_list_interface->update_file_pdf($params,$id);
    }
    public function update_note(UpdateNotePriceListsRequest $request, $id){                           
        $params = $request->all();
        return  $this->price_list_interface->update_note($params,$id);
    }
    public function imports(Request $request){
        $params = $request->all();
        return $this->price_list_interface->imports($params);
    }
}
