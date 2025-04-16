<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\DVLKStudents;
use App\Models\DVLKTransactions;
use App\Models\SourcesDocuments;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AffiliatesExportsDetails implements FromCollection, WithHeadings,WithEvents
{
   // 
   public function collection()
   {
       return collect([
           ['1', 'John Doe', 'johndoe@gmail.com'],
           ['2', 'Jane Doe', 'janedoe@gmail.com'],
       ]);
   }

   public function headings(): array
   {
       return [
           ['DANH SÁCH NGƯỜI DÙNG'], // Dòng tiêu đề 1
           ['ID', 'Tên', 'Email'],  // Dòng tiêu đề 2
       ];
   }
   public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:C1'); // Gộp ô từ A1 đến C1
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Chữ in đậm, cỡ 14
                $sheet->getStyle('A2:C2')->getFont()->setBold(true); // Dòng tiêu đề in đậm
            },
        ];
    }
}
