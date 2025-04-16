<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'No query provided'], 400);
        }

        // Tìm kiếm trong bảng leads
        $leads = Leads::select('id', 'full_name', DB::raw("'Leads' AS tag"))
                ->where('active_student', 0)
                ->whereNull('deleted_at') // Thêm điều kiện kiểm tra deleted_at IS NULL
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('full_name', 'LIKE', "%{$query}%")
                        ->orWhere('phone', 'LIKE', "%{$query}%");
                })
                ->get();


        // Tìm kiếm trong bảng students
        $students = Students::select('id', 'full_name', DB::raw("'Students' AS tag"))
                ->whereNull('deleted_at') // Thêm điều kiện kiểm tra deleted_at IS NULL
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('full_name', 'LIKE', "%{$query}%")
                        ->orWhere('phone', 'LIKE', "%{$query}%");
                })
                ->get();

        // Kết hợp kết quả
        // $results = $leads->merge($students);
        $results = [
            'leads' => $leads,
            'students' => $students
        ];
        
        // Trả về kết quả
        return response()->json($results);
    }
}
