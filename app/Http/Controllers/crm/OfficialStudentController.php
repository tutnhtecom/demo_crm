<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\Students\StudentsInterface;
use App\Services\CustomFieldImports\CustomFieldImportsInterface;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use App\Services\Transactions\TransactionsInterface;
use App\Models\CustomFieldImports;
use App\Models\Students;
use App\Models\Tags;
use Illuminate\Http\Request;

class OfficialStudentController extends Controller
{
    protected $student_interface;
    protected $transaction_interface;
    protected $interfaces;
    protected $custom_field_interface;
    protected $email_interface;
    public function __construct(StudentsInterface $student_interface, TransactionsInterface $transaction_interface, CustomFieldImportsInterface $custom_field_interface, EmailTemplatesInterface $email_interface)
    {
        $this->student_interface = $student_interface;
        $this->transaction_interface  = $transaction_interface;
        $this->custom_field_interface = $custom_field_interface;
        $this->email_interface        = $email_interface;
    }

    public function listStudent(Request $request){
        $param = $request->all();
        $data = $this->student_interface->data($param);
        $dataFilter = $this->student_interface->getDataFilter();
        return view('crm.content.officialStudent.official_student', $data, $dataFilter);
    }
    public function detailStudent($id){
        $dataId              = $this->student_interface->details($id);
        if(!json_decode($dataId)){
            $msg = "ID không tồn tại.";
            return view('errors.404', ['msg' => $msg]);
        }
        $dataId->gender_name = isset($dataId->gender) ? Students::GENDER_MAP[$dataId->gender] : 'name';
        $customFields        = CustomFieldImports::get();
        $temlate             = $this->email_interface->emailTemplates();
        $resultTempEmail     = [];

        // dd($dataId);
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
        $tags = Tags::select(['id', 'name'])->get();
        return view('crm.content.officialStudent.detail_student', compact('dataId', 'customFields', 'resultTempEmail','tags'));
    }

    public function editStudent($id){
        $dataId = $this->student_interface->details($id);  
        if(!json_decode($dataId)){
            $msg = "ID không tồn tại.";
            return view('errors.404', ['msg' => $msg]);
        }

        $dataFilter = $this->student_interface->getDataFilter();
        // dd($dataId);
        return view('crm.content.officialStudent.edit_student', compact('dataId', 'dataFilter'));
    }
}
