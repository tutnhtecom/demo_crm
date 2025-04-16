import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { taskEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $(document).on('submit', '#create_task', (e) => {
        e.preventDefault();
        $('#task_btn_submit').html('Đang tạo...');

        const api           = baseUrl+taskEmployeeApi;
        const token         = localStorage.getItem('jwt_token');
        let name            = $('#task_name').val();
        let employees_id    = $('#task_employee').val();
        let priority        = $('#task_priority').val();
        let from_date       = formatDate($('#task_date_start').val());
        let to_date         = formatDate($('#task_date_end').val());
        let description     = $('.task_description').val();

        const iframeDocument = $('#job_description_ifr').contents().get(0);
        const bodyIframe     = iframeDocument.body;

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                name           : name,
                employees_id   : employees_id,
                priority       : priority,
                from_date      : from_date,
                to_date        : to_date,
                description    : description
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#task_name', '.task_name_wrapper', res.data.name);
                    // handleError('#task_date_start', '.task_date_wrapper', res.data.from_date);

                    if(res.data.from_date != null){
                        $('#task_date_start').addClass('border-error');
                        $('.task_date_wrapper .err_date_start').html(res.data.from_date);
                        $('.task_date_wrapper .err_date_start').addClass('show-error');
                    }

                    if(res.data.to_date != null){
                        $('#task_date_end').addClass('border-error');
                        $('.task_date_wrapper .err_date_end').html(res.data.to_date);
                        $('.task_date_wrapper .err_date_end').addClass('show-error');
                    }
                } else {
                    $('#task_name').val('');
                    $('#task_priority').val('').trigger('change');
                    $('#task_date_start').val('');
                    $('#task_date_end').val('');
                    $(bodyIframe).empty();
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $('#task_btn_submit').html('Giao việc');
            },
            error: (err) => {
                console.log(err);
            }
        })
    });
    handleRemoveError('.task_name_wrapper', '#task_name');
    // handleRemoveError('.task_date_wrapper', '#task_date_start');
    $('.task_date_wrapper').on('click', function() {
        $(this).find('.err_date_start').removeClass('show-error').html('');
        $(this).find('#task_date_start').removeClass('border-error');
    });
    $('.task_date_wrapper').on('click', function() {
        $(this).find('.err_date_end').removeClass('show-error').html('');
        $(this).find('#task_date_end').removeClass('border-error');
    });
})
