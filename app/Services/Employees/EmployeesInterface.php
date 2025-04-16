<?php

namespace App\Services\Employees;

interface EmployeesInterface
{
    public function index($params);
    public function details($id);
    public function create($params);
    public function update($params, $id);
    public function delete($id);
    public function delete_multiple($params);
    public function imports($params);
    public function exports($params);
    public function change_status($id);
    public function dataRole();
    public function dataStatus();
    public function active_system($params);
}
