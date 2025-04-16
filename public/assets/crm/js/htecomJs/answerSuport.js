import { baseUrl, answerSuportApi, changeStatusTicketApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_answer_suport', (e)=>{
        const btn       = $(e.currentTarget);
        const idAnswer  = btn.attr('data-id');
        const api       = baseUrl+answerSuportApi+idAnswer;
        const apiUpdate = baseUrl+changeStatusTicketApi+idAnswer;
        const token     = localStorage.getItem('jwt_token');
        let answer      = $('#answer_textarea').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "answers": answer
            },
            success: (res)=>{
                if(res.code == 200){

                    $.ajax({
                        url: apiUpdate,
                        type: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        data: {
                            "sp_status_id": 3
                        },
                        success: (res)=>{
                            if(res.code == 200){
                                $.notify(res.message, "success");
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                            btn.html('Lưu');
                        },
                        error: (err)=>{
                            console.log(err);
                            alert('Đã xảy ra l��i. Vui lòng thử lại.');
                        }
                    })

                    // $.notify(res.message, "success");
                    // setTimeout(function() {
                    //     window.location.reload();
                    // }, 1000);
                }
                btn.html('Lưu');
            },
            error: (err)=>{
                console.log(err);
                alert('Đã xảy ra l��i. Vui lòng thử lại.');
            }
        })
    })
})
