import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createRoleApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { updateRoleApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { deleteRoleApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { assignRoleApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(function () {
    $('.role_tab_link').on('click', function () {
        $('.role_tab_link').removeClass('bg-primary');
        $(this).addClass('bg-primary');

        $('.tab-pane').removeClass('show active');
        const target = $(this).attr('href');
        $(target).addClass('show active');
    });

    // ===== Create role ===== \\
    $('#btn_create_role').on('click', ()=>{
        const api    = baseUrl+createRoleApi;
        const token  = localStorage.getItem('jwt_token');
        const btn    = $('#btn_create_role');
        let nameRole = $('#input_role').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name": nameRole
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    $('#input_role').val('');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    handleError('#input_role', '.input_role_wrapper', res.data.name);
                }
                btn.html('Lưu');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    })
    handleRemoveError('.input_role_wrapper', '#input_role');
    // ===== END Create role ===== \\

    // ===== Edit role ===== \\
    let currentRoleId;
    $('.btn_edit_role').on('click', (e)=>{
        const btn      = $(e.currentTarget);
        currentRoleId  = btn.data('id');
        const api      = baseUrl+updateRoleApi+currentRoleId;
        const token    = localStorage.getItem('jwt_token');
        let nameRole   = $('#input_edit_role_'+currentRoleId).val();
        btn.html('Đang lưu...');
        removeError();

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name": nameRole
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    $('#input_edit_role').val('');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    handleError('#input_edit_role_'+currentRoleId, '.input_edit_role_wrapper_'+currentRoleId, res.data.name);
                }
                btn.html('Lưu');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    })
    function removeError() {
        if (currentRoleId) {
            handleRemoveError('.input_edit_role_wrapper_' + currentRoleId, '#input_edit_role_' + currentRoleId);
        }
    }
    // ===== END Edit role ===== \\

    // ===== Delete role ===== \\
    $('.btn_delete_role').on('click', (e)=>{
        const btn      = $(e.currentTarget);
        const idRole   = btn.data('id');
        const api      = baseUrl+deleteRoleApi+idRole;
        const token    = localStorage.getItem('jwt_token');
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
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    })
    // ===== END Delete role ===== \\

    // ===== Assign Permission for role ===== \\
    $(document).on('click', '.permission_check_all', (e)=>{
        const idForm = $(e.currentTarget).attr('data-id-form');
        $(`#role_form_${idForm} .permission_check`).prop('checked', true);
    })

    $(document).on('click', '.permission_uncheck', (e)=>{
        const idForm = $(e.currentTarget).attr('data-id-form');
        $(`#role_form_${idForm} .permission_check`).prop('checked', false);
    })

    $('.btn_save_roles').on('click', (e)=>{
        e.preventDefault();
        const btn       = $(e.currentTarget);
        const idRole    = btn.data('id');
        const api       = baseUrl+assignRoleApi;
        const token     = localStorage.getItem('jwt_token');
        let idPermisson = $('#role_form_'+ idRole +' .permission_check:checked').map(function() {
            return $(this).val();
        }).get();
        btn.html('Đang lưu...');
        if(idPermisson == ''){
            alert('Vui lòng chọn phân quyền trước khi lưu.')
            btn.html('Lưu');
            return false;
        }
        
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data:{
                "roles_id": idRole,
                "permissions_id": idPermisson,
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                } else {
                    $.notify(res.message, "error");
                }
                btn.html('Xác nhận');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    })
    // ===== END Assign Permission for role ===== \\
});
