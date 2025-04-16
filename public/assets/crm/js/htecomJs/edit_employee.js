import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { editEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    $('.edit_employee_avatar').on('change', function(event) {
        const allowedExtensions = ['image/jpeg', 'image/png']; // Loại tệp hợp lệ
        const file = event.target.files[0]; // Lấy tệp người dùng chọn
    
        if (file) {
            if (!allowedExtensions.includes(file.type)) {
                alert('Vui lòng chọn tệp JPG hoặc PNG!');
                $(this).val(''); // Xóa giá trị của input nếu không hợp lệ
            } else {
                // console.log('Tệp hợp lệ:', file.name);
            }
        }
    });

    $(document).on('submit', '#edit-employee-form', (e) => {
        e.preventDefault();
        $('#edit_employee_btn_submit').html('Đang lưu...');
        const token = localStorage.getItem('jwt_token');
        const formData   = new FormData();
        const idEmployee = $('#edit_employee_btn_submit').data('id');
        const api        = baseUrl+editEmployeeApi+idEmployee;
        let fullName     = $('#edit_employee_fullName').val();
        let phone        = $('#edit_employee_phone').val();
        let email        = $('#edit_employee_email').val();
        let dateOfBirth  = formatDate($('#edit_employee_dateOfBirth').val()); 
        let role         = $('#edit_employee_role').val();
        let password     = $('#edit_employee_password').val();
        let file = $('.edit_employee_avatar')[0].files[0];

        let auto_send_mail = null;
        if ($('#auto_send_mail').is(":checked")) {                   
            auto_send_mail = 0;            
        } else {                        
            auto_send_mail = 1;
        }        
        
        let file_name = $('#select_email_template').val();
        let line_id_voip = $('#line_id_voip').val();
        
        formData.append('name', fullName);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('date_of_birth', dateOfBirth);
        formData.append('roles_id', role);
        formData.append('password', password);
        if(file != null){
            formData.append('image', file);
        }
        formData.append('auto_send_mail', auto_send_mail);
        formData.append('file_name', file_name);
        formData.append('line_id_voip', line_id_voip);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data:formData,
            processData: false,
            contentType: false,
            success: (res) => {
                if(res.code == 422){
                    handleError('#edit_employee_fullName', '.edit_employee_fullName_wrapper', res.data.name);
                    handleError('#edit_employee_phone', '.edit_employee_phone_wrapper', res.data.phone);
                    handleError('#edit_employee_password', '.edit_employee_password_wrapper', res.data.password);
                    
                    handleError('.edit_employee_role_wrapper .select2-selection', '.edit_employee_role_wrapper', res.data.roles_id);
                } else {                    
                    $.notify(res.message, "success");    
                    setTimeout(()=>{
                        window.location.href = baseUrl+'/crm/employees/detail/'+idEmployee;
                    }, 1500)
                }
                $('#edit_employee_btn_submit').html('Lưu thông tin');
            },
            error: (xhr, status, error) => {
                console.log(error);
            }
        })
    });
    handleRemoveError('.edit_employee_fullName_wrapper', '#edit_employee_fullName');
    handleRemoveError('.edit_employee_phone_wrapper', '#edit_employee_phone');
    handleRemoveError('.edit_employee_role_wrapper', '.select2-selection');
    handleRemoveError('.edit_employee_password_wrapper', '#edit_employee_password');
})