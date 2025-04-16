<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use App\Services\Transactions\TransactionsInterface;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    protected $tran_interface;
    public function __construct(TransactionsInterface $tran_interface)
    {   
        $this->tran_interface = $tran_interface;
    }
    public function create(CreateTransactionsRequest $request) {
        $params = $request->all();        
        return $this->tran_interface->create($params);
    }
    public function create_multiple(Request $request) {
        $params = $request->all();        
        return $this->tran_interface->create_multiple($params);
    }
    public function index(Request $request) {
        $params = $request->all();
        return  $this->tran_interface->index($params);
    }

    public function details($id) {        
        return  $this->tran_interface->details($id);
    }
    public function update(UpdateTransactionsRequest $request, $id){            
        $params = $request->all();        
        return  $this->tran_interface->update($params, $id);
    }

    public function delete($id){                           
        return  $this->tran_interface->delete($id);
    }
    public function createMultiple(Request $request) {
        $params = $request->all();        
        return $this->tran_interface->createMultiple($params);
    }
    public function import_excel(Request $request) {
        $params = $request->all();        
        return $this->tran_interface->import_excel($params);
    }
}
