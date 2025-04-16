<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionStatusRequest;
use App\Http\Requests\UpdateTransactionStatusRequest;
use App\Services\TransactionStatus\TransactionStatusInterface;
use Illuminate\Http\Request;

class TransactionStatusController extends Controller
{
    protected $tran_status_interface;
    public function __construct(TransactionStatusInterface $tran_status_interface)
    {
        $this->tran_status_interface = $tran_status_interface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->tran_status_interface->index($params);     
    }
    public function details($id) {
        return $this->tran_status_interface->details($id);
    }
    public function create(CreateTransactionStatusRequest $request) {
        $params =  $request->all();
        return  $this->tran_status_interface->create($params);  
    }
    public function createMultiple(Request $request) {
        $params =  $request->all();
        return  $this->tran_status_interface->createMultiple($params);  
    }
    public function update(UpdateTransactionStatusRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->tran_status_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->tran_status_interface->delete($id);  
    }
}
