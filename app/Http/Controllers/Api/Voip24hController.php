<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVoip24hRequest;
use App\Http\Requests\UpdateVoip24hRequest;
use App\Services\Voip24h\Voip24hInterface;
use Illuminate\Http\Request;

class Voip24hController extends Controller
{
    protected $voip24h_interface;

    public function __construct(Voip24hInterface $voip24h_interface)
    {
        $this->voip24h_interface = $voip24h_interface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->voip24h_interface->index($params);     
    }

    public function create(CreateVoip24hRequest $request){
        $params =  $request->all();
        return $this->voip24h_interface->create($params);     
    }

    public function update(UpdateVoip24hRequest $request, $id) {
        $params = $request->all();
        return  $this->voip24h_interface->update($params, $id);  
    }

    public function delete($id) {        
        return  $this->voip24h_interface->delete($id);  
    }
}
