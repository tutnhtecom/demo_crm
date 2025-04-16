import { baseUrl, editCustomFieldApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_edit_custom_field', (e)=>{
        const idField  = $(e.currentTarget).attr('data-id');
        const api      = baseUrl+editCustomFieldApi+idField;
        const token    = localStorage.getItem('jwt_token');
        let nameField  = $('#input_field_name_'+idField).val();
        $(e.currentTarget).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"  : nameField,
                "types"  : 0
            },
            success: (res)=>{
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.data.name, "error");
                }
                $(e.currentTarget).html('Lưu');
            },
            error: (error)=>{
                console.log(error);
                alert('Đã xảy ra l��i');
            }
        })
    })
});
