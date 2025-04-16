<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\AcademyList;
use App\Models\CustomFieldImports;
use App\Models\DVLKSemesters;
use App\Models\Leads;
use App\Models\Tags;
use App\Services\Affiliate\AffiliateInterface;
use App\Services\CustomFieldImports\CustomFieldImportsInterface;
use App\Services\EmailTemplates\EmailTemplatesInterface;
use App\Services\Transactions\TransactionsInterface;
use App\Services\AcademicTerms\AcademicTermsInterface;
use App\Services\Leads\LeadsInterface;
use App\Services\Semesters\SemestersInterface;
use App\Traits\General;
use App\Traits\Information;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    use General, Information;
    protected $lead_interface;
    protected $transaction_interface;
    protected $interfaces;
    protected $custom_field_interface;
    protected $email_interface;
    protected $academic_terms_interface;
    protected $semesters_interface;
    protected $affiliate_interface;
    public function __construct(
        LeadsInterface $lead_interface,
        AcademicTermsInterface $academic_terms_interface,
        TransactionsInterface $transaction_interface,
        CustomFieldImportsInterface $custom_field_interface,
        EmailTemplatesInterface $email_interface,
        SemestersInterface $semesters_interface,
        AffiliateInterface $affiliate_interface,
    ) {
        $this->lead_interface           = $lead_interface;
        $this->transaction_interface    = $transaction_interface;
        $this->custom_field_interface   = $custom_field_interface;
        $this->email_interface          = $email_interface;
        $this->academic_terms_interface = $academic_terms_interface;
        $this->semesters_interface      = $semesters_interface;
        $this->affiliate_interface      = $affiliate_interface;
    }
    public function index(Request $request)
    {
        $param      = $request->all();
        $data       = $this->lead_interface->data($param);        
        $dataFilter = $this->lead_interface->getDataFilter();
        return view('crm.content.leads.index', $data, $dataFilter);
    }

    public function detailLead($id)
    {
        $dataId              = $this->lead_interface->details($id);
        if (!json_decode($dataId)) {
            $msg = "ID không tồn tại.";
            return view('errors.404', ['msg' => $msg]);
        }
        $dataId->gender_name = isset($dataId->gender) ? Leads::GENDER_MAP[$dataId->gender] : 'name';
        $customFields        = CustomFieldImports::get();
        $temlate             = $this->email_interface->emailTemplates();
        $resultTempEmail     = [];
        $academic_terms      = $this->academic_terms_interface->index(array());
        $dataAcademicTerms   = isset($academic_terms["data"]) &&  count($academic_terms["data"]) ? $academic_terms["data"] : null;       
        $dvlk_semesters = $this->get_data_dvlk_semesters(null);
        foreach ($temlate as $item) {
            if ($item['types_id'] == $this->get_email_template_id("Học phí")) {
                // Lưu dữ liệu cần thiết vào mảng
                $resultTempEmail[] = [
                    'types_id'   => $item['types_id'],
                    'title'      => $item['title'],
                    'file_name'  => $item['file_name'],
                ];
            }
        }

        $tags = Tags::select(['id', 'name'])->get();
        return view(
            'crm.content.leads.detail_lead',
            compact(
                'dataId',
                'customFields',
                'resultTempEmail',
                'dataAcademicTerms',
                'dvlk_semesters',
                'tags'
            )
        );
    }

    public function transaction($id)
    {
        $dataId                 = $this->lead_interface->details($id);
        $dataFilter             = $this->lead_interface->getDataFilter();
        $academic_terms         = $this->academic_terms_interface->index(array());
        $dataAcademicTerms      = $academic_terms["data"] ?? null;
        $temlate                = $this->email_interface->emailTemplates();
        $types_id               = $this->get_email_template_id("Giao dich") ?? 4;
        $resultTempEmail        = [];
        foreach ($temlate as $item) {
            if ($item['types_id'] == $types_id) {
                // Lưu dữ liệu cần thiết vào mảng
                $resultTempEmail[] = [
                    'types_id'   => $item['types_id'],
                    'title'      => $item['title'],
                    'file_name'  => $item['file_name'],
                ];
            }
        }
        return view('crm.content.leads.transaction_lead', compact('dataId', 'dataFilter', 'resultTempEmail'));
    }

    public function transactionDetail($id)
    {
        $dataFilter    = $this->lead_interface->getDataFilter();
        $dataResponse  = $this->transaction_interface->details($id);
        $detailTran    = $dataResponse->getData(true);
        $dataId        = isset($detailTran['data']['leads_id']) ? $this->lead_interface->details($detailTran['data']['leads_id']) : null;
        $academic_terms = $this->academic_terms_interface->index(array());
        $dataAcademicTerms = $academic_terms["data"] ?? null;
        $temlate             = $this->email_interface->emailTemplates();
        $resultTempEmail     = [];
        foreach ($temlate as $item) {
            if ($item['types_id'] == $this->get_email_template_id("Giao dich")) {
                // Lưu dữ liệu cần thiết vào mảng
                $resultTempEmail[] = [
                    'types_id'   => $item['types_id'],
                    'title'      => $item['title'],
                    'file_name'  => $item['file_name'],
                ];
            }
        }
        return view('crm.content.leads.transaction_detail', compact('dataId', 'dataFilter', 'detailTran', 'dataAcademicTerms', 'resultTempEmail'));
    }

    public function createLead()
    {
        $dataFilter = $this->lead_interface->getDataFilter();
        return view('crm.content.leads.create_lead', compact('dataFilter'));
    }

    public function editLead($id)
    {
        $dataId     = $this->lead_interface->details($id);
        $dataFilter = $this->lead_interface->getDataFilter();
        return view('crm.content.leads.edit_lead', compact('dataId', 'dataFilter'));
    }

    public function filter(Request $request)
    {        
        $param = $request->all();
        $data  = $this->lead_interface->data($param);
        return response()->json($data);
    }

    public function statistical(Request $request)
    {

        $user = $request->auth;

        // Trả về view và truyền thông tin người dùng
        return view('crm.content.dashboard.statistical', [
            'user' => $user // Truyền dữ liệu vào view
        ]);
        // return view('crm.content.dashboard.statistical');
    }

    public function statistical_kpi()
    {
        return view('crm.content.dashboard.statistical_kpi');
    }

    public function academic_terms(Request $request)
    {
        $data = $this->affiliate_interface->data_semesters($request);
        $academic_data = $data['data'] ?? null;
        $academy_list = AcademyList::select('id', 'name')->get();
        return view('crm.content.academicTerms.academic_list', compact('academic_data', 'academy_list'));
    }

    public function academic_semesters($id)
    {
        $res = $this->academic_terms_interface->details($id);
        $data = $res['data'] ?? null;
        return view('crm.content.academicTerms.academic_semesters', compact('data'));
    }
}
