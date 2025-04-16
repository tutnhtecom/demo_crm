import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { changeStatusLeadApi, changeStatusStudentApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('change', '.lead_status_select', function() {
        const idLead      = $(this).data('id');
        // Cần thêm change status sinh viên
        const api         = baseUrl+changeStatusLeadApi+idLead;
        const token       = localStorage.getItem('jwt_token');
        var selectedValue = $(this).val();
        if (selectedValue) {
            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: {
                    "lst_status_id": selectedValue
                },
                success: function (res) {
                    if(res.code == 200){
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                },
                error: function () {
                    $.notify(res.message, "error");
                }
            });
        }
    });

    //Thay đổi trạng thái sinh viên
    $(document).on('change', '.student_status_select', function() {
        const idLead      = $(this).data('id');
        const api         = baseUrl+changeStatusStudentApi+idLead;
        const token       = localStorage.getItem('jwt_token');
        var selectedValue = $(this).val();
        if (selectedValue) {
            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: {
                    "lst_status_id": selectedValue
                },
                success: function (res) {
                    if(res.code == 200){
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                },
                error: function () {
                    $.notify(res.message, "error");
                }
            });
        }
    });
})
