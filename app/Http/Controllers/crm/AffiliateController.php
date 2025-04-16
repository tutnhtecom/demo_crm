<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\DVLKSemesters;
use App\Models\DVLKStudents;
use App\Services\Sources\SourcesInterface;
use Illuminate\Http\Request;
use App\Services\AcademicTerms\AcademicTermsInterface;
use App\Services\Affiliate\AffiliateInterface;

class AffiliateController extends Controller
{
    protected $sources_interface;
    protected $academic_terms_interface;
    protected $affiliate_interface;

    public function __construct(
        SourcesInterface $sources_interface,
        AcademicTermsInterface $academic_terms_interface,
        AffiliateInterface $affiliate_interface
    )
    {
        $this->sources_interface = $sources_interface;
        $this->academic_terms_interface = $academic_terms_interface;
        $this->affiliate_interface = $affiliate_interface;
    }
    private function auto_create_semesters() {
        $dem = DVLKSemesters::where('types', 1)->count();        
        if($dem <= 0) {
            $this->affiliate_interface->auto_create_semesters();            
        }        
    }
    public function affiliateSources(Request $request){
        $this->auto_create_semesters();
        $dataResponse = $this->sources_interface->index($request);
        $data = $dataResponse->getData(true);

        $affiliateSources = [];
        if(isset($data['data']) && count($data['data']) > 0) {
            foreach ($data['data'] as $value) {
                if($value['sources_types'] != null){
                    $affiliateSources[] = $value;
                }
            }
        }
        $academic_terms = $this->academic_terms_interface->index(array())['data'] ?? null;
        $cities = $this->sources_interface->get_cities();
        $data = [
            "affiliateSources"  =>  $affiliateSources,
            "cities"            =>  $cities,
            "academic_terms"    =>  $academic_terms,
        ];
        $dvlk_semesters = DVLKSemesters::select(['id', 'types', 'note'])->get();
        return view('crm.content.affiliateManagement.affiliate_management', compact('affiliateSources', 'cities', 'academic_terms','dvlk_semesters'));
    }
    public function affiliateSourcesDetail($id){
        $dataResponse = $this->sources_interface->details($id);        
        $data = $dataResponse->getData(true)['data'];
        $sources_documents = $data['sources_documents'];
        $sources_rate = [];
        foreach ($sources_documents as $sd) {
            $sources_rate[$sd['id']] = $sd['sources_rate'];
        }            
        $cities = $this->sources_interface->get_cities();
        $academic_terms = $this->academic_terms_interface->index(array());
        $dataAcademicTerms = isset($academic_terms["data"]) && count($academic_terms["data"]) ? $academic_terms["data"] : null;
        $dvlk_semesters = DVLKSemesters::select(['id', 'types', 'note'])->get();
        return view('crm.content.affiliateManagement.affiliate_detail', compact('data', 'cities', 'dataAcademicTerms', 'sources_rate','dvlk_semesters'));
    }

}
