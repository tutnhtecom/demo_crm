import { baseUrl, createCustomFieldApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    var tableCustomField;
    var dataCustomField = function() {
        tableCustomField = new DataTable('#table_custom_field', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            dom: "lrtip"
        });
    };
    dataCustomField();

    $(document).on('click', '#btn_submit_custom_field', (e)=>{
        const btn      = $(e.currentTarget);
        const api      = baseUrl+createCustomFieldApi;
        const token    = localStorage.getItem('jwt_token');
        let nameField  = $('#input_field_name').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"   : nameField,
                "types"  : 0
            },
            success: (res) => {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.data.name, "error");
                }
                btn.html('Lưu');
            },
            error: (error) => {
                console.error(error);
            }
        })
    })
})
