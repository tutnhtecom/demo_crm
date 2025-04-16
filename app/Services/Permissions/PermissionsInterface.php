<?php

namespace App\Services\Permissions;
interface PermissionsInterface
{       
    public function index($params);
    public function details($id);
    public function get_id_by_data_all();
    public function set_permission_for_router_name($params);
}

