import { baseUrl,affiliateCreateSemestersApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate, handleError, handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(function() {
    $('#academy_name, #admission_year').on('change keyup', function() {
        let courseId = $('#academy_name').val();
        let year = $('#admission_year').val();

        if (courseId && year && !isNaN(year)) {
            year = parseInt(year);
            let semesterText = '';
            
            switch(courseId) {
                case '1': // Khóa 1
                    semesterText = `Học kỳ 2 năm học ${year-1} - ${year}`;
                    break;
                case '2': // Khóa 2
                    semesterText = `Học kỳ 3 năm học ${year-1} - ${year}`;
                    break;
                case '3': // Khóa 3
                    semesterText = `Học kỳ 1 năm học ${year} - ${year+1}`;
                    break;
                case '4': // Khóa 4
                    semesterText = `Học kỳ 2 năm học ${year} - ${year+1}`;
                    break;
                default:
                    semesterText = '';
            }
            
            $('#admission_semesters').val(semesterText);
        } else {
            $('#admission_semesters').val('');
        }
    });

    $(document).on('click', '#academy_btn_submit', (e)=>{
        const btn               = $(e.currentTarget);
        const api               = baseUrl+affiliateCreateSemestersApi;
        const token             = localStorage.getItem('jwt_token');
        const academy_id        = $('#academy_name').val();
        const semesters_year    = $('#admission_year').val();
        const semesters_name    = $('#admission_semesters').val();
        const admission_date    = formatDate($('#academy_opening_day').val());
        const types             = 0;
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "academy_id"        : academy_id,
                "semesters_year"    : semesters_year,
                "semesters_name"    : semesters_name,        
                "admission_date"    : admission_date,
                "types"             : types
            },
            success:(res)=>{
                if(res.code == 422){
                    console.log(res);
                    handleError('#admission_year', '.admission_year_wrapper', res.data.semesters_year);
                    handleError('#academy_opening_day', '.academy_opening_day_wrapper', res.data.admission_date);

                    if(res.data.semesters_name['0']){
                        $.notify(res.data.semesters_name['0'], "error"); 
                    }
                } else {
                    $.notify(res.message, "success"); 
                    setTimeout(()=>{
                        window.location.reload();
                    },1500);
                }
                btn.html('Lưu');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    });

    handleRemoveError('.admission_year_wrapper', '#admission_year');
    handleRemoveError('.academy_opening_day_wrapper', '#academy_opening_day')
});