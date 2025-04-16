import { baseUrl }               from '/assets/crm/js/htecomJs/variableApi.js';
import { deleteExampleEmailApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.btn_delete_exam_email').on('click',(e)=>{
        const idExam  = $(e.currentTarget).data('id');
        const api     = baseUrl+deleteExampleEmailApi+idExam;
        const token   = localStorage.getItem('jwt_token');
        $(e.currentTarget).html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res) => {
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
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    })
})
