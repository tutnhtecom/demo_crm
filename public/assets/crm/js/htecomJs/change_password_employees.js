import { baseUrl }            from '/assets/crm/js/htecomJs/variableApi.js';
import { retsetPasswordApi }  from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('#forgot_confirm').on('click', ()=>{
        var host = window.location.host;         
        let email = $('#lblEmail').attr('data-email');
        const api        = baseUrl+retsetPasswordApi;
        let new_password = $('#new_password').val();
        let confirm_password = $('#confirm_password').val();
        
        if(new_password.length <= 0) {
                $.notify("Vui lòng nhập mật khẩu mới", "error");
                return false;
        } else {
            if(confirm_password.length <= 0) {
                $.notify("Vui lòng nhập nhập lại mật khẩu mới", "error");
                return false;
            } else {
                if(new_password.length < 8) {
                    $.notify("Mật khẩu có độ dài tối thiểu 8 ký tự", "error");
                    return false;
                }
                if(confirm_password !== new_password) {
                    $.notify("Hai mật khẩu chưa trùng khớp", "error");
                    return false;
                }
            }
        }

        $('#forgot_confirm').html('Đang lưu...');             
        $.ajax({
            url: api,
            type: 'POST',
            data: {
                "email": email,
                "new_password" : new_password
            },
            success: (res) => {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    // Simulate a mouse click:
                    window.location.href = "/crm";
                } else {
                    handleError('#profile_current_password', '.profile_current_password_wrapper', res.data.old_password);
                    handleError('#profile_new_password', '.profile_new_password_wrapper', res.data.new_password);
                }
                $('#forgot_confirm').html('Xác nhận');
            },
            error: (err) => {
                console.log(err);
            }
        })
    })
    handleRemoveError('.profile_current_password_wrapper', '#profile_current_password');
    handleRemoveError('.profile_new_password_wrapper', '#profile_new_password');
})
