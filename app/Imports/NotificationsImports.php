<?php

namespace App\Imports;


use App\Jobs\SendMailJobs;
use App\Models\AcademicTerms;
use App\Models\EmailTemplateTypes;
use App\Models\Leads;
use App\Models\Notifications;
use App\Models\PriceLists;
use App\Models\Semesters;
use App\Models\Students;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

// 
class NotificationsImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    /**
    * @param Collection $collection
    */
    use Information, General;
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 400;
    }  
    private function get_data_students_by_output($table, $condition , $output){
        $model = $this->get_data_by_output($table, $condition, $output);
        return $model;
    }
    private function get_data_email($row){
        $students_code  = isset($row[1]) ? trim($row[1]) : '';
        $email          = $this->get_data_students_by_output("leads",["leads_code" => $students_code], "email");        
        if(strlen($email) <= 0) {
            $email  = $this->get_data_students_by_output("students",["students_code" => $students_code], "email");
        }
        return $email;
    }
    public function model(array $row)
    {         
        $email          = $this->get_data_email($row); 
        $title          = trim($row[2]);
        $topic          = trim($row[2]);
        $content        = isset($row[3]) ? json_encode(trim($row[3])) : '';              
        $contents       = $this->get_data_content($content);         
        $obj_types      = Notifications::OBJECT_STUDENTS;
        $send_types     = Notifications::SEND_MAIL;
        $status         = Notifications::SEND;
        $is_open        = Notifications::OPEN_ACTIVE;            
        $data = [
            "email"         => $email,
            "title"         => $title,
            "topic"         => $topic,
            "content"       => implode(', ', $contents),
            "obj_types"     => $obj_types,
            "send_types"    => $send_types,
            "status"        => $status,
            "is_open"       => $is_open,
        ];                                
        $model = Notifications::create($data);
        if(isset($model->id)) {                
            $data_sendmail = [
                "title"         => $data['title'],
                'subject'       => $data['title'],                
                "content"       => $contents,
                'to'            => $data['email'],
                'email'         => $data['email']
            ];              
            SendMailJobs::dispatch($data_sendmail,'includes.notifications');
        } 
    }   
    function get_data_content($data_content){                 
        $data =  explode(',', json_decode($data_content));
        $content = [];
        foreach ($data as $item) {
            if($item != null) $content[] = trim($item);
        }                        
        return $content;
    }
    public function rules(): array
    {        
        return [
            '1' => ['required',function ($attribute, $value, $fail) { 
                $leads      = Leads::where('leads_code', $value)->count();
                $students   = Students::where('students_code')->count();
                if ($leads <= 0 && $students <=0 ) {
                    $fail('Mã số sinh viên: ' . $value . ' không tồn tại');
                }
            }], 
            '2' => ['required'], 
            '3' => ['required'],                   
        ];
    }
    public function customValidationMessages()
    {
        return [
            // Mã nhân viên
            '1.required'        => 'Vui lòng điền đầy đủ Mã số sinh viên',            
            // Niên khóa
            '2.required'        => 'Vui lòng nhập đầy đủ tiêu đề',
            // Học kỳ
            '3.required'        => 'Vui lòng nhập nội dung',            
         
        ];
    }
}
