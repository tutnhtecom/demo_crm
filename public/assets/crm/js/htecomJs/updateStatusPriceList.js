import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { updateStatusPriceListApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.change_status_price_list').on('change', function () {
        const priceList   = $(this).data('id');
        const api         = baseUrl+updateStatusPriceListApi+priceList;
        const token       = localStorage.getItem('jwt_token');
        var selectedValue = $(this).val();

        if (selectedValue) {
            $.ajax({
                url: api, 
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: {
                    "status": selectedValue
                },
                success: function (res) {
                    if(res.code == 200){
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                },
                error: function () {
                    $.notify(res.message, "error");
                }
            });
        }
    });
})