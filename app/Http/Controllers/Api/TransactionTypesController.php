<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionTypesRequest;
use App\Http\Requests\UpdateTransactionTypesRequest;
use App\Services\TransactionTypes\TransactionTypesInterface;
use Illuminate\Http\Request;

class TransactionTypesController extends Controller
{
    protected $tran_type_interface;
    public function __construct(TransactionTypesInterface $tran_type_interface)
    {
        $this->tran_type_interface = $tran_type_interface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->tran_type_interface->index($params);     
    }
    public function details($id) {
        return $this->tran_type_interface->details($id);
    }
    public function create(CreateTransactionTypesRequest $request) {
        $params =  $request->all();
        return  $this->tran_type_interface->create($params);  
    }
    public function createMultiple(Request $request) {
        $params =  $request->all();
        return  $this->tran_type_interface->createMultiple($params);  
    }
    public function update(UpdateTransactionTypesRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->tran_type_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->tran_type_interface->delete($id);  
    }
}
