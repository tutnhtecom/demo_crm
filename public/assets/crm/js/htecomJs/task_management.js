import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { taskEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $(document).on('submit', '#task_create_management', (e) => {
        e.preventDefault();
        $('#task_create_btn_submit').html('Đang tạo...');

        const api           = baseUrl+taskEmployeeApi;
        const token         = localStorage.getItem('jwt_token');
        let name            = $('#task_create_name').val();
        let employees_id    = $('#task_create_employee').val();
        let priority        = $('#task_create_priority').val();
        let from_date       = formatDate($('#task_create_date_start').val());
        let to_date         = formatDate($('#task_create_date_end').val());
        let description     = $('.task_create_description').val();

        const iframeDocument = $('#job_description_create_ifr').contents().get(0);
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
                    handleError('#task_create_name', '.task_create_name_wrapper', res.data.name);
                    if(res.data.from_date != null){
                        $('#task_create_date_start').addClass('border-error');
                        $('.task_create_date_wrapper .err_date_start').html(res.data.from_date);
                        $('.task_create_date_wrapper .err_date_start').addClass('show-error');
                    }
                    if(res.data.to_date != null){
                        $('#task_create_date_end').addClass('border-error');
                        $('.task_create_date_wrapper .err_date_end').html(res.data.to_date);
                        $('.task_create_date_wrapper .err_date_end').addClass('show-error');
                    }
                } else {
                    $('#task_create_name').val('');
                    $('#task_create_priority').val('').trigger('change');
                    $('#task_create_date_start').val('');
                    $('#task_create_date_end').val('');
                    $(bodyIframe).empty();
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $('#task_create_btn_submit').html('Giao việc');
            },
            error: (err) => {
                console.log(err);
            }
        })
    });
    handleRemoveError('.task_create_name_wrapper', '#task_create_name');
    $('.task_create_date_wrapper').on('click', function() {
        $(this).find('.err_date_start').removeClass('show-error').html('');
        $(this).find('#task_create_date_start').removeClass('border-error');
    });
    $('.task_create_date_wrapper').on('click', function() {
        $(this).find('.err_date_end').removeClass('show-error').html('');
        $(this).find('#task_create_date_end').removeClass('border-error');
    });

    var tableTaskEmployees;
    var dataTaskEmployeesInit = function() {
        tableTaskEmployees = new DataTable('#table_task_of_employees', {
            order: [],
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            dom: "lrtip",
            columnDefs: [
                { width: '50px', targets: 0 }
            ]
        });
    };
    dataTaskEmployeesInit();

    TI_Util.onDOMContentLoaded(function () {
        tinymce.init({
            selector: 'textarea#job_description_create',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
        });
    });

    TI_Util.onDOMContentLoaded(function () {
        tinymce.init({
            selector: 'textarea.task_edit_description',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
            setup: function (editor) {
                $(document).on('click', '.edit_task_employee', function () {
                    let dataId = $(this).attr('data-id');
                    editor.setContent(window[`contentTask` + dataId]);
                });
            }
        });
    });
})
