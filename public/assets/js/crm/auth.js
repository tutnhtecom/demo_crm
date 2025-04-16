$(document).ready(() => {
    const baseUrl            = window.location.origin;
    const registerApi        = '/api/auth/register';
    const loginApi           = '/api/auth/login';
    const forgotPasswordApi  = '/api/leads/forgot-password';
    const createEmployee     = '/api/employees/create';

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
        }
    });

    // --- form register --- \\
    $(document).on('submit', '#crm-form-register', (e) => {
        e.preventDefault();
        const api = baseUrl+registerApi;
        const formData  = new FormData();
        let email = $('#crm-email-register').val();
        let password = $('#crm-password-register').val();
        let name = $('#crm-name-register').val();
        let phone = $('#crm-phone-register').val();

        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('password', password);

        $.ajax({
            url: api,
            type: 'POST',
            data:formData,
            processData: false,
            contentType: false,
            success: (response) => {                
                let data = response.data;
                if(response.code == 422){
                    handleError('#crm-name-register', '.crm-name-register-wrapper', data.name);
                    handleError('#crm-phone-register', '.crm-phone-register-wrapper', data.phone);
                    handleError('#crm-email-register', '.crm-email-register-wrapper', data.email);
                    handleError('#crm-password-register', '.crm-password-register-wrapper', data.password);
                } else {
                    $.notify(response.message, "success");
                    setTimeout(function() {
                        window.location.href = baseUrl + '/crm/login';
                    }, 1000);
                }
            },
            error: (err) => {
                $.notify(err, "error");                
            }
        })
    })
    handleRemoveError('.crm-name-register-wrapper', '#crm-name-register');
    handleRemoveError('.crm-phone-register-wrapper', '#crm-phone-register');
    handleRemoveError('.crm-email-register-wrapper', '#crm-email-register');
    handleRemoveError('.crm-password-register-wrapper', '#crm-password-register');

    $(document).on('submit', '#crm-form-login', (e) => {        
        e.preventDefault();
        const api = baseUrl+loginApi;
        let email = $('#crm-email-login').val();
        let password = $('#crm-password-login').val();
        $.ajax({
            url: api,
            type: 'POST',
            data: {
                email: email,
                password: password,
                types: 2
            },
            success: (response) => {                
                let data = response.data;
                if(response.code == 422){
                    if(response.message) {
                        $.notify(response.message, "error");   
                        return false;
                    } 
                    handleError('#crm-email-login', '.crm-email-login-wrapper', data.email);
                    handleError('#crm-password-login', '.crm-password-login-wrapper', data.password);
                    // if(data['email']){
                    //     $.notify(data['email'], "error");     
                    // }
                    // if(data['password']){
                    //     $.notify(data['email'], "error");  
                    // }
                } else if(response.code == 401) {
                    $.notify(response.message, "error");                     
                } else if (response.code === 200 && response.data) {
                    const token = response.data.access_token;
                    localStorage.setItem('jwt_token', token);  // Lưu token vào localStorage
                    // document.cookie = "jwt_token=" + token + "; path=/";
                    window.location.href = baseUrl + '/crm';
                }
            },
            error: (err) => {                
                $.notify(err, "error"); 
            }
        })
    })
    handleRemoveError('.crm-email-login-wrapper', '#crm-email-login');
    handleRemoveError('.crm-password-login-wrapper', '#crm-password-login');
    handleChangeRemoveError('.crm-password-login-wrapper', '#crm-password-login');

    $('#icon-show').on('click', function() {
        var passwordField = $('.show-password');
        var passwordFieldType = passwordField.attr('type');

        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#icon-show').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#icon-show').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // FORGOT PASSWORD \\
    $(document).on('click', '#forgot_password_submit', function(){
        const $btn  = $(this);
        const api   = baseUrl+forgotPasswordApi;
        let email   = $('#email_forgot_password').val();
        $btn.prop('disabled', true).text('Đang gửi...');

        $.ajax({
            url: api,
            type: 'POST',
            data: {
                "email": email
            },
            success: (response) => {                
                if(response.code == 422){
                    $.notify(response.data.email, "error");   
                } else if (response.code === 200) {
                    $.notify(response.message, "success");
                    $('#email_forgot_password').val('');
                    $('#forgot_password_close').trigger('click');   
                }
            },
            error: (err) => {                
                $.notify(err, "error"); 
            },
            complete: () => {
                $btn.prop('disabled', false).text('Gửi');
            }
        })
        
    })
})
