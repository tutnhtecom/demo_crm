<?php

namespace App\Services\Dashboard;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\PriceLists;
use App\Models\Sources;
use App\Models\Students;
use App\Models\Transactions;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardServices implements DashboardInterface
{
    use General;
    // Khu vực get data tổng
    // -----------------------------------------------------------------------------
    // Sinh viên tiềm năng
    public function get_data_leads($params, $filter_status = false){        
        $model = Leads::with(['status', 'user']);
        if(isset($filter_status) && $filter_status != null) {
            if(isset($params['from_date'])) {
                $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date'])->format('Y-m-d');
            } else {
                $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            }
            if(isset($params['to_date'])) {
                $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date'])->format('Y-m-d');
            } else {
                $to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            }
            $model = $model->whereDate('created_at', '>=' , $from_date);
            $model = $model->whereDate('created_at', '<=' , $to_date);
        }
        return $model;
    }
    // Giao dịch của sinh viên
    public function get_data_transactions($params, $filter_status = false){
        $model = Transactions::where('tran_status_id', Transactions::TRANS_COMPLETE);
        if(isset($filter_status) && $filter_status != false) {
            if(isset($params['from_date'])) {
                $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date'])->format('Y-m-d');
            } else {
                $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            }
            if(isset($params['to_date'])) {
                $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date'])->format('Y-m-d');
            } else {
                $to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            }
            $model = $model->whereDate('created_at', '>=' , $from_date);
            $model = $model->whereDate('created_at', '<=' , $to_date);
        }
        return $model;
    }
    // -----------------------------------------------------------------------------
    // Khu vực get data theo điều kiện
    // -----------------------------------------------------------------------------
    // Data sinh viên mới đăng ký chưa hoàn thiện hồ sơ
    public function report_new_leads($params){
        $model = $this->get_data_leads($params, true);
        $model = $model->whereDoesntHave('transactions')->where('active_student', '<>' , Leads::ACTIVE_STUDENTS)->count();        
        return $model ?? 0;
    }
    // Sinh viên đã hoàn thiện hồ sơ
    public function report_profile_success($params){
        $model = $this->get_data_transactions($params, true);
        $profile_success = $model->with('leads', function ($q) {
            $q->where('active_student', Leads::NOT_ACTIVE_STUDENTS);
        })->count();

        return $profile_success ?? 0;
    }
    // Số lượng sinh viên chính thức
    public function report_to_students($params){
        $model = $this->get_data_leads($params, true);
        $dem = $model->where('active_student', Leads::ACTIVE_STUDENTS )->count();
        $students = Students::count();
        $quantity = 0;
        if($dem == $students) {
            $quantity = $dem;
        } else {
            $quantity = $students;
        }
        return $quantity ?? 0;
    }
    // Tỷ lệ chuyển đổi
    public function rate_converts($params){
        $students = $this->report_to_students($params);
        $user = $this->report_total_leads($params);
        $rate_convert = isset($user) && $user != 0 ? round(($students/$user) * 100, 2) : 0;
        return $rate_convert ?? 0;
    }
    // Tống số thí sinh đã đăng ký
    public function report_total_leads($params){
        $count = $this->get_data_leads($params, true)->count();
        return $count ?? 0;
    }
    // Get data status for leads
    private function get_data_status_for_leads($params){
        $model = $this->get_data_leads($params, true);
        $status = $model->groupBy('lst_status_id')->select('lst_status_id', DB::raw('count(lst_status_id) as total_leads_by_status'))->get();
        $data = [];
        foreach ($status as $value) {
            $data[$value['lst_status_id']] = $value['total_leads_by_status'];
        }
        return  $data;
    }
    // Tổng số thí sinh  theo trạng thái
    public function report_by_status($params){
        $quantity_leads_by_status = $this->get_data_status_for_leads($params);        
        $lst_status = $this->get_data_status();        
        $data = [];
        if(count($quantity_leads_by_status) > 0 && count($lst_status)){
            foreach ($quantity_leads_by_status as $key => $value) {
                foreach ($lst_status as $k => $v) {
                    if($k == $key){
                        $data[$v]  =   $value;
                        unset($lst_status[$k]);
                    } else {
                        $data[$v]  =   0;
                    }
                }
            }
        }
        return $data;
    }
    // Get data chuyên ngành
    public function get_data_marjors(){
        $model = Marjors::select(['id', 'name'])->get();
        foreach ($model as $item) {
            $marjors [$item['id']] = $item['name'];
        }
        return $marjors;
    }
    // Get total price list theo leads _id
    public function get_data_price_list_by_leads_id($params){
        $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date'])->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date'])->format('Y-m-d');      
        $model = PriceLists::where('from_date', '>=', $from_date)
                ->where('to_date', '<=', $to_date)
                ->groupBy('leads_id')
                ->select('leads_id', DB::raw('SUM(price) as total_price_list'))
                ->get()
                ->toArray();
        return $model;
    }
    // Get total transactions theo leads_id
    // ----------------------------------------------------------
    public function get_data_transactions_by_leads_id($params){
        $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date'])->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date'])->format('Y-m-d');
        $model = Transactions::where('tran_status_id', Transactions::TRANS_COMPLETE)
                ->where('created_at', '>=', $from_date)
                ->where('created_at', '<=', $to_date)
                ->groupBy('leads_id')
                ->select('leads_id', DB::raw('SUM(price) as total_transactions'))
                ->get()->toArray();
        return $model;
    }
    private function get_price_list($params, $leads){
        $price_lists = $this->get_data_price_list_by_leads_id($params);
        $data_price_list = [];
        foreach ($leads as $k => $item) {
            $total_price_lists = 0;
            foreach ($item as $v) {
                foreach ($price_lists as $value) {
                    if($value['leads_id'] == $v){
                        $total_price_lists += $value['total_price_list'];
                    }
                }
            }
            $data_price_list[$k] = $total_price_lists;
        }
        return $data_price_list;
    }
    public function get_data_total_price_lists($params){
        // Lấy dữ liệu bảng khoa
        $leads = $this->get_date_leads();
        $data_price_list = $this->get_price_list($params, $leads);
        return  $data_price_list;
    }
    public function get_data_total_transaction($params){
        // Lấy dữ liệu bảng khoa
        $leads = $this->get_date_leads();
        $transactions = $this->get_data_transactions_by_leads_id($params);
        foreach ($leads as $k => $item) {
            $total_transactions = 0;
            foreach ($item as $v) {
                foreach ($transactions as $tValue) {
                    if($tValue['leads_id'] == $v){
                        $total_transactions += $tValue['total_transactions'];
                    }
                }
            }
            $data_transactions[$k] = $total_transactions;
        }
        return $data_transactions;
    }
    public function report_price_by_marjors($params){
        $total_price_lists = $this->get_data_total_price_lists($params);
        $total_transactions = $this->get_data_total_transaction($params);
        $data = [];
        if(count($total_price_lists) > 0 && count($total_transactions ) > 0){
            foreach ($total_price_lists as $key => $value) {
                foreach ($total_transactions as $k => $v) {
                    if($key == $k) {
                        $data[$k] = [
                            "price_list"    => $value,
                            "transactions"  => $v
                        ];
                    }
                }
            }
        }
        return $data;
    }
    public function get_date_leads(){
        $marjors = $this->get_data_marjors();
        $model = Leads::with('marjors')->get()->toArray();
        $data = [];
        $marjors_not_data = null;
        foreach ($marjors as $key => $value) {
            foreach ($model as $item) {
                if($item['marjors_id'] == $key) {
                    $data [$marjors[$key]][] = $item['id'];
                } else {
                    $marjors_not_data = $marjors[$key];
                }
            }
        }
        $data[$marjors_not_data] = [];
        return $data;
    }
    // ----------------------------------------------------------
    // Lấy thông tin đếm số lượng sinh viên tiềm năng theo ngày
        public function report_new_leads_by($params){
            $model = $this->get_data_leads($params, true);
            $model = $model->whereDoesntHave('transactions')->where('active_student', '<>' , Leads::ACTIVE_STUDENTS)->get();            
            return response()->json([
            "code"       => 200,
            "quantity"  => $model ?? 0
            ]);
        }
    // Get data total
    // --------------------------------------------------------------------------------
    private function get_data_sources(){
        $data = [];
        $model = Sources::select(['id', 'name'])->get();
        foreach ($model as $item) {
            $data[$item['id']] = $item['name'];
        }
        return $data;
    }
    private function get_leads_by_sources_id($params){
        $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date'])->startOfDay()->format('Y-m-d H:i:s');
        $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date'])->endOfDay()->format('Y-m-d H:i:s');        
        $model = Leads::whereNotNull('sources_id') // sources_id khác null
                ->whereBetween('created_at', [$from_date, $to_date]) // Lọc theo from_date và to_date
                ->groupBy('sources_id') // Nhóm theo sources_id
                ->select('sources_id', DB::raw('COUNT(id) as total_quantity')) // Chọn cột cần thiết
                ->get()
                ->toArray();
        $data  = [];
        if(count($model) > 0) {
            foreach ($model as $value) {
                    $data[$value['sources_id']] = $value['total_quantity'];
            }
        }
        return $data;
    }
    public function report_total_price_by_sources($params) {
        $leads = $this->get_leads_by_sources_id($params);
        $sources = $this->get_data_sources();
        $data = [];
        foreach ($sources as $key => $value) {
            foreach ($leads as $k => $item) {
                if($key == $k)
                $data[$value] = $item;
            }
        }
        return [
            "code"      => 200,
            "data"      => $data
        ];
    }
    // -----------------------------------------------------------------------------
    // Report số lượng sinh viên mới theo ngày
    public function get_list_date($params){
        if(isset($params['from_date'])) {
            $from_date = Carbon::createFromFormat('d/m/Y', $params['from_date']);
        } else {
            $from_date = Carbon::now()->startOfMonth();
        }
        if(isset($params['to_date'])) {
            $to_date = Carbon::createFromFormat('d/m/Y', $params['to_date']);
        } else {
            $to_date = Carbon::now()->endOfMonth();
        }

        // Duyệt qua từng ngày trong tháng
        $currentDate = $from_date->copy();
        $data = [];
        while ($currentDate->lte($to_date)) {
            $data[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }
        return $data;
    }
    public function report_quantity_leads_by_date($params){
        $arr_date = $this->get_list_date($params);
        $model = Leads::whereDoesntHave('transactions')
        ->where('active_student', '<>' , Leads::ACTIVE_STUDENTS)
        ->select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
            DB::raw('count(*) as total')
        )
        ->groupBy('date')
        ->get()->toArray();

        $data = [];
        foreach ($model as $item) {
            foreach ($arr_date as $k => $value) {
                if($item['date'] == $value){
                    $data[$value] = $item['total'];
                    unset($arr_date[$k]);
                } else {

                    $data[$value] = 0;
                }
            }
        }

        return response()->json([
            "code"  => 200,
            "data"  => $data
        ]);
    }
    // -----------------------------------------------------------------------------
    // Đếm số Thí sinh theo chuyên ngành
    private function total_quantity_leads_by_majors($params){
        $model  = $this->get_data_leads($params, true);
        
        // $model  = $model->groupBy('marjors_id')->select('marjors_id', DB::raw('COUNT(id) as total_quantity'))->get()->toArray();
        $model = $this->group_by($model,'marjors_id', 'marjors_id', 'count(id) as total_quantity');
        $total_leads = $this->get_data_leads($params, true)->whereNotNull('marjors_id')->count();
        $data   = [];
        foreach ($model as $value) {
            $data[$value['marjors_id']] = number_format(($value['total_quantity'] / $total_leads) * 100,2);
        }
        return $data;
    }
    // Top Ngành học thí sinh quan tâm
    public function report_rate_leads_for_marjors($params){
        $data = $this->total_quantity_leads_by_majors($params);
        $marjors = $this->get_data_marjors();
        $rate_by_marjors = [];
        foreach ($data as $key => $value) {
            foreach ($marjors as $k => $item) {
                if($k == $key) {
                    $rate_by_marjors[$item] = (float)$value;
                    unset($marjors[$k]);
                } else {
                    $rate_by_marjors[$item] = 0;
                }

            }
        }
        return response()->json([
            "code"  => 200,
            "data"  => $rate_by_marjors
        ]);
    }
    // -----------------------------------------------------------------------------
    // Tỷ lệ thí sinh theo trạng thái
    public function get_data_status(){
        $model = LstStatus::select(['id', 'name'])->get()->toArray();
        $data = [];
        if(count($model) > 0) {
            foreach ($model as $item) {
                $data [$item['id']] = $item['name'];
            }
        }
        return $data;
    }
    private function total_quantity_leads_by_status($params){
        $model  = $this->get_data_leads($params, true);
        $model = $this->group_by($model,'lst_status_id', 'lst_status_id', 'count(id) as total_quantity');
        $total_leads = $this->get_data_leads($params, true)->count();        
        $data   = [];
        foreach ($model as $value) {
            $data[$value['lst_status_id']] = number_format(($value['total_quantity'] / $total_leads) * 100, 2);
        }        
        return $data;
    }
    // Thống kê trạng thái
    public function report_rate_leads_for_status($params){
        $data   = $this->total_quantity_leads_by_status($params);
        $status = $this->get_data_status();        
        $result = [];
        if(count($data) > 0 && count($status)) {
            foreach ($data as $key => $value) {
                foreach ($status as $k => $v) {
                    if($k == $key) {
                        $result[$v] = (float)$value;
                        unset($status[$key]);
                    } else {
                        $result[$v] = 0;
                    }
                }
            }


        }        
        return [
            'code' => 200,
            'data' => $result
        ];
    }
    // -----------------------------------------------------------------------------
    // Gán dữ liệu
    public function get_list_new_leads(){
        $model = $this->get_data_leads(null, false);
        $model = $model->whereDoesntHave('transactions')->where('active_student', '<>' , Leads::ACTIVE_STUDENTS)->get();
        $data = $model->toArray();
        return [
            "code"  => 200,
            "data"  => $data
        ];
    }
}
