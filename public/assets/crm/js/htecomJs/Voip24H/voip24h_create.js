import { baseUrl, voip24hCreateApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_create_voip24h', (e)=>{
        let btn         = $(e.currentTarget);
        let api         = baseUrl+voip24hCreateApi;
        let line_id     = $('#create_voip24h_line_id').val();
        let password    = $('#create_voip24h_line_password').val();
        let token       = localStorage.getItem('jwt_token');
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                'line_id'       : line_id,
                'line_password' : password
            },
            success: (response)=>{
                if(response.code == 422){
                    handleError('#create_voip24h_line_id', '.create_voip24h_line_id_wrapper', response.data.line_id);
                    handleError('#create_voip24h_line_password', '.create_voip24h_line_password_wrapper', response.data.line_password);
                } else {
                    $.notify(response.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: (xhr, status, error) => {
                console.error(xhr);
                console.error(status);
                console.error(error);
                alert('Có l��i xảy ra!');
            }
        })
    });

    handleRemoveError('.create_voip24h_line_id_wrapper', '#create_voip24h_line_id');
    handleRemoveError('.create_voip24h_line_password_wrapper', '#create_voip24h_line_password');

    $(document).on('input', '#create_voip24h_line_id', function () {
        $(this).val($(this).val().replace(/\D/g, '')); // Loại bỏ ký tự không phải số
    });
});
