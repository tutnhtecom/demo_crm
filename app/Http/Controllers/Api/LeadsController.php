<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactsRequest;
use App\Http\Requests\CreateFamilyRequest;
use App\Http\Requests\CreateLeadsRequest;
use App\Http\Requests\CreateLeadsWithSourcesRequest;
use App\Http\Requests\CreateScoreAdminssionRequest;
use App\Http\Requests\CreateSupportForLeadsRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LeadsImportRequest;
use App\Http\Requests\RegisterProfileRequest;
use App\Http\Requests\UpdateAssignmentsIdRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateStatusLeadRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Requests\UploadMultipleImagesRequest;
use App\Imports\LeadsImport;
use App\Services\Leads\LeadsInterface;
use App\Services\Supports\SupportsInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LeadsController extends Controller
{
    protected  $leads_interface;
    protected  $sp_interface;
    protected  $excel;
    public function __construct(LeadsInterface $leads_interface,
        Excel $excel,
        SupportsInterface $sp_interface
    )
    {
        $this->leads_interface =  $leads_interface;
        $this->sp_interface =  $sp_interface;
        $this->excel =  $excel;
    }
    // RegisterProfileRequest
    public function create(RegisterProfileRequest $request) {
        $params = $request->all();
        return $this->leads_interface->create($params);
    }
    public function uAvatar(UploadImageRequest $request, $id) {
        $params = $request->all();
        return $this->leads_interface->uAvatar($params, $id);
    }
    public function uPersonal(UpdateProfileRequest $request, $id) {
        $params = $request->all();
        return $this->leads_interface->uPersonal($params, $id);
    }
    public function contacts(CreateContactsRequest $request, $id) {
        $params = $request->all();
        return $this->leads_interface->contacts($params, $id);
    }
    // CreateFamilyRequest
    public function family(CreateFamilyRequest $request, $id) {
        $params = $request->all();
        return $this->leads_interface->family($params, $id);
    }
    public function score(CreateScoreAdminssionRequest $request, $id) {
        $params = $request->all();
        return $this->leads_interface->score($params, $id);
    }
    // UploadMultipleImagesRequest
    public function confirm(Request $request, $id) {
        $params = $request->all();
        return $this->leads_interface->confirm($params, $id);
    }
    public function supports(CreateSupportForLeadsRequest $request){
        $params = $request->all();
        return $this->sp_interface->create($params);
    }
    public function register_with_sources(CreateLeadsWithSourcesRequest $request, $sources){
        $params = $request->all();
        return $this->leads_interface->register_with_sources($params, $sources);
    }
    // Quên mật khẩu
    public function forgot_password(ForgotPasswordRequest $request){
        $params = $request->all();
        return $this->leads_interface->forgot_password($params);
    }

    // ---------------------------------------------------------------
    //CRM
    public function data(Request $request){
        $params = $request->all();
        return $this->leads_interface->data($params);
    }
    public function details($id){
        return $this->leads_interface->details($id);
    }
    public function update(UpdateLeadRequest $request, $id){
        $params = $request->all();
        return $this->leads_interface->update($params,$id);
    }
    public function crm_create_lead(CreateLeadsRequest $request){
        $params = $request->all();
        return $this->leads_interface->crm_create_lead($params);
    }
    public function delete($id){
        return $this->leads_interface->delete($id);
    }
    public function delete_multiple(Request $request){
        $params = $request->all();
        return $this->leads_interface->delete_multiple($params);
    }
    public function update_status_lead(UpdateStatusLeadRequest $request, $id){
        $params = $request->all();
        return $this->leads_interface->update_status_lead($params,$id);
    }
    // Xuất file
    public function export(Request $request){
        // ob_end_clean();
        // ob_start();
        $params = $request->all();
        return $this->leads_interface->export($params);
    }
    public function import(Request $request){
        $params = $request->all();
        return $this->leads_interface->import($params);
    }
    public function active(Request $request){
        $params = $request->all();
        return $this->leads_interface->active($params);
    }
    public function update_employees(UpdateAssignmentsIdRequest $request, $id){
        $params = $request->all();
        return $this->leads_interface->update_employees($params, $id);
    }
    public function create_leads_from_support(CreateLeadsWithSourcesRequest $request){
        $params = $request->all();
        return $this->leads_interface->create_leads_from_support($params);
    }

    public function update_custom_fields(Request $request, $id){
        $params = $request->all();
        return $this->leads_interface->update_custom_fields($params, $id);
    }
    public function get_status_history($id){
        return $this->leads_interface->get_status_history($id);
    }
    public function get_notification_birthday() {
        return $this->leads_interface->get_notification_birthday();
    }
    public function import_code_for_leads(Request $request) {        
        $params = $request->all();
        return $this->leads_interface->import_code_for_leads($params);
    }
    public function update_employees_for_leads(Request $request){        
        $params = $request->all();
        return $this->leads_interface->update_employees_for_leads($params);
    }
    public function update_status_for_leads(Request $request){
        $params = $request->all();
        return $this->leads_interface->update_status_for_leads($params);
    }
}
