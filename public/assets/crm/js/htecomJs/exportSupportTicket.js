import { baseUrl, exportSupportTicketApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{

    $('#btn_export_ticket').on('click',()=>{
        const api = baseUrl+exportSupportTicketApi;
        const token = localStorage.getItem('jwt_token');
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var file_name = 'danh_sach_yeu_cau_ho_tro_' + d.getFullYear() +
        (month<10 ? '0' : '') + month +
        (day<10 ? '0' : '') + day;    

        $.ajax({
            url: api,
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res) => {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(res);
                a.href = url;
                a.download = file_name;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                console.log(res);
            },
            error: (error) => {
                console.error(error);
            }
        });
    })

});

