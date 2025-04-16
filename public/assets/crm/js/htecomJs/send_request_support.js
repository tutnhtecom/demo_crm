import { baseUrl, createSupportRequestApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    TI_Util.onDOMContentLoaded(function () {
        // Init tinymce in modal
        tinymce.init({
            selector: 'textarea#content_have_contact',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
            setup: function (editor) {
                editor.on('input focus', function () {
                    const errorElement = document.querySelector('.content_have_contact_wrapper .error-input');
                    if (errorElement) {
                        errorElement.classList.remove('show-error');
                    }
                });
            }
        });
    });

    $(document).on('submit', '#ticket_have_contact_form', (e) => {
        e.preventDefault();
        const api          = baseUrl+createSupportRequestApi;
        const token        = localStorage.getItem('jwt_token');
        let btnHaveContact = $('#btn_submit_ticket_have_contact');
        let subject        = $('#subject_have_contact').val();
        let tag            = $('#tags_have_contact').val();
        let full_name      = $('#name_have_contact').val();
        let send_cc        = $('#send_cc_have_contact').attr('data-email');
        let phone          = $('#select_lead_have_contact').val();
        let send_to        = $('#send_to_have_contact').val();
        let description    = tinymce.get('content_have_contact').getContent({ format: 'text' });
        
        btnHaveContact.prop('disabled', true).html('Đang tạo...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "subject"      : subject,
                "tag_id"       : tag,
                "send_to"      : send_to,
                "send_cc"      : send_cc,
                "descriptions" : description,
                "email"        : send_to,
                "full_name"    : full_name,
                "phone"        : phone,
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#subject_have_contact', '.subject_have_contact_wrapper', res.data.subject);
                    handleError('#select_lead_have_contact', '.select_lead_have_contact_wrapper', res.data.email);
                    handleError('#content_have_contact', '.content_have_contact_wrapper', res.data.descriptions);
                }else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                // $('#btn_submit_ticket_have_contact').html('Tạo');
                btnHaveContact.prop('disabled', false).html('Tạo');
            },
            error: (err) => {
                $('#btn_submit_ticket_have_contact').html('Tạo yêu cầu hỗ trợ');
                console.error(err);
            }
        })
    })
    handleRemoveError('.subject_have_contact_wrapper', '#subject_have_contact');
    handleRemoveError('.select_lead_have_contact_wrapper', '#select_lead_have_contact');
});