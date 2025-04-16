import { 
    baseUrl, 
    voip24hConfigCreateApi,
    voip24hConfigUpdateApi,
    voip24hConfigDeleteApi } 
from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_create_config_voip', (e)=>{
        let btn         = $(e.currentTarget);
        let api         = baseUrl+voip24hConfigCreateApi;
        let token       = localStorage.getItem('jwt_token');
        let api_key     = $('#create_api_key').val();
        let api_secret  = $('#create_api_secret').val();
        let ip_voip24h  = $('#create_ip_voip24h').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "api_key"    : api_key,
                "api_secret" : api_secret,
                "voip_ip"    : ip_voip24h,
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);  
                }
                btn.html('Lưu');
            },
            error: function (xhr, status, error) {
                btn.html('Lưu');
                console.log(error);
            }
        })
    });

    $(document).on('click', '#btn_update_config_voip', (e)=>{
        let btn         = $(e.currentTarget);
        let idvoip      = $('#create_api_key').attr('voip-id');
        let api         = baseUrl+voip24hConfigUpdateApi+idvoip;
        let token       = localStorage.getItem('jwt_token');
        let api_key     = $('#create_api_key').val();
        let api_secret  = $('#create_api_secret').val();
        let ip_voip24h  = $('#create_ip_voip24h').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "api_key"    : api_key,
                "api_secret" : api_secret,
                "voip_ip"    : ip_voip24h,
            },
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);  
                }
                btn.html('Lưu');
            },
            error: function (xhr, status, error) {
                btn.html('Lưu');
                console.log(error);
            }
        })
    });
});