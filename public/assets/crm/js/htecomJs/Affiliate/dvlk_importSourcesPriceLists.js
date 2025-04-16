import { baseUrl, dvlkImportPriceListApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '#dvlk_import_price_list_btn', ()=>{
        const button = $('#dvlk_import_price_list_btn');
        const api = baseUrl+dvlkImportPriceListApi;
        const token = localStorage.getItem('jwt_token');
        const formData = new FormData();
        let semesters_id = $('#dvlk_semester').val();
        let file = $('#dvlk_import_price_list')[0].files[0];
        
        // Kiểm tra xem có file hay không
        if (!file) {
            $.notify("Vui lòng chọn file cần import", "error");
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Danh sách MIME type hợp lệ
        const allowedMimeTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
    
        // Lấy MIME type của file
        const mimeType = file.type;
    
        // Kiểm tra MIME type
        if (!allowedMimeTypes.includes(mimeType)) {
            $.notify("Chỉ chấp nhận file .xls hoặc .xlsx", "error");
            $('#import_price_lists_file').val(''); // Xóa file không hợp lệ
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
    
        // Nếu file hợp lệ, thêm vào FormData và gửi Ajax
        formData.append('file', file);
        formData.append('semesters_id', semesters_id);

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
                if(res.errors){
                    let messages = Array.isArray(res.errors) ? res.errors : [res.errors];
                    let errorMessages = messages.map(item => 
                        `<p>Dòng ${item.row}: ${item.errors.join(", ")}</p>`
                    ).join("");
                    
                    $(".show_err").html(errorMessages);
                } else if (res.code == 422) {                  
                    
                } else {
                    $.notify(res.message, "success");
                    document.location.reload();
                }
            },
            error: (error) => {
                console.log(error);
            }
        }).always(function() {
            button.removeClass('disable');
            button.html('Tải lên');
        });
    });

    $(document).on('click', '#dvlk_semester, #dvlk_import_price_list, #dvlk_close_modal', () => {
        $(".show_err").html('');
    });
});