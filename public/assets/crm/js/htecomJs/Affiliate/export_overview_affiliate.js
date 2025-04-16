import { baseUrl, exportOverviewSourcesApi, exportDetailsSourcesApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $(document).on('click', '#btn_export_overview', function(){           
        let api = baseUrl+exportOverviewSourcesApi;
        const token = localStorage.getItem('jwt_token');        
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var file_name = 'danh_sach_tong_quan_DVLK' + d.getFullYear() +
        (month<10 ? '0' : '') + month +
        (day<10 ? '0' : '') + day;
        $.ajax({
            url: api,
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': 'Bearer '+token
            },
            // data: data,
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

    $(document).on('click', '#btn_export_details', function(){           
        let btn = document.getElementById("btn_export_details");
        let id = btn.getAttribute("data-id");
        let api = baseUrl+exportDetailsSourcesApi+id;
        const token = localStorage.getItem('jwt_token');        
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var file_name = 'danh_sach_tong_quan_DVLK' + d.getFullYear() +
        (month<10 ? '0' : '') + month +
        (day<10 ? '0' : '') + day;
        $.ajax({
            url: api,
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': 'Bearer '+token
            },
            // data: data,
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

