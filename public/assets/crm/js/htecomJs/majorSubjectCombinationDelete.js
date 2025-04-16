import { baseUrl, deleteMajor, deleteCombination } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    // Xóa chuyên ngành \\
    $(document).on('click', '.icon_delete_major', (e)=>{
        const idMajor = $(e.currentTarget).attr('data-id-major');
        $('.btn_delete_major').attr('data-id-major', idMajor);
    })

    $(document).on('click', '.btn_delete_major', (e)=>{
        const btn = $(e.currentTarget);
        const idMajor = btn.attr('data-id-major');
        const api = baseUrl+deleteMajor+idMajor;
        const token = localStorage.getItem('jwt_token');
        btn.prop('disabled', true).html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    window.location.reload();
                } else {
                    $.notify(res.message, "error");
                }
                btn.prop('disabled', false).html('Xác nhận');
            },
            error: function(error) {
                console.log(error);
            }
        }) 
    })

    // Xóa tổ hợp môn \\
    $(document).on('click', '.icon_delete_combination', (e)=>{
        const idMajor = $(e.currentTarget).attr('data-id-combination');
        $('.btn_delete_combination').attr('data-id-combination', idMajor);
    })

    $(document).on('click', '.btn_delete_combination', (e)=>{
        const btn = $(e.currentTarget);
        const idCombination = btn.attr('data-id-combination');
        const api = baseUrl+deleteCombination+idCombination;
        const token = localStorage.getItem('jwt_token');
        btn.prop('disabled', true).html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    window.location.reload();
                } else {
                    $.notify(res.message, "error");
                }
                btn.prop('disabled', false).html('Xác nhận');
            },
            error: function(error) {
                console.log(error);
            }
        }) 
    })
})