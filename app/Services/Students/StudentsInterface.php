<?php

namespace App\Services\Students;

interface StudentsInterface
{
    public function convert($params);
    public function update($params, $id);    
    public function details($id);
    public function data($params);
    public function getDataFilter();
    public function import($params);
    public function export($params);
    public function convert_to_leads($id);
    public function convert_multiple($params);
    public function update_multiple_academic_terms($params);
    public function update_status_students($params, $id);
    public function get_data_student($model);
    public function convert_multiple_students_to_leads($params);
}
