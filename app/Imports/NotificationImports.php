<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NotificationImports implements ToCollection, WithStartRow, SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $rows)
    {   
        $data = [];
        $row = $rows->filter(function ($row) {
            return $row->filter()->isNotEmpty(); // Lọc bỏ các dòng trống
        });
        foreach ($row as $r) {      
            $data[] = $r[0];
        }              
        return 1;
        return [
            "code" => 200,
            "data" => $data
        ];
    }
}
