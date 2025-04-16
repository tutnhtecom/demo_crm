import { baseUrl, editSourceRateApi, getSemestersApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('change', '#academic_terms_id_edit', function () {
        $('#semesterSelectEdit').html('<option value="">Đang tải...</option>');
        let selectedValue = $(this).val();
        const api = baseUrl+getSemestersApi;
        const token = localStorage.getItem('jwt_token');
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "academic_terms_id": selectedValue
            },
            success: (res)=>{
                $('#semesterSelectEdit').empty();
                if(res.code == 200){
                    var data = res.data;                    
                    data.forEach(function(item) {
                        var option = $('<option></option>')
                        .val(item.id)
                        .text(item.name + " (" + item.from_date + " - " + item.to_date + ")")
                        .attr('data-name', item.name);
                        $('#semesterSelectEdit').append(option);
                        $('#semesterSelectEdit').prop('disabled', false);
                    });
                } else{
                    $('#semesterSelectEdit').prop('disabled', true);
                    $('#semesterSelectEdit').html('<option value=""> Vui lòng chọn Niên khoá </option>');
                    $.notify("Không lấy được danh sách Học kỳ", "error");
                   
                }
            },
            error: (err)=>{
                $('#semesterSelectEdit').html('<option value=""> Vui lòng chọn Niên khoá </option>');             
            }
        })
    
    });

   
})

$(document).on('click', '.icon_edit_sources_rate', function(){    
    // Lấy giá trị từ data-signed-document
    //--------------------------------------------------------------------------------------------
    const data_id                       = $(this).attr('data-id');
    const data_expense_name             = $(this).attr('data-expense-name');
    const data_payment_condition        = $(this).attr('data-payment-condition');
    const data_math_sign                = $(this).attr('data-math-sign');
    const data_payment_rate             = $(this).attr('data-payment-rate');    
    const data_payment_note             = $(this).attr('data-payment-note');    
    const data_payment_terms_note       = $(this).attr('data-payment-terms-note');    
    const data_payment_manager_rate     = $(this).attr('data-payment-manager-rate');
    const data_payment_manager_price    = $(this).attr('data-payment-manager-price');
    const data_sources_id               = $(this).attr('data-sources-id');
    const data_sources_documents_id     = $(this).attr('data-sources-documents-id');
    const data_academic_terms_id        = $(this).attr('data-academic-terms-id');
    const data_semesters_id             = $(this).attr('data-semesters-id');    
    
    // $('#form_edit_sources_rate input[name="expense_name"]').val(data_expense_name);
    $('#expense_edit_name').val(data_expense_name);    
    if(data_math_sign == ">=")  document.getElementById('>=').checked = true;
    if(data_math_sign == "<")  document.getElementById('<').checked = true;
    $('#form_edit_sources_rate input[name="payment_condition"]').val(data_payment_condition);
    $('#form_edit_sources_rate input[name="payment_rate"]').val(data_payment_rate);
    let formattedPrice = Number(data_payment_manager_price).toLocaleString('vi-VN');
    $('#form_edit_sources_rate input[name="payment_manager_price"]').val(formattedPrice);
    // $('#form_edit_sources_rate input[name="payment_manager_price"]').val(data_payment_manager_price);
    $('#form_edit_sources_rate input[name="payment_manager_rate"]').val(data_payment_manager_rate);
    // $('#form_edit_sources_rate input[name="payment_note"]').val(data_payment_note);
    $('#form_edit_sources_rate #payment_note').val(data_payment_note);
    $('#form_edit_sources_rate #payment_terms_note').val(data_payment_terms_note);
    
    //--------------------------------------------------------------------------------------------
    // let active = 1;
    // $('[name=enable_dktt]').click(function(e){
    //     active = $(this).val();
    // });

    $('#academic_terms_id_edit option').each(function() {
        if ($(this).val() == data_academic_terms_id) {
            $(this).prop('selected', true);
        }
    });
    $('#academic_terms_id_edit').trigger('change');

    setTimeout(function(){
        $('#semesterSelectEdit option').each(function() {
            if ($(this).val() == data_semesters_id) {
                $(this).prop('selected', true);
            }
        });
    }, 1000)

    $('#btn_edit_sources_rate').attr('data-id', data_id);
    $('#btn_edit_sources_rate').attr('data-sources-id', data_sources_id);
    $('#btn_edit_sources_rate').attr('data-sources-documents-id', data_sources_documents_id);
    $('#btn_edit_sources_rate').attr('data-payment-note', data_payment_note);
    $('#btn_edit_sources_rate').attr('data-academic-terms-id', data_academic_terms_id);
    $('#btn_edit_sources_rate').attr('data-semesters-id', data_semesters_id);
    $('#btn_edit_sources_rate').attr('data-payment-condition', data_payment_condition);
    $('#btn_edit_sources_rate').attr('data-math-sign', data_math_sign);
    $('#btn_edit_sources_rate').attr('data-payment-rate', data_payment_rate);
    $('#btn_edit_sources_rate').attr('data-payment-manager-rate', data_payment_manager_rate);
    $('#btn_edit_sources_rate').attr('data-payment-manager-price', data_payment_manager_price);
});
$(document).on('change', '#payment_note', function(e){
    $('#btn_edit_sources_rate').attr('data-payment-note', e.target.value);
})
$(document).on('click', '#btn_edit_sources_rate1', function(e){    
    e.preventDefault();
    const data_id                   = $(this).attr('data-id');
    const data_sources_id           = $(this).attr('data-sources-id');
    const data_sources_documents_id = $(this).attr('data-sources-documents-id');    
    const data_payment_note         = $(this).attr('data-payment-note');    
    const data_academic_terms_id    = $('#academic_terms_id_edit').val();    
    const data_semesters_id         = $('#semesterSelectEdit').val();
    const payment_terms_note        = $('#payment_terms_note').val();
    const data_payment_condition    = $('.payment_condition').val();
    const data_math_sign            = $('input[name="math_sign"]').val();
    const data_payment_rate         = $('.payment_rate').val();
    const data_payment_manager_price= $('.payment_manager_price').val();
    const data_payment_manager_rate = $('.payment_manager_rate').val();
    const data_dktt                 = $('input[name="enable_dktt"]').val();
    const api                       = baseUrl+editSourceRateApi+data_id;
    const token                     = localStorage.getItem('jwt_token');
    
    $(e.currentTarget).html('Đang chạy...');
    const formData = $('form[id="form_edit_sources_rate"]').serializeArray();
    const data_update = {};
    formData.forEach(field => {
        if (data_update[field.name]) {
            if (!Array.isArray(data_update[field.name])) {
                data_update[field.name] = [data_update[field.name]];
            }
            data_update[field.name].push(field.value);
        } else {
            data_update[field.name] = field.value;
        }
    });
    data_update.sources_id = data_sources_id;    
    let data;
    if(data_dktt == 1){
        data = {
            "expense_name"          : $('#expense_edit_name').val(),            
            "payment_note"          : data_payment_note,
            "sources_id"            : data_sources_id,
            "sources_documents_id"  : data_sources_documents_id,
            "academic_terms_id"     : data_academic_terms_id,
            "semesters_id"          : data_semesters_id,
            "payment_condition"     : data_payment_condition,
            "math_sign"             : data_math_sign,
            "payment_rate"          : data_payment_rate,
            "payment_manager_rate"  : data_payment_manager_rate,
            "payment_manager_price" : data_payment_manager_price,
            "payment_terms_note"    : payment_terms_note  
        }
    } else {
        data = {
            "expense_name" : $('#expense_edit_name').val(),            
            "payment_note":data_payment_note,
        } 
    }            
    $.ajax({
        url: api,
        method: 'POST',
        data: data,
        headers: {
            'Authorization': `Bearer ${token}`
        },
        success: (res)=>{            
            if(res.code == 422){
                $.notify(res.message, "error");
            } else{
                $.notify(res.message, "success");
                setTimeout(function() {
                    window.location.reload();
                    // document.location.reload();
                }, 1200);
            }
            $(e.currentTarget).html('Xác nhận');
        },
        error: (err)=>{
            console.log(err);
        }
    })
})

