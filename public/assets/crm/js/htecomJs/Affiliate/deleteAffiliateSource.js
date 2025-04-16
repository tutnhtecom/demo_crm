import { baseUrl, deleteAffiliateApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_delete_affiliate', (e)=>{
        const idAffiliate   = $(e.currentTarget).attr('data-id');
        const api           = baseUrl+deleteAffiliateApi+idAffiliate;
        const token         = localStorage.getItem('jwt_token');
        $(e.currentTarget).html('Đang xóa...');

        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res)=>{
                if(res.code == 422){
                    $.notify(res.message, "error");
                } else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $(e.currentTarget).html('Xác nhận');
            },
            error: (err)=>{
                console.log(err);
            }
        })
    })
})
