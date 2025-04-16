import { baseUrl, getTasksForEmployee } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    let idEmployee = $('.role_employee').attr('data-employee-id');
    const token = localStorage.getItem('jwt_token');
    const api = baseUrl+getTasksForEmployee+idEmployee;

    if(idEmployee){
        $.ajax({
            url: api,
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res) => {
                if (res.code == 200) {
                    let $item = `<ul>`;
                    for (let i = 0; i < res.data['tasks'].length; i++) {
                        let fromDate = res.data['tasks'][i].from_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1");
                        let toDate = res.data['tasks'][i].to_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1");
                        if(res.data['tasks'][i].status !== 2){
                            $item += `<li class="mb-2">${res.data['tasks'][i].name} - Từ ngày: ${fromDate} đến ${toDate}</li>`;
                        }
                    }
                    $item += `</ul>`;
                    $('.list_tasks_for_employee').html($item); // Chèn danh sách vào container
                } else {
                    $.notify(res.message, "error");
                }
            },
            error: (res)=>{
                console.log(res);
            }
        })
    }
})