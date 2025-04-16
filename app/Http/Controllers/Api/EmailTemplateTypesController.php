<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmailTemplateTypeRequest;
use App\Http\Requests\UpdateEmailTemplateTypeRequest;
use App\Services\EmailTemplateTypes\EmailTemplateTypesInterface;
use Illuminate\Http\Request;

class EmailTemplateTypesController extends Controller
{
    protected $e_tmp_type_interface;
    public function __construct(EmailTemplateTypesInterface $e_tmp_type_interface)
    {
        $this->e_tmp_type_interface = $e_tmp_type_interface;
    }
    public function index(Request $request){
        $params =  $request->all();
        return  $this->e_tmp_type_interface->index($params);
    }
    public function details($id) {
        return $this->e_tmp_type_interface->details($id);
    }
    public function create(CreateEmailTemplateTypeRequest $request) {
        $params =  $request->all();
        return  $this->e_tmp_type_interface->create($params);
    }
    public function update(UpdateEmailTemplateTypeRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->e_tmp_type_interface->update($params, $id);
    }
    public function delete($id) {
        return  $this->e_tmp_type_interface->delete($id);
    }
}
