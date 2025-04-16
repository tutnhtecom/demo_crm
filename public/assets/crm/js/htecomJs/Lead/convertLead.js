import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { convertLeadToStudentApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click','#btn_convert_lead', function(){
        const btn = $(this);
        const idLead = btn.data('id');
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl+convertLeadToStudentApi;
        let arr_data = [];
        if(idLead == 0){
            $('#convertLeadModal').modal('hide');
            return
        }
        if (/^\d+$/.test(idLead)) {
            // Nếu là một số duy nhất
            arr_data.push(idLead)
        } else if (/^\d+(,\d+)+$/.test(idLead)) {
            // Nếu là một chuỗi gồm nhiều số phân tách bởi dấu phẩy
            const arr = idLead.split(",");
            const arrNumbers = arr.map(Number);
            arr_data = arrNumbers;
        }
        btn.html('Đang chuyển đổi...');
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            contentType: "application/json",
            data: JSON.stringify({'ids': arr_data}),
            success: function (res) {
                if(res.code == 200){
                    $.notify(res.message, "success");
                    document.location.reload();
                } else {
                    $.notify(res.message.ids, "error");
                }
                $('#btn_convert_lead').attr('data-id', '');
                $('#table-leads').DataTable().ajax.reload();
                $('#convertLeadModal').modal('hide');
                btn.html('Xác nhận');
            },
            error: function () {                
                $.notify(res.message, "error");
            }
        });
    })
})
