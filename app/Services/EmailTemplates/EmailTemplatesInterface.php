<?php

namespace App\Services\EmailTemplates;

interface EmailTemplatesInterface
{
    public function index($params);
    public function details($id);
    public function create($params);
    public function update($params, $id);
    public function delete($id);
    public function emailTemplates();
    public function emailType();
    public function uploadImageContent($params);
    public function import_key_email_template($params);
    public function get_data_email_template_key();
    public function get_data_email_template_type();
}
