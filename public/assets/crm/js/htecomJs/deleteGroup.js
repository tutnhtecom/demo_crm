import { baseUrl, deleteGroupApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.btn_delete_group').on('click', (e)=>{
        const idGroup = $(e.currentTarget).data('id');
        const api = baseUrl+deleteGroupApi+idGroup;
        const token = localStorage.getItem('jwt_token');
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
                $(e.currentTarget).html('Xác nhận');
            },
            error: (xhr, status, error)=>{
                console.log(error);
            }
        });
    })

    var tableGroup;
    var groupInit = function () {
        tableGroup = new DataTable('#table_group', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            dom: "lrtip",
        });
    };
    groupInit();

    $('#search-input-group').on('keyup', function() {
        tableGroup.search(this.value).draw();
    });
});
