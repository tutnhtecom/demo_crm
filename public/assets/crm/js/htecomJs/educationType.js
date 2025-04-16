import { baseUrl,
    educationTypeCreateApi,
    educationTypeUpdateApi,
    educationTypeDeleteApi
} from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError,handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    var tableEducationTypes;
    var dataEducationTypes = function() {
        tableEducationTypes = new DataTable('#table_education_types', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            // scrollX: true,
            dom: "lrtip"
        });
    };
    dataEducationTypes();

    $('#search-input-edutype').on('keyup', function() {
        tableEducationTypes.search(this.value).draw();
    });

    // Tạo mục trình dộ học vấn \\
    $(document).on('click', '.btn_create_edu_type', (e)=>{
        const btn = $(e.currentTarget);
        const api = baseUrl+educationTypeCreateApi;
        const token = localStorage.getItem('jwt_token');
        let name = $('#edu_create_name').val();
        btn.prop('disabled', true).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                name: name
            },
            success: (res) => {
                if (res.code == 422) {
                    handleError('#edu_create_name', '.edu_create_name_wrapper', res.data.name);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.prop('disabled', false).html('Lưu');
            },
            error: (error) => {
                console.error(error);
            }
        })
    })
    handleRemoveError('.edu_create_name_wrapper', '#edu_create_name');
    
    
    // Chỉnh sửa mục trình dộ học vấn \\
    $(document).on('click', '.icon_update_edu_type', (e)=>{
        const btn = $(e.currentTarget);
        const name = btn.attr('data-name');
        const id = btn.attr('data-edu-id');
        $('#edu_update_name').val(name);
        $('.btn_update_edu_type').attr('data-id', id);
    })
    $(document).on('click', '.btn_update_edu_type', (e)=>{
        const btn = $(e.currentTarget);
        const id = btn.attr('data-id');
        const api = baseUrl+educationTypeUpdateApi+id;
        const token = localStorage.getItem('jwt_token');
        let name = $('#edu_update_name').val();
        btn.prop('disabled', true).html('Đang lưu...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                name: name
            },
            success: (res) => {
                if (res.code == 422) {
                    handleError('#edu_update_name', '.edu_update_name_wrapper', res.data.name);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.prop('disabled', false).html('Lưu');
            },
            error: (error) => {
                console.error(error);
            }
        })
    })
    handleRemoveError('.edu_update_name_wrapper', '#edu_update_name');


    // Xóa mục trình dộ học vấn \\
    $(document).on('click', '.icon_delete_edu_type', (e)=>{
        const btn = $(e.currentTarget);
        const id = btn.attr('data-edu-id');
        $('.btn_delete_edu_type').attr('data-id', id);
    })
    $(document).on('click', '.btn_delete_edu_type', (e)=>{
        const btn = $(e.currentTarget);
        const id = btn.attr('data-id');
        const api = baseUrl+educationTypeDeleteApi+id;
        const token = localStorage.getItem('jwt_token');
        btn.prop('disabled', true).html('Đang xóa...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res) => {
                if (res.code == 422) {
                    console.log(res);
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                btn.prop('disabled', false).html('Xóa');
            },
            error: (error) => {
                console.error(error);
            }
        })
    })
});
