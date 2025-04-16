<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSemesterRequest;
use App\Services\Affiliate\AffiliateInterface;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    protected $affiliate_interface;
    public function __construct(AffiliateInterface $affiliate_interface)
    {
        $this->affiliate_interface = $affiliate_interface;
    }
    public function get_data_transaction(Request $request, $id){        
        $params = $request->all();
        return $this->affiliate_interface->get_data_transaction($params, $id);
    }
    public function details_semesters($id){
        return $this->affiliate_interface->details_semesters($id);
    }
    public function delete_semesters($id){
        return $this->affiliate_interface->delete_semesters($id);
    }
    public function imports_transactions(Request $request){
        $params = $request->all();
        return $this->affiliate_interface->imports_transactions($params);
    }
    public function create_semesters(CreateSemesterRequest $request) {
        $params = $request->all();
        return $this->affiliate_interface->create_semesters($params);
    }
    public function update_semesters(Request $request, $id) {
        $params = $request->all();
        return $this->affiliate_interface->update_semesters($params, $id);
    }
    public function get_data_commission_for_affiliate(Request $request, $id){
        $params = $request->all();
        return $this->affiliate_interface->get_data_commission_for_affiliate($params, $id);
    }
    public function auto_create_semesters(){        
        return $this->affiliate_interface->auto_create_semesters();
    }

    public function export_overview(Request $request) {
        $params = $request->all();
        return $this->affiliate_interface->export_overview($params);
    }
    public function export_details(Request $request, $id) {
        $params = $request->all();
        return $this->affiliate_interface->export_details($id);
    }
}
