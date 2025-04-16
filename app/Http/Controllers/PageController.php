<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Services\Authentication\AuthInterface;
use App\Services\Leads\LeadsInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    protected $auth_interface;
    protected $leads_interface;
    public function __construct(AuthInterface $auth_interface, LeadsInterface $leads_interface)
    {
        $this->auth_interface = $auth_interface;
        $this->leads_interface = $leads_interface;
    }
    public function login() {
        return view('page.login');
    }

    public function register(){
        $data = $this->auth_interface->getDataRegister();
        return view('page.form', $data );
    }
    public function loginCRM() {
        return view('crm.auth.login');
    }
    public function registerCRM() {
        return view('crm.auth.register');
    }

    public function forgotPasswordCRM() {
        return view('crm.auth.forgotPassword');
    }

    public function index(){
        return view('crm.content.leads.index');
    }

    public function profileDetailUserLogin(){
        $data = $this->auth_interface->getInfoUserLogin();
           return view('crm.content.profileUserLogin.profile_user', compact('data'));
    }

    public function change_password(Request $request){
        $email = base64_decode($request->email);
        return view('crm.auth.change_password', compact('email'));
    }

    public function errors(){
        return view('errors.403');
    }
    public function send_mail_link_reset(Request $request) {
        $params = $request->all();
        return $this->auth_interface->send_mail_link_reset($params);
    }
    public function reset_password(Request $request) {
        $params = $request->all();
        return $this->auth_interface->reset_password($params);
    }

    public function application_form($id){
        $data = $this->leads_interface->details($id);
        // $data = ['title' => 'Welcome to Laravel PDF Export'];
        // $pdf = Pdf::loadView('page.application_form', $data);
        // return $pdf->stream('filename.pdf');
        return view('page.application_form', compact('data'));
    }

    public function view_application_form($id){
        // $param = $this->leads_interface->details($id);
        $data = [
            'title' => 'Phiếu đăng ký dự tuyển đại học',
            'data'  => $this->leads_interface->details($id)
        ];
        // dd($data['data']->full_name);
        $pdf = Pdf::loadView('page.application_form', $data);
        return $pdf->stream('filename.pdf');
        // return view('page.application_form');
    }

    public function form_register(){
        return view('formRegister.form_register');
    }
}
