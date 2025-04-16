import { baseUrl } from '/assets/crm/js/htecomJs/variableApi.js';
import { createEmployeeApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{

    $('.create_employee_avatar').on('change', function(event) {
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
    
    $(document).on('submit', '#create-employee-form', (e) => {
        e.preventDefault();
        $('#create_employee_btn_submit').html('Đang tạo...');
        const token = localStorage.getItem('jwt_token');
        const api = baseUrl + createEmployeeApi;
    
        const formData = new FormData();
        let full_name = $('#create_employee_fullName').val();
        let phone = $('#create_employee_phone').val();
        let email = $('#create_employee_email').val();
        let dateOfBirth = formatDate($('#create_employee_dateOfBirth').val());
        let roleId = $('#create_employee_role').val();
        let file = $('.create_employee_avatar')[0].files[0];
    
        let auto_send_mail = null;
        if ($('#auto_send_mail').is(":checked")) {                   
            auto_send_mail = 0;            
        } else {                        
            auto_send_mail = 1;
        }        
        
        let file_name = $('#select_email_template').val();
        let line_id_voip = $('#line_id_voip').val();
        
        

        // Nếu có file, kiểm tra MIME type
        if (file) {
            const allowedMimeTypes = [
                'image/jpeg',      // .jpg
                'image/svg+xml',   // .svg
                'image/png'        // .png
            ];
            const mimeType = file.type;
    
            if (!allowedMimeTypes.includes(mimeType)) {
                $.notify("Chỉ chấp nhận file ảnh .jpg, .svg hoặc .png", "error");
                $('#create_employee_btn_submit').html('Tạo tài khoản');
                return;
            }
        }
    
        // Thêm dữ liệu vào FormData
        formData.append('name', full_name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('date_of_birth', dateOfBirth);
        formData.append('roles_id', roleId);
        formData.append('image', file);
        formData.append('auto_send_mail', auto_send_mail);
        formData.append('file_name', file_name);
        formData.append('line_id_voip', line_id_voip);

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {                
                if (res.code == 422) {
                    handleError('#create_employee_fullName', '.create_employee_fullName_wrapper', res.data.name);
                    handleError('#create_employee_phone', '.create_employee_phone_wrapper', res.data.phone);
                    handleError('#create_employee_email', '.create_employee_email_wrapper', res.data.email);
                    handleError('.create_employee_role_wrapper .select2-selection', '.create_employee_role_wrapper', res.data.roles_id);
                    handleError('#create_employee_dateOfBirth', '.create_employee_dateOfBirth_wrapper', res.data.date_of_birth);
                    $('#create_employee_btn_submit').html('Tạo tài khoản');
                } else {
                    $('#create_employee_fullName').val('');
                    $('#create_employee_phone').val('');
                    $('#create_employee_email').val('');
                    $('#create_employee_dateOfBirth').val('');
                    $('#create_employee_role').val('').trigger('change');
                    $.notify(res.message, "success");                       
                    window.location.href = baseUrl + '/crm/employees';
                    $('#create_employee_btn_submit').html('Tạo tài khoản');
                }
            },
            error: (xhr, status, error) => {                
                $('#create_employee_btn_submit').html('Tạo tài khoản');
            }
        });
    });
    handleRemoveError('.create_employee_fullName_wrapper', '#create_employee_fullName');
    handleRemoveError('.create_employee_phone_wrapper', '#create_employee_phone');
    handleRemoveError('.create_employee_email_wrapper', '#create_employee_email');
    handleRemoveError('.create_employee_role_wrapper', '.select2-selection');
    handleRemoveError('.create_employee_dateOfBirth_wrapper', '#create_employee_dateOfBirth');
})