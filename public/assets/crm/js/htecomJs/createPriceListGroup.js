import { baseUrl }           from '/assets/crm/js/htecomJs/variableApi.js';
import { createPriceApi }    from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate }        from '/assets/crm/js/htecomJs/lead.js';
import { handleError }       from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $('#noti_price_tuition').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(value);
    });

    $(document).on('submit', '#noti_price_list', (e) => {        
        e.preventDefault();
        $('#create_noti_btn_submit').html('Đang tạo...');
        const token     = localStorage.getItem('jwt_token');
        const api       = baseUrl+createPriceApi;
        let ojb_type    = $('input[name="list_people"]:checked').val();
        let idLead      = [];
        let groupLead   = "";
        let title       = $('#semesterSelect option:selected').attr('data-name');
        let price       = $('#noti_price_tuition').val();
        let tuition     = price.split('.').join('');
        let fromDate    = formatDate($('.noti_price_date_wrapper #noti_price_date_start').val());
        let toDate      = formatDate($('.noti_price_date_wrapper #noti_price_date_end').val());
        let note        = $('#noti_price_note').val();
        let file        = $('#noti_price_file')[0].files[0];
        let tempMail    = $('#select_tempMail_price').val();
        let semesters_id = $('#semesterSelect').val();
        let auto_send_mail = null;
        if ($('#modal_auto_send_mail').is(":checked")) {                   
            auto_send_mail = 0;            
        } else {                        
            auto_send_mail = 1;
        }        
        const formData  = new FormData();

        if(ojb_type == 0){
            idLead = $('#select_leads_price_list option:selected').map(function() {
                return $(this).data('id');
            }).get();
            formData.append("leads_id", idLead);
        }

        if(ojb_type == 1){
            groupLead = $('#select_leads_price_list_group option:selected').data('groupid');
            formData.append("groups_id", groupLead);
        }

        formData.append("title", title);
        formData.append("price", tuition);
        formData.append("from_date", fromDate);
        formData.append("to_date", toDate);
        formData.append("note", note);
        formData.append("File", file);
        formData.append("file_name", tempMail);
        formData.append("semesters_id", semesters_id);
        formData.append("auto_send_mail", auto_send_mail);
        
        
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

                    handleError('#noti_price_title', '.noti_price_title_wrapper', res.data.title);

                    if(res.data.from_date != null){
                        $('#noti_price_date_start').addClass('border-error');
                        $('.noti_price_date_wrapper .error_from_date').html(res.data.from_date);
                        $('.noti_price_date_wrapper .error_from_date').addClass('show-error');
                    }

                    if(res.data.to_date != null){
                        $('#noti_price_date_end').addClass('border-error');
                        $('.noti_price_date_wrapper .error_to_date').html(res.data.to_date);
                        $('.noti_price_date_wrapper .error_to_date').addClass('show-error');
                    }

                    $('#create_noti_btn_submit').html('Gửi');
                } else {
                    $('#noti_price_title').val('');
                    $('#noti_price_tuition').val('');
                    $('.noti_price_date_wrapper #noti_price_date_start').val('');
                    $('.noti_price_date_wrapper #noti_price_date_end').val('');
                    $('#noti_price_note').val('');
                    $('#noti_price_file').val('');                    
                    $.notify(res.message, "success");     
                    $('#create_noti_btn_submit').html('Gửi');
                    setTimeout(function() {
                        document.location.reload();
                    }, 1000);
                }
            },
            error: (error) => {
                console.error('Create price list error:', error);
            }
        })
    })
    handleRemoveError('.noti_price_title_wrapper', '#noti_price_title');
    $('.noti_price_date_wrapper').on('click', function() {
        $(this).find('.error_to_date').removeClass('show-error').html('');
        $(this).find('#noti_price_date_end').removeClass('border-error');
    });
    $('.noti_price_date_wrapper').on('click', function() {
        $(this).find('.error_from_date').removeClass('show-error').html('');
        $(this).find('#noti_price_date_start').removeClass('border-error');
    });
})