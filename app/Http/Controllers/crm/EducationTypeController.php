<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\EducationsTypes\EducationsTypesInterface;
use Illuminate\Http\Request;

class EducationTypeController extends Controller
{
    protected $education_type_interface;
    public function __construct(EducationsTypesInterface $education_type_interface)
    {
        $this->education_type_interface = $education_type_interface;
    }

    public function educationType(Request $request){
        $dataResponse = $this->education_type_interface->index($request);
        $data = $dataResponse->getData(true);
        return view('crm.content.educationType.education_type', compact('data'));
    }
}
