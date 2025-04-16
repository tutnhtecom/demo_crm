import { baseUrl, deleteAffiliateApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $(document).on('click', '.btn_delete_sources', (e)=>{
        const btn      = $(e.currentTarget);
        const idStatus = btn.data('id');
        const api      = baseUrl+deleteAffiliateApi+idStatus;
        const token    = localStorage.getItem('jwt_token');
        btn.html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: function(error) {
                console.log(error);
            }
        })
    })

})
