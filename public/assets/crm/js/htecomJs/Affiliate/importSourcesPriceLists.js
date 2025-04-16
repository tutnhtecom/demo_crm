import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { importSourcePriceListsApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $('#import_sources_price_list_file').change(function() {
        $('.error_log_leads').empty();
        $('.error_log_leads').hide();
    });
    
    $('#import_btn_sources_price_lists').click(() => {        
        const button = $('#import_btn_sources_price_lists');
        button.addClass('disable');
        button.html('Đang tải...');
        const api = baseUrl + importSourcePriceListsApi;
        const token = localStorage.getItem('jwt_token');
        const formData = new FormData();
        let file = $('#import_sources_price_list_file')[0].files[0];        
    
        // Kiểm tra xem có file hay không
        if (!file) {
            $.notify("Vui lòng chọn file cần import", "error");
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Danh sách MIME type hợp lệ (chỉ .xls và .xlsx)
        const allowedMimeTypes = [
            'application/vnd.ms-excel',                         // .xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // .xlsx
        ];
    
        // Lấy MIME type của file
        const mimeType = file.type;
    
        // Kiểm tra MIME type
        if (!allowedMimeTypes.includes(mimeType)) {
            $.notify("Chỉ chấp nhận file .xls hoặc .xlsx", "error");
            $('#import_sources_price_list_file').val(''); // Xóa file không hợp lệ
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Nếu file hợp lệ, thêm vào FormData và gửi Ajax
        formData.append('file', file);
        formData.append('semesters_id', $('#semesterSelect').val());        
    
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
                    $.each(res.message, function(index, item) {
                        const errors = item.errors.join(', ');
                        const errorHTML = `
                            <div class="error-list">
                                <strong style='color:red'>Dòng: ${item.row}</strong>
                                <div class="error-item">Lỗi: ${errors}</div>
                            </div>
                        `;
                        $('.error_log_leads').append(errorHTML);
                    });
                    $('.error_log_leads').show();
                    $('#import_sources_price_list_file').val('');
                } else {
                    $('#import_sources_price_list_file').val('');
                    $('.error_log_leads').empty().hide();
                    $.notify(res.message, "success");
                    document.location.reload();
                }
            },
            error: (error) => {
                console.log(error);
                $.notify("Có lỗi xảy ra khi tải file", "error");
            }
        }).always(function() {
            button.removeClass('disable');
            button.html('Tải lên');
        });
    });
})
