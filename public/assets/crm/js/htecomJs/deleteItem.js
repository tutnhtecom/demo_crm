import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { deleteLeadApi, deleteMultipleLeadApi, deleteEmployeeApi, deleteMultipleEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click','#btn_delete_item', function(){
        $('#btn_delete_item').attr('data-id', $(this).attr('data-id'));
        let deleteType = $(this).attr('data-type');
        let dataTableName = $(this).attr('data-dataTableName');
        
        let deleteItemApi, deleteMultipleItemApi = '';
        if (deleteType == 'employee'){
            deleteItemApi = deleteEmployeeApi;
            deleteMultipleItemApi = deleteMultipleEmployeeApi;
        }else  if (deleteType == 'student'){
            deleteItemApi = deleteEmployeeApi;
            deleteMultipleItemApi = deleteMultipleEmployeeApi;
        }else{
            deleteItemApi = deleteLeadApi;
            deleteMultipleItemApi = deleteMultipleLeadApi;
        }
        const btn = $(this);
        const idItem = btn.attr('data-id');
        const token = localStorage.getItem('jwt_token');
        let api = baseUrl;
        let arr_data = [];
        if(idItem == 0){
            $('#deleteItemModal').modal('hide');
            return
        }
        if (/^\d+$/.test(idItem)) {
            // Nếu là một số duy nhất
            api += deleteItemApi+idItem;
        } else if (/^\d+(,\d+)+$/.test(idItem)) {
            // Nếu là một chuỗi gồm nhiều số phân tách bởi dấu phẩy
            api += deleteMultipleItemApi;
            const arr = idItem.split(",");
            const arrNumbers = arr.map(Number);
            arr_data = arrNumbers;
        }
        
        btn.html('Đang xóa...');
        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            contentType: "application/json",
            data: JSON.stringify({'ids': arr_data}),
            success: function (res) {
                if (deleteType == 'employee'){
                    window.location.href = window.location.href;
                }else{
                    $(dataTableName).DataTable().ajax.reload();
                }

                btn.html('Xác nhận');
                if ($('#deleteItemModal').length) {
                    $('#deleteItemModal').modal('hide');
                    $('.modal-backdrop').remove();
                }
                if(res.code == 200){
                    $.notify(res.message, "success");
                    window.location.reload();
                } else {
                    $.notify(res.message, "error");
                }

            },
            error: function () {
                $.notify(res.message, "error");
            }
        });
    })
})
