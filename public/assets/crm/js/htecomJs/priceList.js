import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createPriceApi, getSemestersApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    //Xử lý select Niên khoá - Học kì
    $(document).on('change', '#academic_terms', function () {
        $('#semesterSelect').html('<option value="">Đang tải...</option>');
        let selectedValue = $(this).val();
        const api = baseUrl+getSemestersApi;
        const token                     = localStorage.getItem('jwt_token');
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
                $('#semesterSelect').empty();
                if(res.code == 200){
                    var data = res.data;                    
                    data.forEach(function(item) {
                        var option = $('<option></option>')
                        .val(item.id)
                        .text(item.name + " (" + item.from_date + " - " + item.to_date + ")")
                        .attr('data-name', item.name);
                        $('#semesterSelect').append(option);
                        $('#semesterSelect').prop('disabled', false);
                    });
                } else{
                    $('#semesterSelect').prop('disabled', true);
                    $('#semesterSelect').html('<option value=""> Vui lòng chọn Niên khoá </option>');
                    $.notify("Không lấy được danh sách Học kỳ", "error");
                }
            },
            error: (err)=>{
                $('#semesterSelect').html('<option value=""> Vui lòng chọn Niên khoá </option>');             
            }
        })

    });
    // Ngăn cách hằng nghìn trong input text
    $('#price-tuition-lead').on('input', function () {
        let value = $(this).val();
        value     = value.replace(/\D/g, '');
        value     = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $(this).val(value);
    });

    
    $(document).on('submit', '#form-price-list', (e) => {
        e.preventDefault();
        const $btnSend = $('#price-btn-send');
        if ($btnSend.prop('disabled')) {
            return;
        }
        $btnSend.prop('disabled', true);
        $btnSend.html('Đang tạo...');
    
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl + createPriceApi;
        const formData = new FormData();
        let auto_send_mail = null;
        if ($('#auto_send_mail').is(":checked")) {
            auto_send_mail = 0;
        } else {
            auto_send_mail = 1;
        }
            
        let idLead = $('#price-name-lead').val();
        let title = $('#semesterSelect option:selected').attr('data-name');
        let price = $('#price-tuition-lead').val();
        let tuition = price.split('.').join('');
        let fromDate = formatDate($('.price-date-lead-wrapper #modal_date_start').val());
        let toDate = formatDate($('.price-date-lead-wrapper #modal_date_end').val());
        let note = $('#price-note-lead').val();
        let file = $('#price-file-lead')[0].files[0];
        let fileName = $('#price-tempMail-lead').val();        
        
        // let academic_terms_id = $('#academic_terms').val();
        let semesters_id = $('#semesterSelect').val();
    
        // Nếu có file, kiểm tra MIME type
        if (file) {
            const allowedMimeTypes = [
                'application/pdf',                                    // .pdf
                'application/vnd.ms-excel',                          // .xls
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // .xlsx
            ];
            const mimeType = file.type;
    
            if (!allowedMimeTypes.includes(mimeType)) {
                $.notify("Chỉ chấp nhận file .pdf, .xls hoặc .xlsx", "error");
                $btnSend.html('Gửi');
                $btnSend.prop('disabled', false);
                return;
            }
        }
    
        // Thêm dữ liệu vào FormData
        formData.append("leads_id", idLead);
        formData.append("title", title);
        // formData.append("academic_terms_id", academic_terms_id);
        formData.append("semesters_id", semesters_id);
        formData.append("price", tuition);
        formData.append("from_date", fromDate);
        formData.append("to_date", toDate);
        formData.append("note", note);
        formData.append("File", file);
        formData.append('auto_send_mail', auto_send_mail);
        if(fileName !== null) formData.append("file_name", fileName);
    
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
                if (res.code == 422) {
                    handleError('#price-title-lead', '.price-title-lead-wrapper', res.data.title);
    
                    if (res.data.from_date != null) {
                        $('#modal_date_start').addClass('border-error');
                        $('.price-date-lead-wrapper .error_from_date').html(res.data.from_date);
                        $('.price-date-lead-wrapper .error_from_date').addClass('show-error');
                    }
    
                    if (res.data.to_date != null) {
                        $('#modal_date_end').addClass('border-error');
                        $('.price-date-lead-wrapper .error_to_date').html(res.data.to_date);
                        $('.price-date-lead-wrapper .error_to_date').addClass('show-error');
                    }
                } else {
                    $('#price-title-lead').val('');
                    $('#price-tuition-lead').val('');
                    $('.price-date-lead-wrapper #modal_date_start').val('');
                    $('.price-date-lead-wrapper #modal_date_end').val('');
                    $('#price-note-lead').val('');
                    $('#price-file-lead').val('');
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1200);
                }
                setTimeout(function() {
                    $btnSend.html('Gửi');
                    $btnSend.prop('disabled', false);
                }, 1500);
            },
            error: (error) => {
                console.error('Create price list error:', error);
                $btnSend.html('Gửi');
                $btnSend.prop('disabled', false);
            }
        });
    });
    handleRemoveError('.price-title-lead-wrapper', '#price-title-lead');
    handleRemoveError('.price-date-lead-wrapper', '.price-date-start');
    $('.price-date-lead-wrapper').on('click', function() {
        $(this).find('.error_to_date').removeClass('show-error').html('');
        $(this).find('#modal_date_end').removeClass('border-error');
    });
    $('.price-date-lead-wrapper').on('click', function() {
        $(this).find('.error_from_date').removeClass('show-error').html('');
        $(this).find('#modal_date_start').removeClass('border-error');
    });
})
