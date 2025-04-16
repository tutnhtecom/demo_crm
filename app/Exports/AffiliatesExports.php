<?php

namespace App\Exports;

use App\Models\DVLKStudents;
use App\Models\DVLKTransactions;
use App\Models\SourcesDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AffiliatesExports implements FromCollection, WithMapping, WithHeadings
{
    // 
    protected $data;
    public function __construct($data)
    {        
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
    private function get_fields_list() {
        $acdemy_list = DVLKStudents::select('students_academy')->distinct()->get()->pluck('students_academy')->toArray();
        return $acdemy_list;
    }
    public function headings(): array
    {   
        $acdemy_list = $this->get_fields_list();               
        $fields = [
            'STT',
            'Phân loại',
            'Tên ĐVLK',
            'Địa phương',
            'Số lượng hợp đồng',
            'Tổng học phí'
        ];
        foreach ($acdemy_list as $key => $value) {
            $fields[] = $value;
        }      
        return $fields;
    }
    private function get_quantity_sources_documents($sources_id)
    {        
        $dem = SourcesDocuments::where('sources_id', $sources_id)->count();        
        return $dem ?? 0;
    }
    private function get_data_students($id)
    {       
        $acdemy_list = $this->get_fields_list();         
        $students = DVLKStudents::where('students_sources_id', $id)
                        ->groupBy('students_academy')
                        ->select( 'students_academy', DB::raw('count(id) as total_quantity'))
                        ->get()->pluck('total_quantity', 'students_academy')->toArray();  
        foreach ($acdemy_list as $value) {
            if(!isset($students[$value])) {
                $students[$value] = 0;
            }
        }        
        return $students;
    }
    private function get_data_id_for_students($students_sources_id)
    {
        $students_id = DVLKStudents::where('students_sources_id', $students_sources_id)->get()->pluck('id')->toArray();
        return $students_id;
    }
    private function get_total_transaction($students_id){
        $model = DVLKTransactions::whereIn('students_id', $students_id)->sum("tran_price");        
        return $model;
    }
    public function map($item): array
    {                
        global $i;
        $i++;
        $count_documents = $this->get_quantity_sources_documents($item->id);        
        $students = $this->get_data_students($item->id);
        $students_ids = $this->get_data_id_for_students($item->id);
        $total_price = $this->get_total_transaction($students_ids);
        $data = [
            $i,
            $item->sources_types ?? null,
            $item->name ?? null,
            $item->location_name ?? null,            
            number_format($count_documents, 0, '.', ',') ?? 0,
            number_format($total_price, 0, '.', ',') ?? 0,           
        ];        
        foreach ($students as $q) {
            $data[] = number_format($q, 0, '.', ',') ?? 0 ;
        }

        return $data;
    }
}
