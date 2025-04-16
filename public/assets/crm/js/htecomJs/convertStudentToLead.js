import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { convertStudentToLeadApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click','#btn_convert_std_to_lead', function(){
        const btn = $(this);
        const idStudent = btn.data('id');
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl+convertStudentToLeadApi;
        let arr_data = [];
        if(idStudent == 0){
            $('#convertStudentModal').modal('hide');
            return
        }
        if (/^\d+$/.test(idStudent)) {
            // Nếu là một số duy nhất
            arr_data.push(idStudent)
        } else if (/^\d+(,\d+)+$/.test(idStudent)) {
            // Nếu là một chuỗi gồm nhiều số phân tách bởi dấu phẩy
            const arr = idStudent.split(",");
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
                    $.notify(res.message, "error");
                }
                $('#btn_convert_std_to_lead').attr('data-id', '');
                $('#table_students').DataTable().ajax.reload();
                $('#convertStudentModal').modal('hide');
                btn.html('Xác nhận');
            },
            error: function () {
                $.notify(res.message, "error");
            }
        });
    })
})
