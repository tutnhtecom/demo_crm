<?php

namespace App\Services\Sources;

interface SourcesInterface
{
    public function index($params);
    public function details($id);
    public function create($params);
    public function create_sources_rate($params);
    public function create_sources_documents($params);
    public function update($params, $id);
    public function update_sources_rate($params, $id);
    public function update_sources_documents($params, $id);
    public function delete($id);
    public function delete_sources_documents($id);
    public function delete_sources_rate($id);
    public function imports($params);
    public function imports_sources_rates($params);
    public function imports_sources_documents($params);
    public function import_sources_price_lists($params);
    public function get_quantity_leads_by_sources ($sources_id);
    public function get_price_lists_leads_by_sources ($params, $sources_id);
    public function get_price_lists_leads_by_sources_for_ajax($params, $sources_id);    
    public function get_payment_for_partners ($params, $sources_id);
    public function get_cities();
    public function get_list_by_fields();
    public function get_price_lists_leads_by_sources_news($params, $id);
    public function get_payment_for_partners_news($params, $id);
    
}
