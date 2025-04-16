<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Supports;
use App\Repositories\SupportsStatusRepository;
use App\Services\Employees\EmployeesInterface;
use App\Services\Leads\LeadsInterface;
use App\Services\Supports\SupportsInterface;
use App\Services\SupportsStatus\SupportsStatusInterface;
use App\Services\Tags\TagsInterface;
use App\Traits\General;
use Illuminate\Http\Request;

class RequestSupportController extends Controller
{
    use General;
    protected $support_interface;
    protected $s_st_interface;
    protected $tags_interface;
    protected $employees_interface;
    protected $leads_interface;
    public function __construct(
        SupportsInterface $support_interface,
        SupportsStatusInterface $s_st_interface,
        TagsInterface $tags_interface,
        EmployeesInterface $employees_interface,
        LeadsInterface $leads_interface,
    )
    {
        $this->support_interface   = $support_interface;
        $this->s_st_interface      = $s_st_interface;
        $this->tags_interface      = $tags_interface;
        $this->employees_interface = $employees_interface;
        $this->leads_interface     = $leads_interface;
    }

    public function listSupport(Request $request){
        $params = $request->all();
        $data_support = $this->support_interface->index($params);     
        $s_st_param = null;
        $support_status = $this->s_st_interface->index($s_st_param);

        $data_support_status = null;
        if($support_status['code'] == 200) {
            $data_support_status = $support_status['data'];
        }

        $dataResponse = $this->tags_interface->index($params);
        $tags = $dataResponse->getData(true);

        $responEmployees = $this->employees_interface->index($params);
        $dataEmployees = $responEmployees->getData(true);

        $dataLeads = $this->leads_interface->data($params);    
        $data = [
            "data"                 => $data_support ??  null,
            "data_support_status"  => $data_support_status  ??  null,
            "tags"                 => $tags['data']  ??  null,
            "employees"            => $dataEmployees['data'] ??  null,
            "dataLeads"            => $dataLeads['data'] ??  null,
        ];        
        return view('crm.content.requestSupport.request_support', $data);
    }

    public function detailSuport($id){
        $dataResponse = $this->support_interface->details($id);
        $data = $dataResponse->getData(true);
        $s_st_param = null;
        $support_status = $this->s_st_interface->index($s_st_param);

        $data_support_status = null;
        if($support_status['code'] == 200) {
            $data_support_status = $support_status['data'];
        }
        return view('crm.content.requestSupport.request_suport_detail', compact('data', 'data_support_status'));

    }
}
