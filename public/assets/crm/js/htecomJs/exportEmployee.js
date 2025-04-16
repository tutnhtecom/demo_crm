import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { exportEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('#btn_export_employees').click(function(){
        const api = baseUrl+exportEmployeeApi;
        const token = localStorage.getItem('jwt_token');          
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var file_name = 'danh_sach_nhan_vien_' + d.getFullYear() +
        (month<10 ? '0' : '') + month +
        (day<10 ? '0' : '') + day;
        
        $.ajax({
            url: api,
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': 'Bearer '+token
            },
            success: function(res){
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(res);
                a.href = url;
                a.download = file_name;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function(error){
                // Handle the error here
            }
        });
    });
})