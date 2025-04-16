import { baseUrl }            from '/assets/crm/js/htecomJs/variableApi.js';
import { changePasswordApi }  from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError }        from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError }  from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $('#save_change_password').on('click', ()=>{
        const api        = baseUrl+changePasswordApi;
        const token      = localStorage.getItem('jwt_token');
        let old_password = $('#profile_current_password').val();
        let new_password = $('#profile_new_password').val();
        $('#save_change_password').html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "old_password"               : old_password,
                "new_password"               : new_password,
                "new_password_confirmation"  : new_password
            },
            success: (res) => {
                if(res.code == 200 || res.code == 201){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else if(res.code == 422 && res.message){
                    $.notify(res.message, "error");
                }
                else {
                    handleError('#profile_current_password', '.profile_current_password_wrapper', res.data.old_password);
                    handleError('#profile_new_password', '.profile_new_password_wrapper', res.data.new_password);
                }
                $('#save_change_password').html('Lưu thay đổi');
            },
            error: (err) => {
                console.log(err);
            }
        })
    })
    handleRemoveError('.profile_current_password_wrapper', '#profile_current_password');
    handleRemoveError('.profile_new_password_wrapper', '#profile_new_password');
})
