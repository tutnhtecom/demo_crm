import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { changeEmployeeForLeadApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click','.employee-radio', function() {
        var idLead       = $(this).attr('data-id');
        var employeeName = $(this).attr('data-name');
        var employeeCode = $(this).attr('data-code');
        var employeeId   = $(this).val();
        var employeeImg  = "assets/crm/media/svg/avatars/blank.svg";
        const api        = baseUrl+changeEmployeeForLeadApi+idLead;
        const token      = localStorage.getItem('jwt_token');

        $('#employee-info-of-'+idLead).html(`
            <div class="d-flex align-items-between align-items-center flex-row-fluid flex-wrap">
                <div class="d-flex flex-column flex-grow-0 me-2">
                    <span class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold">${employeeName}</span>
                    <span class="text-muted fw-semibold d-block fs-7">${employeeCode}</span>
                </div>
            </div>
        `);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "assignments_id": employeeId
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(()=>{
                        window.location.reload();
                    }, 1000)
                } else {
                    $.notify(res.message, "error");
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    });
})
