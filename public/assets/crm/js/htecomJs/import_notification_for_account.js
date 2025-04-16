import { baseUrl, importNotificationsImportsApis } from '/assets/crm/js/htecomJs/variableApi.js';
$(document).ready(()=>{

    $('#file_import_leads').change(function() {
        $('.error_log_leads').empty();
        $('.error_log_leads').hide();
    });
    // $('#import_btn_leads_now').click(()=>{       
        
    //     const button = $('#import_btn_leads_now');
    //     button.addClass('disable');
    //     button.html('Đang tải...');
    //     const api       = baseUrl+importNotificationsImportsApis;
    //     const token     = localStorage.getItem('jwt_token');
    //     const formData  = new FormData();
    //     let file        = $('#file_import_leads')[0].files[0];
    //     if (!file) {
    //         $.notify("Vui lòng chọn file cần import", "error");
    //         button.html('Tải lên');
    //         button.removeClass('disable');
    //         return;
    //     }
    //     formData.append('file', file);

    //     $.ajax({
    //         url: api,
    //         type: 'POST',
    //         headers: {
    //             'Authorization': `Bearer ${token}`
    //         },
    //         data:formData,
    //         processData: false,
    //         contentType: false,
    //         success: (res) => {
    //             if(res.code == 422){
    //                 $.each(res.message, function(index, item) {
    //                     const errors = item.errors.join(', ');
    //                     const errorHTML = `
    //                         <div class="error-list">
    //                             <strong style='color:red'>Dòng: ${item.row}</strong>
    //                             <div class="error-item">Lỗi: ${errors}</div>
    //                         </div>
    //                     `;
    //                     $('.error_log_leads').append(errorHTML);
    //                 });
    //                 $('.error_log_leads').show();
    //                 $('#file_import_leads').val('');
    //             } else{
    //                 $('#file_import_leads').val('');
    //                 $('.error_log_leads').empty().hide();
    //                 $.notify(res.message, "success");
    //                 document.location.reload();
    //             }
    //         },
    //         error: (error) => {
    //             console.log(error);
    //         }
    //     }).always(function() {
    //         button.removeClass('disable');
    //         button.html('Tải lên');
    //     });
    // })

    $('#import_btn_leads_now').click(() => {       
        const button = $('#import_btn_leads_now');
        button.addClass('disable');
        button.html('Đang tải...');
        const api = baseUrl + importNotificationsImportsApis;
        const token = localStorage.getItem('jwt_token');
        const formData = new FormData();
        let file = $('#file_import_leads')[0].files[0];
    
        // Kiểm tra xem có file hay không
        if (!file) {
            $.notify("Vui lòng chọn file cần import", "error");
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Danh sách MIME type hợp lệ
        const allowedMimeTypes = [
            // 'application/x-msdownload',                         // .exe
            // 'application/octet-stream',                         // .exe (có thể)
            'application/vnd.ms-excel',                         // .xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // .xlsx
        ];
    
        // Lấy MIME type của file
        const mimeType = file.type;
    
        // Kiểm tra MIME type
        if (!allowedMimeTypes.includes(mimeType)) {
            $.notify("Chỉ chấp nhận file .xls hoặc .xlsx", "error");
            $('#file_import_leads').val(''); // Xóa file không hợp lệ
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Nếu file hợp lệ, thêm vào FormData và gửi Ajax
        formData.append('file', file);
    
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
                    $('#file_import_leads').val('');
                } else {
                    $('#file_import_leads').val('');
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
