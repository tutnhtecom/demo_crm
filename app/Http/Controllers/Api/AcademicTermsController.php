<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAcademicTermsRequest;
use App\Http\Requests\UpdateAcademicTermsRequest;
use App\Services\AcademicTerms\AcademicTermsInterface;
use Illuminate\Http\Request;

class AcademicTermsController extends Controller
{
    protected $academic_terms_interface;
    public function __construct(AcademicTermsInterface $academic_terms_interface)
    {
        $this->academic_terms_interface = $academic_terms_interface;
    }
    public function create(CreateAcademicTermsRequest $request){
        $params = $request->all();
        return $this->academic_terms_interface->create($params);
    }
    public function index(Request $request){
        $params = $request->all();
        return $this->academic_terms_interface->index($params);
    }
    public function details($id){
        return $this->academic_terms_interface->details($id);
    }
    public function update(UpdateAcademicTermsRequest $request, $id){
        $params = $request->all();
        return $this->academic_terms_interface->update($params, $id);
    }

    public function update_leads_to_academic(Request $request, $id){
        $params = $request->all();
        return $this->academic_terms_interface->update_leads_to_academic($params, $id);
    }

    public function delete($id){
        return $this->academic_terms_interface->delete($id);
    }

    public function imports(Request $request){
        $params = $request->all();
        return $this->academic_terms_interface->import($params);
    }
}
