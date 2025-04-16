import { baseUrl, deleteAcademicApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    // $(document).on('click', '.btn_delete_academic', (e)=>{
    //     const btn               = $(e.currentTarget);
    //     const idAcademicDelete  = btn.attr('data-id');
    //     const api               = baseUrl+deleteAcademicApi+idAcademicDelete;
    //     const token             = localStorage.getItem('jwt_token');
    //     btn.html('Đang xóa...');

    //     $.ajax({
    //         url: api,
    //         type: 'POST',
    //         headers: {
    //             'Authorization': `Bearer ${token}`
    //         },
    //         success: (res)=>{
    //             if(res.code == 422){
    //                 $.notify(res.message, "error");
    //             } else{
    //                 $.notify(res.message, "success");
    //                 setTimeout(function() {
    //                     window.location.reload();
    //                 }, 1000);
    //             }
    //             btn.html('Xác nhận');
    //         },
    //         error: (xhr, status, error)=>{
    //             console.log(xhr, status, error);
    //         }
    //     })
    // })
})
