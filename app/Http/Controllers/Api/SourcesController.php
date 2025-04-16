<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSourcesDocumentsRequest;
use App\Http\Requests\CreateSourcesRatesRequest;
use App\Http\Requests\CreateSourcesRequest;
use App\Http\Requests\UpdateSourcesDocumentsRequest;
use App\Http\Requests\UpdateSourcesRatesRequest;
use App\Http\Requests\UpdateSourcesRequest;
use App\Services\Sources\SourcesInterface;
use App\Traits\General;
use ArrayIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SourcesController extends Controller
{
    use General;
    protected $sources_interface;
    public function __construct(SourcesInterface $sources_interface)
    {
        $this->sources_interface = $sources_interface;
    }
    public function index(Request $request){
        $params =  $request->all();
        return  $this->sources_interface->index($params);
    }
    public function details($id) {
        return $this->sources_interface->details($id);
    }
    public function create(CreateSourcesRequest $request) {
        $params =  $request->all();
        return  $this->sources_interface->create($params);
    }
    public function create_sources_documents(CreateSourcesDocumentsRequest $request) {
        $params =  $request->all();
        return  $this->sources_interface->create_sources_documents($params);
    }
    public function create_sources_rate(CreateSourcesRatesRequest $request) {
        $params =  $request->all();
        return  $this->sources_interface->create_sources_rate($params);
    }
    public function update(UpdateSourcesRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->sources_interface->update($params, $id);
    }
    public function update_sources_documents(UpdateSourcesDocumentsRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->sources_interface->update_sources_documents($params, $id);
    }
    public function update_sources_rate(UpdateSourcesRatesRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->sources_interface->update_sources_rate($params, $id);
    }
    public function delete($id) {
        return  $this->sources_interface->delete($id);
    }
    public function delete_sources_documents($id) {
        return  $this->sources_interface->delete_sources_documents($id);
    }
    public function delete_sources_rate($id) {
        return  $this->sources_interface->delete_sources_rate($id);
    }
    public function imports(Request $request){
        $params = $request->all();
        return $this->sources_interface->imports($params);
    }
    public function imports_sources_rates(Request $request){
        $params = $request->all();
        return $this->sources_interface->imports_sources_rates($params);
    }
    public function imports_sources_documents(Request $request){
        $params = $request->all();
        return $this->sources_interface->imports_sources_documents($params);
    }
    public function import_sources_price_lists(Request $request){
        $params = $request->all();
        return $this->sources_interface->import_sources_price_lists($params);
    }

    public function get_quantity_leads_by_sources($id){
        return $this->sources_interface->get_quantity_leads_by_sources($id);
    }
    public function get_price_lists_leads_by_sources(Request $request, $id){
        $params = $request->all();
        return $this->sources_interface->get_price_lists_leads_by_sources($params, $id);
    }
    public function get_price_lists_leads_by_sources_news(Request $request, $id){
        $params = $request->all();
        return $this->sources_interface->get_price_lists_leads_by_sources_news($params, $id);
    }
    public function get_payment_for_partners(Request $request, $id){
        $params = $request->all();
        return $this->sources_interface->get_payment_for_partners($params, $id);
    }
    public function get_list_by_fields(){
        return $this->sources_interface->get_list_by_fields();
    }
    public function get_price_lists_leads_by_sources_for_ajax(Request $request, $id){
        $params = $request->all();
        return $this->sources_interface->get_price_lists_leads_by_sources_for_ajax($params, $id);
    }
    // -------------------------------------------
    public function get_payment_for_partners_news(Request $request, $id){
        $params = $request->all();
        return $this->sources_interface->get_payment_for_partners_news($params, $id);
    }
}
