<?php

namespace App\Exports;

use App\Repositories\LeadsRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadsExport implements FromCollection, WithMapping, WithHeadings
{
    // 
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
            'STT',
            'Mã số sinh viên',
            'Họ và tên' ,        
            'Ngày sinh',
            'Số điện thoại',
            'Email',
            'Địa chỉ',
            'Tư vấn viên',
            'Trạng thái',
            'Nguồn MKT',
            'Thời gian',
            'Ngành học',
        ];
    }
    public function map($item):array{            
        GLOBAL $i;
        $contacts = null;
        $date_of_birth = null;
        $status = null;
        if(isset($item->contacts)) {
            $contacts = $item->contacts->where('leads_id', $item->id)->where('type', 0)->first();
        }
        if(isset($item->date_of_birth)) {            
            $date_of_birth = Carbon::createFromFormat('Y-m-d', $item->date_of_birth)->format('d/m/Y');            
        }        
        if(isset($item->lst_status_id)) {
            $status = $item->status->name ?? null;            
        }
        if(isset($item->sources)) {
            $sources_name = $item->sources->name ?? null;            
        }
        if(isset($item->marjors)) {
            $marjors_name = $item->marjors->name ?? null;            
        }
        $address = null;
        if(isset($contacts['districts_name'])){
            $address .= $contacts['districts_name']. ', ';
        }
        if(isset($contacts['provinces_name'])){
            $address .= $contacts['provinces_name'];
        }
        $i++;     
        $data = [
            $i,
            $item->leads_code ?? null,
            $item->full_name ?? null,
            $date_of_birth,
            $item->phone ?? null,
            $item->email ?? null,
            $address,
            $item->employees->name ?? '',        
            $status,
            $sources_name ?? "",
            Date('d/m/Y', strtotime($item->created_at)),            
            $marjors_name ?? "",
        ];        
        return $data;
    }
}
