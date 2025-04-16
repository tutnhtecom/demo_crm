import { baseUrl, updateAffiliateApi }         from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $(document).on('click', '.btn_edit_sources', (e)=>{
        const btn              = $(e.currentTarget);
        const idStatus         = btn.data('id');
        const api              = baseUrl+updateAffiliateApi+'/'+idStatus;
        const token            = localStorage.getItem('jwt_token');
        let statusName         = $('#input_edit_sources_name_'+idStatus).val();

        btn.html('Đang xử lý...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"         : statusName,
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (res.message) {
                        $.notify(res.message, "error");
                    } else {
                        $.notify(res.data.name, "error");
                    }
                }
                btn.html('Thêm mới');
            },
            error: function(error) {
                console.log(error);
            }
        })
    })

})
