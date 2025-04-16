import { baseUrl, editProfileUserApi }      from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError,  handleRemoveError }  from '/assets/crm/js/htecomJs/lead.js';
import { formatDate }                       from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $('#save_info_account').on('click', (e)=>{
        const btn       = $(e.currentTarget);
        const idUser    = btn.attr('data-id');
        const api       = baseUrl+editProfileUserApi+idUser;
        const token     = localStorage.getItem('jwt_token');

        let full_name   = $('#profile_name').val();
        let phone       = $('#profile_phone').val();
        let email       = $('#profile_email').val();
        let dateOfBirth = formatDate($('#profile_dob').val());
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"          : full_name,
                // "email"         : email,
                "phone"         : phone,
                "date_of_birth" : dateOfBirth
            },
            success: (res)=>{
                if(res.code == 422){
                    handleError('#profile_name', '.profile_name_wrapper', res.data.name);
                    handleError('#profile_phone', '.profile_phone_wrapper', res.data.phone);
                    handleError('#profile_email', '.profile_email_wrapper', res.data.email);
                    handleError('#profile_dob', '.profile_dob_wrapper', res.data.date_of_birth);
                } else {
                    $.notify(res.message, "success");
                }
                btn.html('Lưu thay đổi');
            },
            error: (error)=>{
                console.log(error);
            }
        })
    })

    handleRemoveError('.profile_name_wrapper', '#profile_name');
    handleRemoveError('.profile_phone_wrapper', '#profile_phone');
    handleRemoveError('.profile_email_wrapper', '#profile_email');
    handleRemoveError('.profile_dob_wrapper', '#profile_dob');
})