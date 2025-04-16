<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomFieldImportsRequest;
use App\Http\Requests\UpdateCustomFieldImportsRequest;
use App\Services\CustomFieldImports\CustomFieldImportsInterface;
use Illuminate\Http\Request;

class CustomFieldImportsController extends Controller
{
    protected $c_f_import_interface;
    public function __construct(CustomFieldImportsInterface $c_f_import_interface)
    {
        $this->c_f_import_interface = $c_f_import_interface;
    }
    public function create(CreateCustomFieldImportsRequest $request){
        $params = $request->all();
        return $this->c_f_import_interface->create($params);
    }
    public function index(Request $request){
        $params = $request->all();
        return $this->c_f_import_interface->index($params);
    }
    public function details($id){
        return $this->c_f_import_interface->details($id);
    }  
    //UpdateCustomFieldImportsRequest
    public function update( Request $request, $id){        
        $params = $request->all();
        return $this->c_f_import_interface->update($params, $id);
    }
    public function delete($id){
        return $this->c_f_import_interface->delete($id);
    }

    public function imports(Request $request){
        $params = $request->all();
        return $this->c_f_import_interface->import($params);
    }
}
