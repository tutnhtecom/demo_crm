import { baseUrl, deleteTicketApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $(document).on('click','.btn_delete_ticket', (e)=>{
        const idTicket = $(e.currentTarget).data('id');
        const api = baseUrl+deleteTicketApi+idTicket;
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
                console.error(xhr, status, error);
            }
        })
    })

});
