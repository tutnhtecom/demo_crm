import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { updateNotePriceListApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.btn_update_note_price').on('click', (e)=>{
        const idPrice = $(e.currentTarget).data('id');
        const api = baseUrl+updateNotePriceListApi+idPrice;
        const token = localStorage.getItem('jwt_token');
        let note = $('#note_input_edit_'+idPrice).val();
        $(e.currentTarget).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "note": note
            },
            success: (res) => {
                if(res.code == 422){
                    $.notify(res.data.note, "error");
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $(e.currentTarget).html('Lưu');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })
})
