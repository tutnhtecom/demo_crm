<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateKpisRequest;
use App\Services\Kpis\KpisInterface;
use Illuminate\Http\Request;

class KpisController extends Controller
{
    protected $kpis_interface;
    public function __construct(KpisInterface $kpis_interface)
    {
        $this->kpis_interface = $kpis_interface;
    }

    public function create(Request $req){
        $params = $req->all();
        return $this->kpis_interface->create($params);
    }
    public function update(Request $req){
        $params = $req->all();
        return $this->kpis_interface->update($params);
    }
    // public function update_multiple(Request $req){
    //     $params = $req->all();
    //     return $this->kpis_interface->update_multiple($params);
    // }
    public function cron_data(){        
        return $this->kpis_interface->cron_data();
    }
    public function data(Request $request){        
        $params = $request->all();
        return $this->kpis_interface->data($params);
    }
    public function get_data_kpis(Request $request){           
        $params = $request->all();
        return $this->kpis_interface->get_data_kpis($params);
    }
    public function details($id){        
        return $this->kpis_interface->details($id);
    }
    public function create_notification_kpis_expired() {
        return $this->kpis_interface->create_notification_kpis_expired();
    }
}
