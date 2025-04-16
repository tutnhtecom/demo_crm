<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\DVLKSemesters;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use App\Services\Notifications\NotificationsInterface;
use App\Services\NotificationsGroups\NotificationsGroupsInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notification_interface;
    protected $noti_group_interface;
    protected $email_interface;
    public function __construct(NotificationsInterface $notification_interface, NotificationsGroupsInterface $noti_group_interface, EmailTemplatesInterface $email_interface)
    {
        $this->notification_interface = $notification_interface;
        $this->noti_group_interface   = $noti_group_interface;
        $this->email_interface        = $email_interface;
    }

    public function listNotification(Request $request){
        $search = $request->get('search');
        $data = $this->notification_interface->index($search);
        return view('crm.content.notification.notification_list',compact('data', 'search'));
    }

    public function listNotificationToMe(Request $request){
        $search = $request->get('search');
        $data = $this->notification_interface->notification_heads($search);
        return view('crm.content.notification.notification_list_to_me',compact('data', 'search'));
    }

    public function groupsNotification(Request $request){
        $data = $this->noti_group_interface->getDataGroups();
        return view('crm.content.notification.notification_groups',compact('data'));
    }

    public function groupsNotificationDetail($id){
        $data = $this->noti_group_interface->details($id);        
        $userData = $this->noti_group_interface->getUserEmail();
        return view('crm.content.notification.notification_groups_detail',compact('data', 'userData'));
    }

    public function detailNotification($id){
        $data = $this->notification_interface->details($id);
        return view('crm.content.notification.notification_detail', compact('data'));
    }

    public function createNotification(){
        $data = $this->notification_interface->getData();
        return view('crm.content.notification.notification_create', compact('data'));
    }

    public function sendNotiPriceList(){
        $data = $this->notification_interface->getData();
        $temlate = $this->email_interface->emailTemplates();
        $resultTempEmail = [];
        foreach($temlate as $item){
            if ($item['types_id'] == 3) {
                // Lưu dữ liệu cần thiết vào mảng
                $resultTempEmail[] = [
                    'types_id'   => $item['types_id'],
                    'title'      => $item['title'],
                    'file_name'  => $item['file_name'],
                ];
            }
        }
        $dvlk_semesters = DVLKSemesters::select(['id', 'types', 'note'])->get();
        foreach ($dvlk_semesters as $semester) {
            $semester->note = preg_replace([
                '/năm (\d+)/',   // Thay "năm" + số (VD: năm 2025 → / 2025)
                '/nhập học vào/' // Thay "nhập học vào" → "-"
            ], [
                '/ $1',  // Thay "năm 2025" → "/ 2025"
                '-'      // Thay "nhập học vào" → "-"
            ], $semester->note);
        }
        return view('crm.content.notification.notification_group_pricelist', compact('data', 'resultTempEmail', 'dvlk_semesters'));
    }
}
