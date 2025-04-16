import { baseUrl, createAcademicApi }       from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    var tableAcademic;
    var tableAcademicInit = function() {
        tableAcademic = new DataTable('#table_academic_terms', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            order: [[0, 'desc']],
            dom: "lrtip"
        });
    };

    // custome input search \\
    $('#search_academic_term').on('keyup', function() {
        tableAcademic.search(this.value).draw();
    });
    tableAcademicInit();

    $(document).on('click', '#academic_btn_submit', (e)=>{
        const btn              = $(e.currentTarget);
        const api              = baseUrl+createAcademicApi;
        const token            = localStorage.getItem('jwt_token');
        let academicName       = $('#academic_name').val();
        let academicFromYear   = $('#academic_from_year').val();
        let academicToYear     = $('#academic_to_year').val();
        let academicNote       = $('#academic_note').val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "name"      : academicName,
                "from_year" : academicFromYear,
                "to_year"   : academicToYear,
                "note"      : academicNote
            },
            success: function (res) {
                if(res.code == 422){
                    handleError('#academic_name', '.academic_name_wrapper', res.data.name);
                    handleError('#academic_from_year', '.academic_from_year_wrapper', res.data.from_year);
                    handleError('#academic_to_year', '.academic_to_year_wrapper', res.data.to_year);
                    handleError('#academic_note', '.academic_note_wrapper', res.data.note);
                } else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: function (xhr, status, error) {
                btn.html('Lưu');
                console.log(xhr.responseText);
            }
        })
    })
    handleRemoveError('.academic_name_wrapper', '#academic_name');
    handleRemoveError('.academic_from_year_wrapper', '#academic_from_year');
    handleRemoveError('.academic_to_year_wrapper', '#academic_to_year');
    handleRemoveError('.academic_note_wrapper', '#academic_note');

    // Giới hạn nhập cho input from (to) date \\
    $('#academic_from_year').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');

        if (value.length > 4) {
            value = value.substring(0, 4);
        }

        $(this).val(value);
    });

    $('#academic_to_year').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');

        if (value.length > 4) {
            value = value.substring(0, 4);
        }

        $(this).val(value);
    });

})
