import { baseUrl,logoutApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $(document).on('click','.btn_logout_crm', ()=>{
        const api = baseUrl+logoutApi;
        const token = localStorage.getItem('jwt_token');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res)=>{
                if(res.code == 200){
                    localStorage.removeItem('jwt_token');
                    window.location.href = baseUrl+'/crm/login';
                }
            },
            error: function(error){
                // Handle the error here
            }
        });
    })
})
