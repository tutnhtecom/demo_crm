import { baseUrl }         from '/assets/crm/js/htecomJs/variableApi.js';
import { editStatusApi }   from '/assets/crm/js/htecomJs/variableApi.js';
import { rgbToRGBA }       from '/assets/crm/js/htecomJs/addNewStatus.js';

$(document).ready(()=>{
    let selectedColor;
    let colorWithOpacity;

    $(document).on('click', '#ti_menu_colors_x button', function(){
        selectedColor = $(this).data('color');
    })

    // $('#ti_menu_colors_x button').on('click', function() {
    //     selectedColor = $(this).data('color');
    // });

    $(document).on('click', '.btn_edit_status', (e)=>{
        const btn              = $(e.currentTarget);
        const idStatus         = btn.data('id');
        const api              = baseUrl+editStatusApi+idStatus;
        const token            = localStorage.getItem('jwt_token');
        let statusName         = $('#input_edit_status_name_'+idStatus).val();

        if (selectedColor) {
            colorWithOpacity = rgbToRGBA(selectedColor, 0.15);
        }
        btn.html('Đang xử lý...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"         : statusName,
                "color"        : selectedColor,
                "border_color" : selectedColor,
                "bg_color"     : colorWithOpacity
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
