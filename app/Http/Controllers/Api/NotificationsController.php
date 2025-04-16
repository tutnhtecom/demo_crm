<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNotificationsRequest;
use App\Http\Requests\UpdateNotificationsRequest;
use App\Models\Notifications;
use App\Services\Notifications\NotificationsInterface;
use App\Traits\General;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    use General;
    protected $noti_interface;
    public function __construct( NotificationsInterface $noti_interface)
    {
        $this->noti_interface = $noti_interface;
    }

    public function notification_heads(){
        $dataNotification = $this->noti_interface->notification_heads()->toArray();
        $data=[];
        if($dataNotification['total']){
            foreach($dataNotification['data'] as $k => $item){
                $data[$k]['id'] = $item['id'];
                $data[$k]['title'] = $item['title'];
                $data[$k]['content'] = $item['content'];
                $data[$k]['created_at'] = date('H:i d/m/Y', strtotime($item['created_at']));
                $data[$k]['status'] = $item['status'];
                $data[$k]['is_open'] = $item['is_open'];
            }
            return [
                "code" => 200,
                "data" => $data,
            ];
        }else{
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }

    }
    public function index(Request $request){
        $params =  $request->all();
        return  $this->noti_interface->index($params);
    }
    public function details($id) {
        return $this->noti_interface->details($id);
    }
    public function create_craft(CreateNotificationsRequest $request){
        $params =  $request->all();
        $params['status'] = Notifications::DRAFT ?? 0;
        $File = $request->file('File');
        if(isset($File)) {
            $extensions = $request->file('File')->getClientOriginalExtension();
            switch ($extensions) {
                case 'txt':
                    $params['email'] = $this->import_file_txt($request->file('File'));
                    break;
                case 'xlsx':
                    $params['email'] = $this->import_file_xls($request->file('File'));
                    break;
                case 'xls':
                    $params['email'] = $this->import_file_xls($request->file('File'));
                    break;
            }
        }
        return  $this->noti_interface->create($params);
    }
    public function create(CreateNotificationsRequest $request) {
        $params =  $request->all();
        $File = $request->file('File');
        if(isset($File)) {
            $extensions = $request->file('File')->getClientOriginalExtension();
            switch ($extensions) {
                case 'txt':
                    $params['email'] = $this->import_file_txt($request->file('File'));
                    break;
                case 'xlsx':
                    $params['email'] = $this->import_file_xls($request->file('File'));
                    break;
                case 'xls':
                    $params['email'] = $this->import_file_xls($request->file('File'));
                    break;
            }
        }
        return  $this->noti_interface->create($params);
    }
    public function update(UpdateNotificationsRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->noti_interface->update($params, $id);
    }
    public function delete($id) {
        return  $this->noti_interface->delete($id);
    }
    public function imports(Request $request){
        $params = $request->all();
        return $this->noti_interface->imports($params);
    }
}
