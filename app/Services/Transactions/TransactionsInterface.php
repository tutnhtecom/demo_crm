<?php

namespace App\Services\Transactions;

interface TransactionsInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);      
    public function update($params, $id);
    public function delete($id);
    public function createMultiple($parrams);
    public function create_multiple($params);
    public function import_excel($params);
}
