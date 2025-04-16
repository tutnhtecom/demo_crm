import { baseUrl, editMajor, editBlockCombination } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    // Chỉnh sửa chuyên ngành \\
    $(document).on('click', '.icon_edit_major', (e)=>{
        const idMajor = $(e.currentTarget).attr('data-id');
        const nameMajor = $(e.currentTarget).attr('data-name');

        $('#btn_edit_major').attr('data-id', idMajor);
        $('#edit_major_name').val(nameMajor);
    })

    $(document).on('click', '#btn_edit_major', (e)=>{
        const btn           = $(e.currentTarget);
        const marjors_id    = btn.attr('data-id');
        const api           = baseUrl + editMajor + marjors_id;
        const token         = localStorage.getItem('jwt_token');
        let major_name      = $('#edit_major_name').val();
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
                    handleError('#edit_major_name', '.edit_major_name_wrapper', res.data.name);
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
    handleRemoveError('.edit_major_name_wrapper', '#edit_major_name');

    // Chỉnh sửa tổ hợp môn \\
    $(document).on('click', '.icon_edit_combination', (e)=>{
        const idCombination   = $(e.currentTarget).attr('data-combination-id');
        const nameCombination = $(e.currentTarget).attr('data-combination-name');
        const majorId         = $(e.currentTarget).attr('data-major-id');

        $('#btn_edit_combination').attr('data-id', idCombination);
        $('#btn_edit_combination').attr('data-major-id', majorId);
        $('#edit_combination_name').val(nameCombination);
    })

    $(document).on('click', '#btn_edit_combination', (e)=>{
        const btn               = $(e.currentTarget);
        const combination_id    = btn.attr('data-id');
        const api               = baseUrl + editBlockCombination + combination_id;
        const token             = localStorage.getItem('jwt_token');
        const major_id          = btn.attr('data-major-id');
        let combination_name    = $('#edit_combination_name').val();
        btn.prop('disabled', true).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"      : combination_name
            },
            success: (res) => {
                if (res.code == 422) {
                    handleError('#edit_combination_name', '.edit_combination_name_wrapper', res.data.name);
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
    handleRemoveError('.edit_combination_name_wrapper', '#edit_combination_name');
})