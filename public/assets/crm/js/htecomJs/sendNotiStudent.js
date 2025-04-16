import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { sendNotiApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $('#ti_modal_send_notification').on('show.bs.modal', function () {
        // Kiểm tra nếu có bất kỳ phần tử nào có class 'error-input'
        if ($('.error-input').length > 0) {
            // Nếu có, ẩn tất cả các phần tử có class 'error-input'
            $('.error-input').hide();
        }
    });

    $('#send_noti_student_email').select2({
        placeholder: "",
        allowClear: true
    });
    
    $(document).on('submit', '#send_noti_student_form', (e) => {
        e.preventDefault();
        $('#send_noti_student_submit').html('Đang gửi...');
        const token             = localStorage.getItem('jwt_token');
        const api               = baseUrl+sendNotiApi;
        let formData            = new FormData();
        let userEmail           = $('#send_noti_account').val();
        let topic               = $('#send_noti_student_thread').val();
        let title               = $('#send_noti_student_title').val();
        let content             = $('.send_noti_student_content').val();
        let sendType            = $('input[name="send_noti_student_type"]:checked').val();
        const iframeDocument    = $('#tiny_ifr').contents().get(0);
        const bodyIframe        = iframeDocument.body;

        formData.append('title', title);
        formData.append('content', content);
        formData.append('status', 1);
        formData.append('email[]', userEmail);
        formData.append('obj_types', 1);
        formData.append('send_types', sendType);
        formData.append('topic', topic);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                if(res.code == 422){
                    handleError('.send_noti_student_email_wrapper .select2-selection', '.send_noti_student_email_wrapper', res.data.email);
                    handleError('#send_noti_student_title', '.send_noti_student_title_wrapper', res.data.title);
                    handleError('.send_noti_student_content', '.send_noti_student_content_wrapper', res.data.content);
                    $('#send_noti_student_submit').html('Gửi');
                } else{
                    $('#send_noti_student_email').val('');
                    $('#send_noti_student_thread').val('');
                    $('#send_noti_student_title').val('');
                    $('.send_noti_student_content').val('');
                    $('#send_noti_student_email').val(null).trigger('change');
                    $(bodyIframe).empty(); 
                    $('#send_noti_student_submit').html('Gửi');                    
                    $.notify(res.message, "success");    
                    $('.btn_close_modal').click();
                }
            },
            error: (xhr, status, err) => {
                console.error(err);
            }
        })
    })
    handleRemoveError('.send_noti_student_email_wrapper', '.select2-selection');
    handleRemoveError('.send_noti_student_title_wrapper', '#send_noti_student_title');
    handleRemoveError('.send_noti_student_content_wrapper', '.send_noti_student_content');
})