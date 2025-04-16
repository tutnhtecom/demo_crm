import { baseUrl }            from '/assets/crm/js/htecomJs/variableApi.js';
import { createGroupApi }     from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError }        from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError }  from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    //arr_group_ids được lấy từ lead.js
    $(document).on('click','#btn_group_leads_submit', function(){
        const btn     = $('#btn_group_leads_submit');
        const api     = baseUrl+createGroupApi;
        const token   = localStorage.getItem('jwt_token');
        let nameGroup = $('#name_group_input').val();
        btn.html('Đang tạo...');
        let group_ids = $(this).attr('data-ids');
        let group_type = $(this).attr('data-types') ? $(this).attr('data-types') : 0;

        let arr_group_ids = group_ids.split(",");
        if(!arr_group_ids.length){
            $.notify("Không thể tạo nhóm do không lấy được ID", "error");
        }

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"    : nameGroup,
                "types"   : group_type,
                "list_id" : arr_group_ids
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#name_group_input', '.group_input_wrapper', res.data.name);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Tạo nhóm');
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
    handleRemoveError('.group_input_wrapper', '#name_group_input');

});
