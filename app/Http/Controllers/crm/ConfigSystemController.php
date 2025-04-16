<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\ConfigVoip;
use App\Models\EmailTemplateKey;
use App\Services\BlockAdminssions\BlockAdminssionsInterface;
use App\Services\ConfigGeneral\ConfigGeneralsInterface;
use App\Services\CustomFieldImports\CustomFieldImportsInterface;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use App\Services\Marjors\MarjorsInterface;
use App\Services\Status\StatusInterface;
use App\Services\Sources\SourcesInterface;
use Illuminate\Http\Request;

class ConfigSystemController extends Controller
{
    protected $status_interface;
    protected $email_interface;
    protected $custom_field_interface;
    protected $major_interface;
    protected $block_interface;
    protected $sources_interface;
    protected $config_generals_interface;    
    public function __construct(
        StatusInterface $status_interface, 
        EmailTemplatesInterface $email_interface, 
        CustomFieldImportsInterface $custom_field_interface,
        MarjorsInterface $major_interface,
        BlockAdminssionsInterface $block_interface,
        SourcesInterface $sources_interface,
        ConfigGeneralsInterface $config_generals_interface,        
    )
    {
        $this->status_interface             = $status_interface;
        $this->email_interface              = $email_interface;
        $this->custom_field_interface       = $custom_field_interface;
        $this->major_interface              = $major_interface;
        $this->block_interface              = $block_interface;
        $this->sources_interface            = $sources_interface;
        $this->config_generals_interface    = $config_generals_interface;        
    }

    public function configSources(Request $request){        
        $params =  $request->all();
        //Chỉ lấy các bản ghi sources_types =1 (không phải đơn vị liên kết)
        $params['sources_types'] = 1;
        $dataResponse =  $this->sources_interface->index($params);
        $data = $dataResponse->getData(true);
        return view('crm.content.systemConfig.config_sources', compact('data'));
    }

    public function configStatus(Request $request){
        $dataResponse = $this->status_interface->index($request);
        $data = $dataResponse->getData(true);        
        return view('crm.content.systemConfig.config_status', compact('data'));
    }

    public function configEmail(Request $request){
        $data                   = $this->email_interface->index($request);
        $email_types            = $this->email_interface->emailType();
        $email_template         = $this->email_interface->emailTemplates();
        $email_template_key     = $this->email_interface->get_data_email_template_key();     
        $email_template_type    = $this->email_interface->get_data_email_template_type();                
        return view('crm.content.systemConfig.example_mail', compact('data', 'email_types', 'email_template', 'email_template_key', 'email_template_type'));
    }

    public function customFields(Request $request){
        $dataResponse = $this->custom_field_interface->index($request);
        if($dataResponse['message'] != null){
            $data = $dataResponse['data'] ?? null;
        } else{
            $data = [];
        }
        return view('crm.content.systemConfig.custom_fields', compact('data'));
    }

    public function majorSubjectCombination(Request $request){
        $res = $this->major_interface->index($request);
        $data = $res->getData(true);
        return view('crm.content.majorSubjectCombination.majorSubjectCombination', compact('data'));
    }

    public function generalConfiguration(Request $request){
        $res = $this->config_generals_interface->index($request);
        $data = $res->getData(true);
        $voip = ConfigVoip::select(['id', 'api_key', 'api_secret', 'voip_ip'])->get();
        return view('crm.content.generalConfiguration.generalConfiguration', compact('data', 'voip'));
    }
}