$('.payment_manager_price').on('input', function () {
    let value = $(this).val().replace(/\D/g, ""); // Xóa tất cả ký tự không phải số
    value = Number(value).toLocaleString('vi-VN'); // Định dạng số theo kiểu Việt Nam
    $(this).val(value);
});

$(document).ready(()=>{
    $(document).on('click', '#btn_edit_sources_rate', function(e){    
        e.preventDefault();    
        const data_id                   = $(this).attr('data-id');    
        const data_dktt                 = $('input[name="enable_dktt"]').val();
        const api                       = baseUrl+editSourceRateApi+data_id;
        const token                     = localStorage.getItem('jwt_token');    
        $(this).html('Đang chạy...');
        // const formData = $('#form_edit_sources_rate').serializeArray(); 
        const formData = $('#form_edit_sources_rate').serializeArray()
                        .map(field => {
                            if (field.name === 'payment_manager_price') {
                                return { name: field.name, value: field.value.replace(/\./g, '') }; // Xóa dấu `.`
                            }
                            return field;
                        });   
        const data_update = {};
        formData.forEach(field => {
            if (data_update[field.name]) {
                if (!Array.isArray(data_update[field.name])) {
                    data_update[field.name] = [data_update[field.name]];
                }
                data_update[field.name].push(field.value);
            } else {
                data_update[field.name] = field.value;
            }
        });
        data_update.sources_id             = $(this).attr('data-sources-id');
        data_update.sources_documents_id   = $(this).attr('data-sources-documents-id');   
          
        let data;
        if(data_dktt !== 1){    
            data = data_update;
        } else {
            data = {
                "expense_name" : $('#expense_edit_name').val(),            
                "payment_note":data_payment_note,
            } 
        }    
          
        $.ajax({
            url: api,
            method: 'POST',
            data: data,
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res)=>{                 
                if(res.code == 422){
                    // $.notify(res.message, "error");
                    handleError('#expense_edit_name', '.expense_edit_name_wrapper', res.data.expense_name);
                    handleError('#payment_rate', '.payment_rate_wrapper', res.data.payment_rate);
                    handleError('#payment_manager_rate', '.payment_manager_rate_wrapper', res.data.payment_manager_rate);
                } else{
                    $.notify(res.message, "success");
                    setTimeout(function() {                    
                        document.location.reload();
                    }, 1200);
                }
                $(this).html('Xác nhận');
            },
            error: (err)=>{
                console.log(err);
            }
        })
    })
    handleRemoveError('.expense_edit_name_wrapper', '#expense_edit_name');
    handleRemoveError('.payment_rate_wrapper', '#payment_rate');
    handleRemoveError('.payment_manager_rate_wrapper', '#payment_manager_rate');
})