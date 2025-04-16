import { baseUrl, deleteSourceDocumentApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_delete_document', (e)=>{
        const documentID   = $(e.currentTarget).attr('data-id');
        const api           = baseUrl+deleteSourceDocumentApi+documentID;
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
                    }, 1200);
                }
                $(e.currentTarget).html('Xác nhận');
            },
            error: (err)=>{
                console.log(err);
            }
        })
    })
})
