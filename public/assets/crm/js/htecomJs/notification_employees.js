import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { sendNotiApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $('#send_noti_account').select2({
        placeholder: "",
        allowClear: true
    });
    // $('#send_noti_thread').select2({
    //     placeholder: "",
    //     allowClear: true
    // });
    $(document).on('submit', '#send_notification_employee_form', (e) => {
        e.preventDefault();
        $('.btn_send_noti_employee_wrapper .btn').html('Đang gửi...');
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl+sendNotiApi;

        let userEmail           = $('#send_noti_account_employee').val();
        let topic               = $('#send_noti_thread_employee').val();
        let title               = $('#send_noti_title_employee').val();
        let content             = $('.send_noti_content_employee').val();
        let sendType            = $('input[name="send_noti_type_employee"]:checked').val();
        const iframeDocument    = $('#tiny_ifr').contents().get(0);
        const bodyIframe        = iframeDocument.body;
        
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                title       : title,
                content     : content,
                status      : 0,
                email       : userEmail,
                obj_types   : 2,
                send_types  : sendType,
                topic       : topic,
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('.send_noti_account_employee_wrapper .select2-selection', '.send_noti_account_employee_wrapper', res.data.email);
                    handleError('#send_noti_title_employee', '.send_noti_title_employee_wrapper', res.data.title);
                    handleError('.send_noti_content_employee', '.send_noti_content_employee_wrapper', res.data.content);
                    $('.btn_send_noti_employee_wrapper .btn').html('Gửi');
                } else{
                    $('#send_noti_account_employee').val('');
                    $('#send_noti_thread_employee').val('');
                    $('#send_noti_title_employee').val('');
                    $('.send_noti_content_employee').val('');
                    $('#send_noti_account_employee').val(null).trigger('change');
                    $('#send_noti_thread_employee').val(null).trigger('change');
                    $(bodyIframe).empty(); 
                    $('.btn_send_noti_employee_wrapper .btn').html('Gửi');                    
                    $.notify(res.message, "success");    
                }
            },
            error: (xhr, status, err) => {
                console.error(err);
            }
        })
    })
    handleRemoveError('.send_noti_account_employee_wrapper', '.select2-selection');
    handleRemoveError('.send_noti_title_employee_wrapper', '#send_noti_title_employee');
    handleRemoveError('.send_noti_content_employee_wrapper', '.send_noti_content_employee');

    $(document).on('click', '.btn_noti_employee', function(){
        $('#send_noti_account_employee').val($(this).attr('data-email')).trigger('change');
    });
})