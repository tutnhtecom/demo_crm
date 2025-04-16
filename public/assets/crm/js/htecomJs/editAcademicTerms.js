import { baseUrl, editAcademicApi }       from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError, handleRemoveError }   from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    let idAcademic;
    $(document).on('click', '.academic_btn_edit', (e)=>{
        const btn              = $(e.currentTarget);
        idAcademic             = btn.attr('data-id');
        const api              = baseUrl+editAcademicApi+idAcademic;
        const token            = localStorage.getItem('jwt_token');
        let academicName       = $('#academic_name_'+idAcademic).val();
        let academicFromYear   = $('#academic_from_year_'+idAcademic).val();
        let academicToYear     = $('#academic_to_year_'+idAcademic).val();
        let academicNote       = $('#academic_note_'+idAcademic).val();
        btn.html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data:{
                "name"      : academicName,
                "from_year" : academicFromYear,
                "to_year"   : academicToYear,
                "note"      : academicNote
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#academic_name_'+idAcademic, '.academic_name_wrapper_'+idAcademic, res.data.name);
                    handleError('#academic_from_year_'+idAcademic, '.academic_from_year_wrapper_'+idAcademic, res.data.from_year);
                    handleError('#academic_to_year_'+idAcademic, '.academic_to_year_wrapper_'+idAcademic, res.data.to_year);
                    handleError('#academic_note_'+idAcademic, '.academic_note_wrapper_'+idAcademic, res.data.note);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.html('Lưu');
            },
            error: (res) => {
                console.log(res);
            }
        })
    })

    $(document).on('click', '.academic_name_wrapper_edit', (e)=>{
        const id = $(e.currentTarget).attr('data-id');
        $('.academic_name_wrapper_'+id).find('.error-input').removeClass('show-error').html('');
        $('.academic_name_wrapper_'+id).find('#academic_name_'+id).removeClass('border-error');
    })

    $(document).on('click', '.academic_from_year_wrapper_edit', (e)=>{
        const id = $(e.currentTarget).attr('data-id');
        $('.academic_from_year_wrapper_'+id).find('.error-input').removeClass('show-error').html('');
        $('.academic_from_year_wrapper_'+id).find('#academic_from_year_'+id).removeClass('border-error');
    })

    $(document).on('click', '.academic_to_year_wrapper_edit', (e)=>{
        const id = $(e.currentTarget).attr('data-id');
        $('.academic_to_year_wrapper_'+id).find('.error-input').removeClass('show-error').html('');
        $('.academic_to_year_wrapper_'+id).find('#academic_to_year_'+id).removeClass('border-error');
    })

    $(document).on('click', '.academic_note_wrapper_edit', (e)=>{
        const id = $(e.currentTarget).attr('data-id');
        $('.academic_note_wrapper_'+id).find('.error-input').removeClass('show-error').html('');
        $('.academic_note_wrapper_'+id).find('#academic_note_'+id).removeClass('border-error');
    })

})
