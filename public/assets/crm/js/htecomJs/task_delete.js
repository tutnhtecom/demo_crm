import { baseUrl, taskDeleteApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_delete_task', (e)=>{
        const btn = $(e.currentTarget);
        const idTassk = btn.attr('data-id');
        const api = baseUrl+taskDeleteApi+idTassk;
        const token = localStorage.getItem('jwt_token');
        btn.html("Đang xóa...");

        $.ajax({
            url: api,
            type: 'POST',
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
                btn.html("Xóa");
            },
            error: (res)=>{
                console.log(res);
            }
        });
    })
})
