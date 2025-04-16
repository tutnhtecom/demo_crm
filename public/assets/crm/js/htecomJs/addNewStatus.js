import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { addNewStatusApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let selectedColor;

    $('.ti_menu_colors button').on('click', function() {
        selectedColor = $(this).data('color');
    });

    $('#btn_add_new_status').on('click', ()=>{
        const btn              = $('#btn_add_new_status');
        const api              = baseUrl+addNewStatusApi;
        const token            = localStorage.getItem('jwt_token');
        let statusName         = $('#input_status_name').val();

        if (!selectedColor) {
            console.log("No color selected");
            return;
        }
        const colorWithOpacity = rgbToRGBA(selectedColor, 0.15);
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
        tableStatus = new DataTable('#table_status', {
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
    $('#search_input_status').on('keyup', function() {
        tableStatus.search(this.value).draw();
    });
    dataTableInit();
})

export function rgbToRGBA(rgb, opacity) {
    const rgbValues = rgb.match(/\d+/g);

    if (!rgbValues || rgbValues.length < 3) return null;

    const r = rgbValues[0];
    const g = rgbValues[1];
    const b = rgbValues[2];

    return `rgba(${r}, ${g}, ${b}, ${opacity})`;
}
