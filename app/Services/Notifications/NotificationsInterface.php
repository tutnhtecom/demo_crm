<?php

namespace App\Services\Notifications;

interface NotificationsInterface
{       
    public function index($params);
    public function notification_heads();
    public function details($id);
    public function create($params);      
    public function update($params, $id);
    public function delete($id);
    public function getData();
    public function getNoti($search = null);
    public function imports($params);
    
}
