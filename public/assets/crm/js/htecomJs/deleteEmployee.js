import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { deleteEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    
    $('#btn_delete_employee').on('click', ()=>{
        const btn        = $('#btn_delete_employee');
        const idEmployee = btn.data('id');
        const api        = baseUrl+deleteEmployeeApi+idEmployee;
        const token      = localStorage.getItem('jwt_token');
        btn.html('Đang xóa...');

        $.ajax({
            url: api, 
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    window.location.href = baseUrl+"/crm/employees";
                } else {
                    $.notify(res.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: function () {
                $.notify(res.message, "error");
            }
        });
    })

    $(document).on('click', '.btn_delete_employee', (e)=>{
        const idEmployee  = $(e.currentTarget).data('id');
        const api         = baseUrl+deleteEmployeeApi+idEmployee;
        const token       = localStorage.getItem('jwt_token');
        $(e.currentTarget).html('Đang xóa...');

        $.ajax({
            url: api, 
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    window.location.href = baseUrl+"/crm/employees";
                } else {
                    $.notify(res.message, "error");
                }
                $(e.currentTarget).html('Xác nhận');
            },
            error: function () {
                $.notify(res.message, "error");
            }
        });
    })
})