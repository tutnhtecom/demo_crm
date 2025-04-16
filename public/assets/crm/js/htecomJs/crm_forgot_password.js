import { baseUrl }            from '/assets/crm/js/htecomJs/variableApi.js';
import { sendEmailLinkApi }   from '/assets/crm/js/htecomJs/variableApi.js';
// import { handleError }        from '/assets/crm/js/htecomJs/lead.js';
// import { handleRemoveError }  from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    //arr_group_ids được lấy từ lead.js
    $(document).on('click','#btnForgot', function(){        
        const btn     = $('#btnForgot');
        const api     = baseUrl+sendEmailLinkApi;                
        btn.html('Đang tạo...');
        let email = $('#crm-email-forgot').val();
        if(email.length <= 0) {
            $.notify("Vui lòng nhập Email của bạn", "error");
            return false;
        }        
        
        $.ajax({
            url: api,
            type: 'POST',           
            data: {
                "email"  : email
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#name_group_input', '.group_input_wrapper', res.data.name);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Xác nhận');
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
    // handleRemoveError('.group_input_wrapper', '#name_group_input');

});
