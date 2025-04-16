import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { importEmployeesApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $('#file_import_employees').change(function() {
        $('.error_log_employees').empty(); 
        $('.error_log_employees').hide(); 
    });
    // $('#import_btn_employees_now').click(()=>{
    //     const button = $('#import_btn_employees_now');
    //     button.html('Đang tải...');
    //     const api       = baseUrl+importEmployeesApi;
    //     const token     = localStorage.getItem('jwt_token');
    //     const formData  = new FormData();
    //     let file        = $('#file_import_employees')[0].files[0];
    //     if (!file) {
    //         $.notify("Vui lòng chọn file cần import", "error");
    //         button.html('Tải lên');
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
    //                     $('.error_log_employees').append(errorHTML);
    //                 });
    //                 $('.error_log_employees').show();
    //                 $('#file_import_employees').val('');                     
    //             } else{
    //                 $('#file_import_employees').val(''); 
    //                 $('.error_log_employees').empty().hide();                     
    //                 $.notify(res.message, "success");
    //                 document.location.reload();
    //             }
    //             button.html('Tải lên');
    //         },
    //         error: (error) => {
    //             console.log(error);
    //         }
    //     });
    // })

    $('#import_btn_employees_now').click(() => {
        const button = $('#import_btn_employees_now');
        button.html('Đang tải...');
        const api = baseUrl + importEmployeesApi;
        const token = localStorage.getItem('jwt_token');
        const formData = new FormData();
        let file = $('#file_import_employees')[0].files[0];
    
        // Kiểm tra xem có file hay không
        if (!file) {
            $.notify("Vui lòng chọn file cần import", "error");
            button.html('Tải lên');
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
            $('#file_import_employees').val(''); // Xóa file không hợp lệ
            button.html('Tải lên');
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
                        $('.error_log_employees').append(errorHTML);
                    });
                    $('.error_log_employees').show();
                    $('#file_import_employees').val('');                     
                } else {
                    $('#file_import_employees').val(''); 
                    $('.error_log_employees').empty().hide();                     
                    $.notify(res.message, "success");
                    document.location.reload();
                }
                button.html('Tải lên');
            },
            error: (error) => {
                console.log(error);
                $.notify("Có lỗi xảy ra khi tải file", "error");
                button.html('Tải lên');
            }
        });
    });
})