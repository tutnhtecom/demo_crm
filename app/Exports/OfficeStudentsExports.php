<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\MethodAdminssions;
use App\Models\PriceLists;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OfficeStudentsExports implements FromCollection, WithMapping, WithHeadings
{
    protected $data;    
    protected $fields;    
    protected $rm_fields;    
    public function __construct($data, $params) { 
    	$this->data         = $data;
        $this->fields       = $params["fields"];   
        $this->rm_fields    = $params["rm_fields"] ?? [];           
    }

    public function collection()
    {           
        return $this->data;
    }        
    public function headings(): array {      
        foreach ($this->fields as $field) {
            if(isset($field["display_name"])  && !in_array($field["field_name"], $this->rm_fields)) $data[] = $field["display_name"];
        }       
        return $data;
    }

    public function map($item):array{                          
        $data = [];
        foreach ($this->fields as $field) {
            // Ngay sinh
            if(isset($field["field_name"]) && $field["field_name"] ==  "date_of_birth") {
                $item["date_of_birth"] = isset($item->date_of_birth) ? Carbon::createFromFormat('Y-m-d', $item->date_of_birth)->format('d/m/Y') : '';
            }           
            // Tinh trang tu van
            if(isset($item["lst_status_id"]) && isset($field["field_name"]) &&  $field["field_name"] ==  "lst_status_id") {                
                $item["lst_status_id"] = $item->status->name ?? '';
            } 
            // Lấy thông tin liên lạc
            if( isset($field["field_name"]) &&  $field["field_name"] ==  "contacts_dcll") {
                $contacts = isset($item->contacts) ? $item->contacts->where('type', 0)->first() : null;
                $item["contacts_dcll"] = ($contacts["address"] ?? null) . ' ' . ($contacts["wards_name"] ?? null) . ' ' . ($contacts["districts_name"] ?? null) . ' ' . ($contacts["provinces_name"] ?? null);
            }

            if(isset($field["field_name"]) &&  $field["field_name"] ==  "contacts_hktt") {
                $contacts = isset($item->contacts) ? $item->contacts->where('students_id', $item->id)->where('type', 1)->first() : null;
                if(isset($contacts->id)) {
                    $item["contacts_hktt"] = ($contacts["address"] ?? null) . ' ' . ($contacts["wards_name"] ?? null) . ' ' . ($contacts["districts_name"] ?? null) . ' ' . ($contacts["provinces_name"] ?? null);
                }
            }            
            // Giới tính
            if(isset($item["gender"]) && $field["field_name"] ==  "gender") {     
                switch ($item["gender"]) {
                    case '0':
                        $item["gender"] = "Nữ";
                        break;
                    case '1':
                        $item["gender"] = "Nam";
                        break;
                    case '2':
                        $item["gender"] = "Khác";
                        break;
                    default: 
                        $item["gender"] = "Nữ";
                        break;
                } 
            }        
            
            // Nhân viên phụ trách
            if(isset($item["assignments_id"]) && isset($field["field_name"]) &&  $field["field_name"] ==  "assignments_id") { 
                if(isset($item->employees)){
                    $item["assignments_id"] = $item->employees->name ?? '';                   
                }                
            }
            // Nguồn tiếp
            if(isset($field["field_name"]) &&  $field["field_name"] ==  "sources_id") {     
                $item["sources_id"] = isset($item->sources) ? $item->sources->name : '';
            }            
            if(isset($field["field_name"]) &&  $field["field_name"] ==  "marjors_name") {                                        
                // $marjors = isset($item->marjors) ? $item->marjors->where('id', $item->marjors_id)->first() : null;
                $item["marjors_name"] = isset($item["marjors_id"]) ? $item->marjors->name : '';
            }
            if(isset($item["tags_id"]) && isset($field["field_name"]) &&  $field["field_name"] ==  "tags_id") {                                        
                // $tags = $item->tags->where('id', $item->tags_id)->first();
                $item["tags_id"] = $item->tags->name ?? '';
            }            
            if($field["field_name"] ==  "created_time") {
                $item["created_time"] = isset($item->created_at) ? Carbon::parse($item['created_at'])->format('d/m/Y H:i:s') : '';
            } 
            if($field["field_name"] ==  "total_price_lists") {
                $price = isset($item->price_lists) ? $item->price_lists->sum('price') : 0;  
                $item["total_price_lists"] = number_format($price, 0, '.',',') ;
            } 
            if($field["field_name"] ==  "total_transactions") {
                $price = isset($item->transactions) ? $item->transactions->sum('price') : 0;
                $item["total_transactions"] =  number_format($price, 0, '.',',');
            }         
            
            if(isset($field["field_name"] ) && $field["field_name"] ==  "father_name") {
                $item["father_name"] = $item->family->where('type', 0)->first()->full_name ?? '';
            }  
            if(isset($field["field_name"] ) && $field["field_name"] ==  "father_phone") {
                $item["father_phone"] = $item->family->where('type', 0)->first()->phone_number ?? '';
            }  
            if(isset($field["field_name"] ) && $field["field_name"] ==  "mother_name") {
                $item["mother_name"] = $item->family->where('type', 1)->first()->full_name ?? '';
            }  
            if(isset($field["field_name"] ) && $field["field_name"] ==  "mother_phone") {
                $item["mother_phone"] = $item->family->where('type', 1)->first()->phone_number ?? '';
            }              
            // Phuong thuc xet tuyen            
            if(isset($field["field_name"] ) && $field["field_name"] ==  "method_name") {
                $item["method_name"]  = isset($item->score[0]) ?  MethodAdminssions::where('id', $item->score[0]["method_adminssions_id"])->first()->name : '';
            }  
             // Khóa tuyển sinh
            if(isset($field["field_name"] ) && $field["field_name"] ==  "academy_list_name") {                
                $model = PriceLists::with(["semesters"])->where("leads_id", $item->id)->first();                    
                if(isset($model->id) && isset( $model["semesters"]) && isset($model["semesters"]["acadmy_list"])) {
                    $item["academy_list_name"] = $model["semesters"]["acadmy_list"]["name"] . ' năm ' .$model["semesters"]["semesters_from_year"] . '-'. $model["semesters"]["semesters_to_year"];
                } else {
                    $item["academy_list_name"] = '';
                }
            }  
            //Gán data
            if(!in_array($field["field_name"], $this->rm_fields))  $data[] = $item[$field["field_name"]] ?? ''; 
        }       
        
        
        return $data;
    }
}
