import { baseUrl, voip24hDeleteApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.icon_delete_voip24h', (e)=>{
        let id            = $(e.currentTarget).attr('data-id');
        $('#btn_delete_voip24h').attr('data-id', id);
    });

    $(document).on('click', '#btn_delete_voip24h',(e)=>{
        let btn           = $(e.currentTarget);
        let id            = btn.attr('data-id');
        let api           = baseUrl+voip24hDeleteApi+id;
        let token         = localStorage.getItem('jwt_token');
        btn.html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (response)=>{
                if(res.code == 200){
                    $.notify(response.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(response.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: (error)=>{
                console.log(error);
                alert('Xóa thất bại');
            }
        });
    })
});