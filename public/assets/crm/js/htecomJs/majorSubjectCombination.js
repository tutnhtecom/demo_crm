import { baseUrl, createMajor, createBlockCombination } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    var tableMajors;
    var dataTableMajors = function() {
        tableMajors = new DataTable('#table_major_subject_combination', {
            order: [],
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            dom: "lrtip",
            stateSave: true
        });
    };
    dataTableMajors();

    $('#search-input-subject_combination').on('keyup', function() {
        tableMajors.search(this.value).draw();
    });

    $(document).on('click', '#btn_create_major', (e)=>{
        const btn       = $(e.currentTarget);
        const api       = baseUrl + createMajor;
        const token     = localStorage.getItem('jwt_token');
        let major_name  = $('#create_major_name').val();
        btn.prop('disabled', true).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name": major_name
            },
            success: (res) => {
                if (res.code == 422) {
                    handleError('#create_major_name', '.create_major_name_wrapper', res.data.name);
                } else {
                    $.notify(res.message, "success");
                    window.location.reload();
                }
                btn.prop('disabled', false).html('Lưu');
            },
            error: (error) => {
                console.error(error);
            }
        })
    })
    handleRemoveError('.create_major_name_wrapper', '#create_major_name');

    $(document).on('click', '.btn_add_combination', (e)=>{
        const idMajor = $(e.currentTarget).attr('data-id');
        $('#btn_create_combination').attr('data-id', idMajor);
    })

    $(document).on('click', '#btn_create_combination', (e)=>{
        const btn           = $(e.currentTarget);
        const marjors_id    = btn.attr('data-id');
        const api           = baseUrl+createBlockCombination;
        const token         = localStorage.getItem('jwt_token');
        let name            = $('#create_combination_name').val();
        btn.prop('disabled', true).html('Đang lưu...');

        let inputString = name;
        let hashIndex = inputString.indexOf('#');
        let subject;

        if (hashIndex !== -1) {
            subject = $.trim(inputString.substring(hashIndex + 1));
        } else {
            subject = name;
        }

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "marjors_id": marjors_id,
                "code"      : "",
                "name"      : name,
                "subject"   : subject
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#create_combination_name', '.create_combination_name_wrapper', res.data.name);
                } else{
                    $.notify(res.message, "success");
                    window.location.reload(); 
                }
                btn.prop('disabled', false).html('Lưu');
            },
            error: (xhr, status, err) => {
                console.error(err);
            }
        })
    })
    handleRemoveError('.create_combination_name_wrapper', '#create_combination_name');
})