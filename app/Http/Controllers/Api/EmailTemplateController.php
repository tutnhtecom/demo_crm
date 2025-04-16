<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmailTemplateRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Http\Requests\UpdateEmailTemplateTypeRequest;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    protected $e_tmp_interface;
    public function __construct(EmailTemplatesInterface $e_tmp_interface)
    {
        $this->e_tmp_interface = $e_tmp_interface;
    }
    public function index(Request $request){
        $params =  $request->all();
        return  $this->e_tmp_interface->index($params);
    }
    public function details($id) {
        return $this->e_tmp_interface->details($id);
    }
    // CreateEmailTemplateRequest
    public function create(CreateEmailTemplateRequest $request) {
        $params =  $request->all();
        return  $this->e_tmp_interface->create($params);
    }
    public function upload_image(Request $request) {
        $params =  $request->all();
        return  $this->e_tmp_interface->uploadImageContent($params);
    }
    // UpdateEmailTemplateRequest
    public function update(UpdateEmailTemplateRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->e_tmp_interface->update($params, $id);
    }
    public function delete($id) {
        return  $this->e_tmp_interface->delete($id);
    }
    public function import_key_email_template(Request $request) {
        $params =  $request->all();
        return  $this->e_tmp_interface->import_key_email_template($params);
    }
}
