import { baseUrl,affiliateDeleteSemestersApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(function() {

    $(document).on('click', '.btn_delete_academic', (e)=>{
        const btn   = $(e.currentTarget);
        const id    = $(e.currentTarget).attr('data-id');
        const api   = baseUrl+affiliateDeleteSemestersApi+id;
        const token = localStorage.getItem('jwt_token');
        btn.html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success:(res)=>{
                if(res.code == 422){
                    console.log(res);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(()=>{
                        window.location.reload();
                    }, 1000);
                    btn.html('Xác nhận'); 
                }
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })
});