import { baseUrl, deleteCustomFieldApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_delete_custom_field', (e)=>{
        const idField  = $(e.currentTarget).attr('data-id');
        const api      = baseUrl+deleteCustomFieldApi+idField;
        const token    = localStorage.getItem('jwt_token');
        $(e.currentTarget).html('Đang xóa...');

        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res)=>{
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.message, "error");
                }
                $(e.currentTarget).html('Xóa');
            },
            error: (xhr, status, error)=>{
                console.error(error);
            }
        })
    })
})
