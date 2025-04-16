<?php

namespace App\Services\AcademyList;

use App\Imports\AcademicTermsImports;
use App\Imports\ApiListImports;
use App\Jobs\CreateSemestersConfigsJobs;
use App\Models\Leads;
use App\Models\LeadsAcademicTerms;
use App\Models\Semesters;
use App\Repositories\AcademicTermsRepository;
use App\Repositories\AcademyListRespository;
use App\Repositories\ApiListsRepository;
use App\Services\Semesters\SemestersInterface;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AcademyListServices implements AcademyListInterface
{
    use General;
    protected $academy_list_repository;

    public function __construct(AcademyListRespository $academy_list_repository)
    {
        $this->academy_list_repository = $academy_list_repository;
    }

    public function create($params){        
        try {
            DB::beginTransaction();
            $model = $this->academy_list_repository->create($params);
            $result = null;
            if (isset($model->id)) {
                // CreateSemestersConfigsJobs::dispatch($config);
                $result = [
                    "code"      => 200,
                    "message"   => "Thông tin đã được thêm mới thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Thông tin đã được thêm mới không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function index($params){

    }    
    public function details($id){

    }    
    public function import($params){

    } 
    public function update($params, $id){

    }
    // public function update_leads_to_academic($params, $id);    
    public function delete($id){

    }
}