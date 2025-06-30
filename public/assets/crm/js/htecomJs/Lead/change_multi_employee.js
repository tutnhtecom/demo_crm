import { baseUrl, changeMultiEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_success_change_employee', (e)=>{
        let btn = $(e.currentTarget);
        let idEmployee = btn.attr('data-employee-id');
        let idLead = btn.attr('data-id');
        let idLeadArray = idLead.split(',').map(Number);
        const api        = baseUrl+changeMultiEmployeeApi;
        const token      = localStorage.getItem('jwt_token');
        btn.html('<span class="d-none d-md-block" style="padding:10px;">Đang thực hiện...</span>');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "assignments_id": idEmployee,
                "leads_ids": idLeadArray
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(()=>{
                        window.location.reload();
                    }, 1000)
                    btn.html('<span class="d-none d-md-block" style="padding:10px;">Xác nhận</span>');
                } else {
                    $.notify(res.message, "error");
                    btn.html('<span class="d-none d-md-block" style="padding:10px;">Xác nhận</span>');
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    })
})