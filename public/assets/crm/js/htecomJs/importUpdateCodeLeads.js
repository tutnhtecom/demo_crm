import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { importUpdateCodeLeadssApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $('#import_code_leads_file').change(function() {
        $('.error_log_leads').empty();
        $('.error_log_leads').hide();
    });
    $('#btn_import_code_for_leads').click(()=>{
        const button = $('#btn_import_code_for_leads');
        button.addClass('disable');
        button.html('Đang tải...');
        const api       = baseUrl+importUpdateCodeLeadssApi;
        const token     = localStorage.getItem('jwt_token');
        const formData  = new FormData();
        let file        = $('#import_code_leads_file')[0].files[0];        
        if (!file) {
            $.notify("Vui lòng chọn file cần import", "error");
            button.html('Tải lên');
            button.removeClass('disable');
            return;
        }
        formData.append('file', file);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data:formData,
            processData: false,
            contentType: false,
            success: (res) => {
                if(res.code == 422){
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
                    $('#import_code_leads_file').val('');
                } else{
                    $('#import_code_leads_file').val('');
                    $('.error_log_leads').empty().hide();
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
        });;
    })
})
