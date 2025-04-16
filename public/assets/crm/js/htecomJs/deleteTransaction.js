import { baseUrl }              from '/assets/crm/js/htecomJs/variableApi.js';
import { deleteTransactionApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.btn_delete_transaction').on('click',(e)=>{
        const btn      = $(e.currentTarget);
        const idPrice  = btn.data('id');
        const api      = baseUrl+deleteTransactionApi+idPrice;
        const token    = localStorage.getItem('jwt_token');
        btn.html('Đang xóa...');

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
                        // window.location.reload();
                        document.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: (error)=>{
                console.error('Error:', error);
            }
        })
    })
})
