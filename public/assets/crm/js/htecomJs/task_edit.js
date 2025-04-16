import { baseUrl, taskEditApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '.btn_task_edit', (e)=>{
        const btn           = $(e.currentTarget);
        const taskId        = btn.attr('data-id');
        const api           = baseUrl+taskEditApi+taskId;
        const token         = localStorage.getItem('jwt_token');

        let name            = $('#task_edit_name_'+taskId).val();
        let employees_id    = $('#task_edit_employee_'+taskId).val();
        let from_date       = formatDate($('#task_eidt_date_start_'+taskId).val());
        let to_date         = formatDate($('#task_eidt_date_end_'+taskId).val());
        let priority        = $('#task_edit_priority_'+taskId).val();
        let status          = $('#task_edit_status_'+taskId).val();

        let descriptionEditor = tinymce.get('task_edit_description_' + taskId); // Lấy editor TinyMCE theo id
        let description       = descriptionEditor ? descriptionEditor.getContent() : '';

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"          : name,
                "employees_id"  : employees_id,
                "from_date"     : from_date,
                "to_date"       : to_date,
                "description"   : description,
                "priority"      : priority,
                "status"        : status
            },
            success: (res) => {
                if(res.code == 422){
                    if(res.data.from_date != null){
                        $.notify(res.data.from_date, "error");
                    }
                    if(res.data.to_date != null){
                        $.notify(res.data.to_date, "error");
                    }
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: (err) => {
                btn.html('Lưu');
                console.error(err);
            }
        })

    })
})

