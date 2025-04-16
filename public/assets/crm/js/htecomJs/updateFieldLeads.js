import { baseUrl, updateFieldForLeadApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let customFieldsJs = window.customFields

    $(document).on('click', '#add-row-btn', function () {
        let options = customFieldsJs.map(field => `<option value="${field.name}">${field.name}</option>`).join('');
        const newRow = `
            <div class="row mb-1">
                <div class="col-4" style="padding-right:3px;">
                    <select class="form-select key_field_selected">
                        <option value="" disabled selected>Chọn</option>
                        ${options}
                    </select>
                </div>
                <div class="col-7" style="padding-left:3px;">
                    <input type="text" value="" class="form-control value_field_selected" placeholder="Nhập giá trị">
                </div>
                <div class="col-1" style="padding-left:3px;">
                    <button type="button" class="btn btn-ghost p-1 delete_row_custom_field">
                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18">
                    </button>
                </div>

            </div>
        `;

        $('#extended-fields-container').append(newRow);
    });

    $(document).on('click', '.delete_row_custom_field', function () {
        $(this).closest('.row').remove();
    });

    $(document).on('click', '#btn_update_field_lead', function (e) {
        const idLead         = $(this).attr('data-id');
        const api            = baseUrl+updateFieldForLeadApi+idLead;
        const token          = localStorage.getItem('jwt_token');
        let customFieldsNew  = {};
        $(this).html('Đang lưu...');

        $('#extended-fields-container .row').each(function () {
            let key = $(this).find('.key_field_selected').val();
            let value = $(this).find('.value_field_selected').val();

            if (key && typeof key === 'string') {
                customFieldsNew[key] = value;
            }
        });

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: customFieldsNew,
            success: (res) => {
                if(res.code == 422){
                    $.notify(res.message, "error");
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                $(this).html('Lưu');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    });
})
