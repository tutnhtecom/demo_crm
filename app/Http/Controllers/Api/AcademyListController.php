<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAcademyListTermRequest;
use App\Services\AcademyList\AcademyListInterface;
use Illuminate\Http\Request;

class AcademyListController extends Controller
{
    protected $academy_list_interface;
    public function __construct(AcademyListInterface $academy_list_interface)
    {
        $this->academy_list_interface = $academy_list_interface;
    }
    public function create(CreateAcademyListTermRequest $request){
        dd( $request);
        $params = $request->all();
        return $this->academy_list_interface->create($params);
    }
    public function index(Request $request){
        $params = $request->all();
        return $this->academy_list_interface->index($params);
    }
    public function details($id){
        return $this->academy_list_interface->details($id);
    }
    // public function update(UpdateAcademicTermsRequest $request, $id){
    //     $params = $request->all();
    //     return $this->academy_list_interface->update($params, $id);
    // }

    public function update_leads_to_academic(Request $request, $id){
        $params = $request->all();
        // return $this->academy_list_interface->update_leads_to_academic($params, $id);
    }

    public function delete($id){
        return $this->academy_list_interface->delete($id);
    }

    public function imports(Request $request){
        $params = $request->all();
        return $this->academy_list_interface->import($params);
    }
}
