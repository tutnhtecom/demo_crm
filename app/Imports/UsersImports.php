<?php

namespace App\Imports;

use App\Jobs\UsersImportJobs;
use App\Models\User;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
// WithValidation
class UsersImports implements ToCollection, WithStartRow, WithChunkReading, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 100;
    }
    public function collection(Collection $collection)
    {
        $password = Str::random(16);          
        $data_users = [];
        $rows = $collection->filter(function ($row) {
            return $row->filter()->isNotEmpty(); // Lọc bỏ các dòng trống
        });
        foreach ($rows as $row) 
        {
            $data_users[] = [                
                "email"         => trim($row[5]),
                "password"      => Hash::make(trim($password)),
                "status"        => User::ACTIVE,                    
                "types"          => User::TYPE_LEADS,
                "created_by"    => Auth::user()->id ?? null,
            ];   
        }          
        UsersImportJobs::dispatch($data_users);        
    }
}
