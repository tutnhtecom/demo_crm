import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { sendNotiApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('#send_noti_account').select2({
        placeholder: "",
        allowClear: true
    });
   
    $(document).on('submit', '#send_notification_form', (e) => {
        e.preventDefault();
        $('.btn-send-noti-wrapper #loader-btn-send-noti').show();
        $('.btn-send-noti-wrapper #ti_modal_users_search_submit').hide();
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl+sendNotiApi;

        let userEmail = $('#send_noti_account').val();
        let topic = $('#send_noti_thread').val();
        let title = $('#send_noti_title').val();
        let content = $('.send_noti_content').val();
        let sendType = $('input[name="send_noti_type"]:checked').val();

        let element     = document.getElementById('ti_modal_users_search_submit');
        let obj_types   = element.getAttribute("data-obj-types");

        const iframeDocument = $('#tiny_ifr').contents().get(0);
        const bodyIframe = iframeDocument.body;

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                title: title,
                content: content,
                status: 1,
                email: userEmail,
                obj_types: obj_types,
                send_types: sendType,
                topic: topic,
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('.send_noti_account_wrapper .select2-selection', '.send_noti_account_wrapper', res.data.email);
                    handleError('#send_noti_title', '.send_noti_title_wrapper', res.data.title);
                    handleError('.send_noti_content', '.send_noti_content_wrapper', res.data.content);

                    $('.btn-send-noti-wrapper #loader-btn-send-noti').hide();
                    $('.btn-send-noti-wrapper #ti_modal_users_search_submit').show();
                    $.notify(res.message, "error");
                } else{
                    $('#send_noti_account').val('');
                    $('#send_noti_thread').val('');
                    $('#send_noti_title').val('');
                    $('.send_noti_content').val('');
                    $('#send_noti_account').val(null).trigger('change');
                    $('#send_noti_thread').val(null).trigger('change');
                    $(bodyIframe).empty();
                    $.notify(res.message, "success");
                    $('.btn-send-noti-wrapper #loader-btn-send-noti').hide();
                    $('.btn-send-noti-wrapper #ti_modal_users_search_submit').show();
                    setTimeout(()=>{
                        window.location.reload();
                    }, 1000);
                }
            },
            error: (xhr, status, err) => {
                $('.btn-send-noti-wrapper #loader-btn-send-noti').hide();
                $('.btn-send-noti-wrapper #ti_modal_users_search_submit').show();
                console.error(err);
            }
        })
    })
    handleRemoveError('.send_noti_account_wrapper', '.select2-selection');
    // $('.send_noti_account_wrapper').on('click', function() {
    //     $(this).find('.error-input').removeClass('show-error').html('');
    //     $(this).find('.select2-selection').removeClass('border-error');
    // });
    handleRemoveError('.send_noti_title_wrapper', '#send_noti_title');
    handleRemoveError('.send_noti_content_wrapper', '.send_noti_content');

    // handle error when submit form \\
    function handleError(field, wrapper, errors) {
        if (errors != null) {
            $(field).addClass('border-error');
            $(wrapper + ' .error-input').html(errors.join(', '));
            $(wrapper + ' .error-input').addClass('show-error');
        }
    }

    // handle remove error effect when click input \\
    function handleRemoveError(wrapper, id_input){
        $(wrapper).on('click', function() {
            $(this).find('.error-input').removeClass('show-error').html('');
            $(this).find(id_input).removeClass('border-error');
        });
    }
})
