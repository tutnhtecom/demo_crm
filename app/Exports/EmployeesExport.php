<?php

namespace App\Exports;

use App\Models\Employees;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
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
            'STT',
            'Mã nhân viên',
            'Họ và tên' ,        
            'Ngày sinh',
            'Số điện thoại',
            'Email',            
            'Vai trò',
            'Trạng thái'            
        ];
    }
    public function map($item):array{         
        GLOBAL $i;
        $contacts = null;
        $date_of_birth = null;
        $status = isset($item->status) ? Employees::STATUS_MAP[$item->status] : "Đang hoạt động" ;      
        if(isset($item->date_of_birth)) {            
            $date_of_birth = isset($item->date_of_birth) ?  Carbon::createFromFormat('Y-m-d', $item->date_of_birth)->format('d/m/Y') : null;            
        } 
        $i++;     
        $data = [
            $i,
            $item->code ?? null,
            $item->name ?? null,
            $date_of_birth,
            $item->phone ?? null,
            $item->email ?? null,            
            $item->roles->name ?? '',        
            $status
        ];           
        return $data;
    }
}
