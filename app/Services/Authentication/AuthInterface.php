<?php

namespace App\Services\Authentication;

interface AuthInterface
{       
    public function login($params);
    public function register($params);
    public function logout();
    public function userProfile();
    public function changePassWord($params);
    public function refresh();
    public function update_profile($params, $id);
    public function getDataRegister();
    public function getInfoUserLogin();    
    public function reset_password($params);
    public function send_mail_link_reset($params);
}
