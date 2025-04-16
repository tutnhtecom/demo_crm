import { baseUrl, activeEmployeeApi }       from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '.crm_employees_active', (e)=>{
        const btn = $(e.currentTarget);
        const api = baseUrl+activeEmployeeApi;
        const token = localStorage.getItem('jwt_token');
        const emailE = btn.attr('data-email-e');
        btn.html('Đang kích hoạt...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "email" : emailE,
            },
            success: (res)=>{
                if(res.code == 422){
                    $.notify(res.message, "error");
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        document.location.reload();
                    }, 1000);
                }
                btn.html('Kích hoạt');
            },
            error: (res)=>{
                console.log(res);
            }
        })
    })
})