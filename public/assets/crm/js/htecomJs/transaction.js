import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createTransactionApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    const today = new Date().toISOString().split('T')[0];
    $('#transaction_date').attr('max', today);

    $('#transaction-price').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(value);
        if(value==0){
            $(this).val('');
        }
    });


    $(document).on('submit', '#transaction-form', (e) => {
        e.preventDefault();
        $('#transaction-btn-save').html('Đang lưu...');
        const token  = localStorage.getItem('jwt_token');
        const api = baseUrl+createTransactionApi;

        let idLead              = $('#transaction-name').val();
        let status              = $('#transaction-status').val();
        let nameTran            = $('#semesterSelect option:selected').attr('data-name') + ' - ' + $('#academic_terms option:selected').attr('data-name') ;
        let priceDefault        = $('#transaction-price').val();
        let price               = priceDefault.split('.').join('');
        let type                = $('#transaction-type').val();
        let date                = formatDate($('#transaction_date').val());
        let time                = $('#transaction_time').val();
        let priceId             = $('#transaction-priceList').val();
        let note                = $('#transaction-note').val();
        let academic_terms_id   = $('#academic_terms').val();
        let semesters_id        = $('#semesterSelect').val();
        let mailTemp            = $('#transaction-tempMail-lead').val();
        let auto_send_mail = null;
        if ($('#auto_send_mail').is(":checked")) {
            auto_send_mail = 0;            
        } else {            
            auto_send_mail = 1;
        }        
        
        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"           : nameTran,
                "leads_id"       : idLead,
                "tran_status_id" : status,
                "tran_types_id"  : type,
                "price_lists_id" : priceId,
                "price"          : price,
                "tran_date"      : date,
                "tran_time"      : time,
                "note"           : note,
                "status"         : status,
                "file_name"      : mailTemp,
                "auto_send_mail" : auto_send_mail
       },
            success: (res) => {        
                if(res.code == 422){
                    if (res.data) {
                        handleError('#transaction-nameTran', '.transaction-nameTran-wrapper', res.data.name);
                        handleError('#transaction-priceList', '.transaction-priceList-wrapper', res.data.price_lists_id);

                    }
                    if(res.message){
                        $.notify(res.message, "error");
                        // $('#transaction-price').addClass('border-error');
                        // $('.transaction-price-wrapper .error-input').html(res.message);
                        // $('.transaction-price-wrapper .error-input').addClass('show-error');
                    }
                    $('#transaction-btn-save').html('Lưu giao dịch');
                } else {
                    $('#transaction-btn-save').html('Lưu giao dịch');
                    $('#transaction-nameTran').val('');
                    $('#transaction-price').val('');
                    $('#transaction_date').val('');
                    $('#transaction_time').val('');
                    $('#transaction-note').val('');
                    $.notify(res.message, "success");
                    if(res.student != null){
                        setTimeout(()=>{
                            window.location.href = baseUrl + '/crm/students/detail_student/'+ res.student.id;
                        }, 1500);
                    } 
                    else {
                        setTimeout(()=>{
                            window.location.href = baseUrl + '/crm/leads/detail_lead/' + idLead;
                        }, 1500);
                    }
                }
            },
            error: (xhr, status, err) => {
                console.log(err);
            }
        })
    })
    handleRemoveError('.transaction-nameTran-wrapper', '#transaction-nameTran');
    handleRemoveError('.transaction-price-wrapper', '#transaction-price');
    $('.transaction-price-wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#transaction-price').removeClass('border-error');
    });
})
