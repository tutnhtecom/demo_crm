import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { changeLeadToStudentApi } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    $('.toggle__input').on('change', function () {
        const api   = baseUrl+changeLeadToStudentApi;
        const token = localStorage.getItem('jwt_token');
        if ($(this).is(':checked')) {
            // var itemId = $(this).data('id');

            var itemObject = $(this).data('object');
            var dateOfBirth = itemObject.date_of_birth;
            var dateParts = dateOfBirth.split('-');
            var formattedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0];
            itemObject.date_of_birth = formattedDate;

            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer'+ token
                },
                data: itemObject,
                success: function (res) {
                    if(res.code == 200){
                        $.notify(res.message, "success");
                    } else {
                        $.notify(res.message, "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
            
        }
    });
})