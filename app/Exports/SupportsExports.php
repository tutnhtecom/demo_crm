<?php

namespace App\Exports;

use App\Models\Contacts;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupportsExports implements FromCollection, WithHeadings, WithMapping
{
    protected $data;    
    public function __construct($data) {        
    	$this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
        
    public function headings(): array {
        return [
            '#',
            'Mã người yêu cầu',
            'Người yêu cầu gửi',            
            'Email',            
            'Số điện thoại',            
            'Mô tả yêu cầu',
            'Thẻ',
            'Phụ trách tư vấn',            
            'Trạng thái',
        ];
    }
    public function map($item):array{           
        $status_name = null;        
        if(isset($item->status)) {
            $status_name = $item->status->name; 
        }
        if(isset($item->tags_id)) {
            $tags_name = $item->tags->name;
        }
       
        if(isset($item->employees->name)) {
            $employees_name = $item->employees->name;
        }        
        $data = [           
            $item->code ?? null,
            $item->leads->leads_code ?? null,
            strlen($item->full_name) ? $item->full_name : null,            
            strlen($item->email) ? $item->email : null,
            strlen($item->phone) ? $item->phone : null,
            $item->descriptions ?? null,
            $tags_name ?? null,
            $employees_name ?? null,
            $status_name ?? null
        ];              
        return $data;
    }
}
