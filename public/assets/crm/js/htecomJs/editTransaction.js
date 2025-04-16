import { baseUrl }         from '/assets/crm/js/htecomJs/variableApi.js';
import { editTransactionApi }   from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    const today = new Date().toISOString().split('T')[0];
    $('#transaction_date').attr('max', today);

    $('#tran_detail_price').on('input', function () {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(value);
        if(value==0){
            $(this).val('');
        }
    });


    $(document).on('submit', '#transaction_form_detail', (e) => {
        e.preventDefault();
        const idTran = $('#btn_tran_edit_save').data('id');
        const token  = localStorage.getItem('jwt_token');
        const api = baseUrl+editTransactionApi+idTran;
        $('#btn_tran_edit_save').html('Đang lưu...');

        let idLead       = $('#tran_detail_name').val();
        let status       = $('#tran_detail_status').val();
        let nameTran     = $('#tran_detail_nameTran').val();
        let priceDefault = $('#tran_detail_price').val();
        let price        = priceDefault.split('.').join('');
        let type         = $('#tran_detail_type').val();
        let date         = formatDate($('#tran_detail_date').val());
        let time         = $('#tran_detail_time').val();
        let priceId      = $('#tran_detail_priceList').val();
        let note         = $('#tran_detail_note').val();

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
                "note"           : note
            },
            success: (res) => {
                console.log(res);
                
                if(res.code == 422){
                    if (res.data) {
                        handleError('#tran_detail_nameTran', '.tran_detail_nameTran_wrapper', res.data.name);
                    }
                    if(res.message){
                        $('#tran_detail_price').addClass('border-error');
                        $('.tran_detail_price_wrapper .error-input').html(res.message);
                        $('.tran_detail_price_wrapper .error-input').addClass('show-error');
                    }
                } else {
                    $('#tran_detail_nameTran').val('');
                    $('#tran_detail_price').val('');
                    $('#tran_detail_date').val('');
                    $('#tran_detail_time').val('');
                    $('#tran_detail_note').val('');
                    $.notify(res.message, "success");
                    if(res.id_student != null){
                        window.location.href = baseUrl + '/crm/students/detail_student/'+ res.id_student;
                    } else {
                        window.location.href = baseUrl + '/crm/leads/detail_lead/' + idLead;
                    }
                }
                $('#btn_tran_edit_save').html('Lưu giao dịch')
            },
            error: (xhr, status, err) => {
                console.log(err);
            }
        })
    })
    handleRemoveError('.tran_detail_nameTran_wrapper', '#tran_detail_nameTran');
    handleRemoveError('.tran_detail_price_wrapper', '#tran_detail_price');
    $('.tran_detail_price_wrapper').on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find('#tran_detail_price').removeClass('border-error');
    });
})
