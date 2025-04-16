import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createAffiliateApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let selectedColor;

    $('.ti_menu_colors button').on('click', function() {
        selectedColor = $(this).data('color');
    });

    $(document).on('click','#btn_add_new_sources', function(){
        const btn              = $('#btn_add_new_sources');
        const api              = baseUrl+createAffiliateApi;
        const token            = localStorage.getItem('jwt_token');
        let sourcesName        = $('#input_sources_name').val();

        btn.html('Đang xử lý...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            //Mặc định sources_types = 1 với các nguồn tiếp cận
            data: {
                "sources_types": 1,
                "name"         : sourcesName,
            },
            success: function(res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    $.notify(res.data.name, "error");
                }
                btn.html('Thêm mới');
            },
            error: function(error) {
                console.log(error);
            }
        })
    })

    var tableStatus;
    var dataTableInit = function() {
        tableStatus = new DataTable('#table_sources', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            dom: "lrtip"
        });
    };

    // custome input search \\
    $('#search_input_sources').on('keyup', function() {
        tableStatus.search(this.value).draw();
    });
    dataTableInit();
})

