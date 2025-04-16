import { baseUrl, voip24hUpdateApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '.icon_update_voip24h', (e)=>{
        let id            = $(e.currentTarget).attr('data-id');
        let line_id       = $(e.currentTarget).attr('data-line-id');
        let line_password = $(e.currentTarget).attr('data-line-password');

        $('#update_voip24h_line_id').val(line_id);
        $('#update_voip24h_line_password').val(line_password);
        $('.btn_update_voip24h').attr('data-id', id);
    });

    $(document).on('click', '.btn_update_voip24h', (e)=>{
        let btn           = $(e.currentTarget);
        let id            = $(e.currentTarget).attr('data-id');
        let line_id       = $('#update_voip24h_line_id').val();
        let line_password = $('#update_voip24h_line_password').val();
        let api           = baseUrl+voip24hUpdateApi+id;
        let token         = localStorage.getItem('jwt_token');
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                'line_id'      : line_id,
                'line_password': line_password
            },
            success: (response) => {
                if(response.code === 422){
                    handleError('#update_voip24h_line_id', '.update_voip24h_line_id_wrapper', response.data.line_id);
                    handleError('#update_voip24h_line_password', '.update_voip24h_line_password_wrapper', response.data.line_password); 
                } else {
                    $.notify(response.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: (xhr, status, error) => {
                handleError(xhr, status, error);
            }
        })
    });

    handleRemoveError('.update_voip24h_line_id_wrapper', '#update_voip24h_line_id');
    handleRemoveError('.update_voip24h_line_password_wrapper', '#update_voip24h_line_password');

    $(document).on('input', '#update_voip24h_line_id', function () {
        $(this).val($(this).val().replace(/\D/g, '')); // Loại bỏ ký tự không phải số
    });
});