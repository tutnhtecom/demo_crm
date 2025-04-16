import { baseUrl, createSemestersApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $(document).on('click', '#semesters_btn_submit', (e)=>{
        const btn = $(e.currentTarget);
        const api = baseUrl+createSemestersApi;
        const token = localStorage.getItem('jwt_token');

        let semesterName = $('#semesters_name').val();
        let semesterStartDate = formatDate($('#semesters_from_year').val());
        let semesterEndDate = formatDate($('#semesters_to_year').val());
        let semesterAcademic = $('#semesters_academic').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"                  : semesterName,
                "from_date"             : semesterStartDate,
                "to_date"               : semesterEndDate,
                "academic_terms_name"   : semesterAcademic
            },
            success: (res) => {
                if(res.code == 422){
                    if(res.data.name != null){
                        $.notify(res.data.name, "error");
                    }
                    if(res.data.academic_terms_name != null){
                        $.notify(res.data.academic_terms_name, "error");
                    }
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: (error) => {
                console.log(error);
            }
        })
    })
})
