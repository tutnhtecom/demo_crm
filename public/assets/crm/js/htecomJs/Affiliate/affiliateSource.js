import {
    baseUrl,
    createAffiliateApi,
    updateAffiliateApi,
    createSourceRateApi,
    deleteSourceRateApi,
    leadsBySourcesApi,
    leadsBySourcesApiAjax
} from '/assets/crm/js/htecomJs/variableApi.js';
import { formatDate } from '/assets/crm/js/htecomJs/lead.js';
import { handleError, handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';


$(document).ready(() => {    
    var tableLeads;
    var tableAffiliate;
    var selectedValue;
    let loading_html = `<div class="hte_loading_wrapper">
        <div class="hte_spanner show">
            <div class="hte_loader"></div>
        </div>
    </div>` ;
    var dataAffiliateSourcesInit = function () {
        tableAffiliate = new DataTable('#affiliate_sources_table', {
            layout: {
                topStart: 'info',
                bottom: 'paging',
                bottomStart: null,
                bottomEnd: null
            },
            dom: "lrtip",
        });
    };
    dataAffiliateSourcesInit();

    $('#search-dvlk').on('keyup', function() {
        tableAffiliate.search(this.value).draw();
    });

    var dataTableInit = function () {
        var tableLeads;
        if ($.fn.dataTable.isDataTable('#table_leads_by_sources')) {
            // tableLeads = $('#table_leads_by_sources').DataTable();
            $('#table_leads_by_sources').DataTable().clear().destroy();
        }
        const dataID = $('#leads_by_sources').attr('data-id');
        const api = baseUrl + leadsBySourcesApiAjax + dataID;
        const ajaxUrl = selectedValue ? api : "";
        const token = localStorage.getItem('jwt_token');
        tableLeads = $('#table_leads_by_sources').DataTable({
            ajax: {
                url: ajaxUrl,
                type: "POST",
                data: function (d) {
                    d.academic_terms_id = selectedValue;
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
            },
            autoWidth: true,
            searching: false,
            ordering: false,
            order: [[1, 'asc']],
        });
    };

    dataTableInit();

    var tabledssv;
    var tabledssvInit = function() {
        tabledssv = new DataTable('.table_dssv', {
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
    // $('#search_dssv_term').on('keyup', function() {
    //     tabledssv.search(this.value).draw();
    // });
    tabledssvInit();

    // Add infomation employees \\
    let countEmployee = 2;
    $('#add_employee_key_contact').on('click', function () {
        const $dynamicFields = $('.employees_key_contact_wrapper'); // Lấy phần tử dynamic-fields
        const recordCount = $dynamicFields.children().length;

        const newRecord = `
            <div class="row mb-3 employee_record">
                <label for="" class="form-label d-flex align-items-center gap-2" style="font-style:italic;text-decoration:underline;">
                    Thông tin nhân sự đầu mối ${countEmployee}
                    <button type="button" class="btn btn-ghost p-1 delete_em_key_contact">
                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                    </button>
                </label>
                <br>
                <div class="col-6 employee_fullName_wrapper mb-3">
                    <label for="" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" id="" name="employees[${recordCount}][name]" placeholder="Nhập" class="form-control" required>
                </div>
                <div class="col-6 employee_position_wrapper mb-3">
                    <label for="" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                    <input type="text" id="" name="employees[${recordCount}][position]" placeholder="Nhập" class="form-control" required>
                </div>
                <div class="col-6 employee_email_wrapper mb-3">
                    <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" id="" name="employees[${recordCount}][email]" placeholder="Nhập" class="form-control" required>
                </div>
                <div class="col-6 employee_phone_wrapper mb-3">
                    <label for="" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" id="" name="employees[${recordCount}][phone]" placeholder="Nhập" class="form-control" required>
                </div>
            </div>
        `;

        $dynamicFields.append(newRecord); // Thêm bản ghi mới vào dynamic-fields
        countEmployee++;
    })

    $('.employees_key_contact_wrapper').on('click', '.delete_em_key_contact', function () {
        $(this).closest('.employee_record').remove(); // Xóa bản ghi hiện tại
        updateLabels(); // Cập nhật lại thứ tự
    });

    // create affiliate sources \\
    $(document).on('click', '#affiliate_btn_create', (e) => {
        const createForm = $('#create_affiliate_form')[0];
        if (createForm.checkValidity()) {
            const btn = $(e.currentTarget);
            const api = baseUrl + createAffiliateApi;
            const token = localStorage.getItem('jwt_token');
            let affiliate_sources = $('#affiliate_sources').val();
            let affiliate_name = $('#affiliate_name').val();
            let affiliate_location = $('#affiliate_location').val();
            let affiliate_manager_name = $('#affiliate_manager_name').val();
            let affiliate_manager_position = $('#affiliate_manager_position').val();
            let affiliate_manager_email = $('#affiliate_manager_email').val();
            let affiliate_manager_phone = $('#affiliate_manager_phone').val();
            let employeeData = getEmployeeData();
            btn.html('Đang lưu...');

            let data = {
                "sources_types": affiliate_sources,
                "name": affiliate_name,
                "location_name": affiliate_location,
                "manager": [
                    {
                        "name": affiliate_manager_name,
                        "positions": affiliate_manager_position,
                        "email": affiliate_manager_email,
                        "phone": affiliate_manager_phone
                    }
                ],
                "employees": employeeData
            }

            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: data,
                success: (res) => {
                    if (res.code == 422) {
                        handleError('#affiliate_name', '.affiliate_name_wrapper', res.data.name);
                    } else {
                        $.notify(res.message, "success");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                    btn.html('Lưu');
                },
                error: (err) => {
                    console.log(err);
                }
            })
        } else {
            createForm.reportValidity();
        }

    })
    // Update thông tin DVLK
    $(document).on('click', '#affiliate_btn_update', function (e) {
        const updateForm = $('#update-affiliate-info')[0];
        if (updateForm.checkValidity()) {
            e.preventDefault();
            const formData = $('form[action="update-affiliate-info"]').serializeArray();
            const data_update = {};
            formData.forEach(field => {
                if (data_update[field.name]) {
                    if (!Array.isArray(data_update[field.name])) {
                        data_update[field.name] = [data_update[field.name]];
                    }
                    data_update[field.name].push(field.value);
                } else {
                    data_update[field.name] = field.value;
                }
            });
            data_update.affiliate_sources = $('#affiliate_sources').val();
            const sourceId = $(this).attr('data-id');
            const btn = $(e.currentTarget);
            const api = baseUrl + updateAffiliateApi + '/' + sourceId;
            const token = localStorage.getItem('jwt_token');
            let employeeData = getEmployeeData();
            btn.html('Đang lưu...');

            let data = {
                "sources_types": data_update.affiliate_sources,
                "name": data_update.affiliate_name,
                "location_name": data_update.affiliate_location,
                "sources_manager_name": [
                    {
                        "name": data_update.affiliate_manager_name,
                        "positions": data_update.affiliate_manager_position,
                        "email": data_update.affiliate_manager_email,
                        "phone": data_update.affiliate_manager_phone
                    }
                ],
                "sources_employees_name": employeeData
            }
            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: data,
                success: (res) => {
                    if (res.code == 422) {
                        handleError('#affiliate_name', '.affiliate_name_wrapper', res.data.name);
                    } else {
                        $.notify(res.message, "success");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1200);
                    }
                    btn.html('Lưu');
                },
                error: (err) => {
                    console.log(err);
                }
            })
        } else {
            updateForm.reportValidity();
        }
    })
    // Xoá khoản thu
    $(document).on('click', '.btn_delete_sources_rate', function (e) {
        $('#btn_delete_sources_rate').attr('data-id', $(this).attr('data-id'));
        $('#sources_documents_id').val($(this).attr('data-id'));
    });
    $(document).on('click', '#btn_delete_sources_rate', function (e) {
        const dataID = $(e.currentTarget).attr('data-id');
        const api = baseUrl + deleteSourceRateApi + dataID;
        const token = localStorage.getItem('jwt_token');
        $(e.currentTarget).html('Đang xóa...');

        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: (res) => {
                if (res.code == 422) {
                    $.notify(res.message, "error");
                } else {
                    $.notify(res.message, "success");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1200);
                }
                $(e.currentTarget).html('Xác nhận');
            },
            error: (err) => {
                console.log(err);
            }
        })
    })
    // Thêm Khoản chi
    $(document).on('change', 'input[name="enable_dktt"]', function () {
        let updateForm = $('#form_create_sources_rate')[0];
        if ($(this).val() === "1") {
            $(updateForm).find('input').attr('required', 'required');
            $('.hte-form-wrapper').show();
            $('.academic_and_semesters').show();
        } else {
            $(updateForm).find('input').removeAttr('required');
            $('.hte-form-wrapper').hide();
            $('.academic_and_semesters').hide();
        }
    });
    $(document).on('click', '.btn_add_sources_rate', function (e) {
        $('#btn_create_sources_rate').attr('data-id', $(this).attr('data-id'));
        $('#sources_documents_id').val($(this).attr('data-id'));
    });

    $('#is_single_check').on('change', function () {
        if ($(this).is(':checked')) {
            $('.semesterSelectWrapper').show(); // Hiển thị lại phần tử
        } else {
            $('.semesterSelectWrapper').hide(); // Ẩn phần tử

        }
    });

    $('#payment_manager_price').on('input', function () {
        let value = $(this).val().replace(/\D/g, ""); // Xóa tất cả ký tự không phải số
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Thêm dấu . mỗi 3 chữ số
        $(this).val(value);
    });

    $(document).on('click', '#btn_create_sources_rate', function (e) {        
        const updateForm = $('#form_create_sources_rate')[0];
        const documentId = $(this).attr('data-id');
        if (updateForm.checkValidity()) {
            e.preventDefault();
            // const formData = $('#form_create_sources_rate').serializeArray().filter(field => field.name !== 'is_single');
            const formData = $('#form_create_sources_rate').serializeArray()
                            .filter(field => field.name !== 'is_single') // Loại bỏ 'is_single'
                            .map(field => {
                                if (field.name === 'payment_manager_price') {
                                    return { name: field.name, value: field.value.replace(/\./g, '') }; // Xóa dấu `.`
                                }
                                return field;
                            });
            const isSingleChecked = $('#is_single_check').is(':checked');
            const data_update = {};
            data_update['is_single'] = isSingleChecked ? 1 : 0; // Gán 1 nếu checked, 0 nếu không
            formData.forEach(field => {
                if (data_update[field.name]) {
                    if (!Array.isArray(data_update[field.name])) {
                        data_update[field.name] = [data_update[field.name]];
                    }
                    data_update[field.name].push(field.value);
                } else {
                    data_update[field.name] = field.value;
                }
            });

            const sourceId = $(this).attr('data-id');
            const btn = $(e.currentTarget);
            const api = baseUrl + createSourceRateApi;
            const token = localStorage.getItem('jwt_token');
            let employeeData = getEmployeeData();
            btn.html('Đang lưu...');
            let data = {};
            if ($('input[name="enable_dktt"]:checked').val() != 1) {
                data = {
                    "sources_id": data_update.sources_id,
                    "sources_documents_id": data_update.sources_documents_id,
                    "expense_name": data_update.expense_name,
                    "payment_note": data_update.payment_note,
                    "academic_terms_id": data_update.academic_terms_id,
                    "semesters_id": data_update.semesters_id,
                    "payment_units": data_update.payment_units,
                }
            } else {
                data = data_update
            }
            
            $.ajax({
                url: api,
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                data: data,
                success: (res) => {
                    if (res.code == 422) {
                        handleError('#expense_name', '.expense_name_wrapper', res.data.expense_name);
                    } else {
                        $.notify(res.message, "success");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1200);
                    }
                    btn.html('Lưu');
                },
                error: (err) => {
                    console.log(err);
                }
            })
        } else {
            updateForm.reportValidity();
        }
    })

    var beginLoadData = function () {        
        var tableLeads;
        if ($.fn.dataTable.isDataTable('#table_leads_by_sources')) {            
            $('#table_leads_by_sources').DataTable().clear().destroy();
        }
        const dataID = $('#leads_by_sources').attr('data-id');
        const api = baseUrl + leadsBySourcesApiAjax + dataID;
        // const ajaxUrl = selectedValue ? api : "";       
        // const ajaxUrl = baseUrl + leadsBySourcesApiAjax + dataID;
        const token = localStorage.getItem('jwt_token');
        tableLeads = $('#table_leads_by_sources').DataTable({
            ajax: {
                url: api,
                type: "POST",                
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },                
            },
            autoWidth: true,
            searching: false,
            ordering: false,
            order: [[1, 'asc']],
        });
    };
    $(document).on('change', '#academic_terms_leads', function (e) {
        $('#custom-fields').prepend(loading_html);     
        const types = 1; 
        selectedValue = $(this).val();
        const dataID = $('#leads_by_sources').attr('data-id');
        const api = baseUrl + leadsBySourcesApi + dataID;
        const apiAjax = baseUrl + leadsBySourcesApiAjax + dataID;
        const token = localStorage.getItem('jwt_token');
        get_students_list(api, token, selectedValue, types);        
    });
    function render_leads_table(response, types) {
        if(response && response.data) {
            const semesters = response.academic_list.semesters;
            let theadHtml = '';
            let firstRow = '<tr class="text-white text-nowrap fs-5 text-center">';
            let secondRow = '<tr class="text-white text-nowrap fs-5 text-center">';
            firstRow += `<th class="align-middle text-center" rowspan="2">Họ tên</th>`;
            firstRow += `<th class="align-middle text-center" rowspan="2">Mã số sinh viên</th>`;
            firstRow += `<th class="align-middle text-center" rowspan="2">Ngành học</th>`;
            for (let i = 0; i < semesters.length; i += 3) {
                // Nhóm 3 học kỳ
                const group = semesters.slice(i, i + 3);
                // Tạo cột năm học cho hàng đầu tiên
                const fromYear = group[0].from_year;
                const toYear = group[group.length - 1].to_year;
                firstRow += `<th class="align-middle text-center" colspan="3">${fromYear} - ${toYear}</th>`;

                // Tạo các cột học kỳ cho hàng thứ hai
                group.forEach(item => {
                    secondRow += `<th class="align-middle text-center">${item.name}</th>`;
                });
            }
            firstRow += '</tr>';
            secondRow += '</tr>';
            theadHtml += firstRow + secondRow;        
            $('#table_leads_by_sources thead').html(theadHtml);
            switch (types) {
                case 1:
                    dataTableInit();
                    break;
                case 0: 
                    beginLoadData();
                    break;
                default:
                    break;
            }
        } 
            
    }
    // Cập nhật lại thứ tự (label) sau khi xóa
    function updateLabels() {
        countEmployee = 1; // Đặt lại bộ đếm
        $('.employee_record').each(function (index) {
            const label = $(this).find('label').first();

            if (index === 0) {
                // Bản ghi đầu tiên không có nút xóa
                label.html(`Thông tin nhân sự đầu mối ${countEmployee}`);
            } else {
                // Các bản ghi khác có nút xóa
                label.html(`
                    Thông tin nhân sự đầu mối ${countEmployee}
                    <button type="button" class="btn btn-ghost p-1 delete_em_key_contact">
                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                    </button>
                `);
            }
            countEmployee++;
        });
    }
    function getEmployeeData() {
        const employees = []; // Tạo mảng để chứa dữ liệu nhân sự
        $('.employee_record').each(function () {
            // Lấy dữ liệu từ các trường trong employee_record hiện tại
            const name = $(this).find('input[name$="[name]"]').val();
            const position = $(this).find('input[name$="[position]"]').val();
            const email = $(this).find('input[name$="[email]"]').val();
            const phone = $(this).find('input[name$="[phone]"]').val();

            // Thêm nhân sự vào mảng dưới dạng đối tượng
            employees.push({
                name: name,
                positions: position,
                email: email,
                phone: phone
            });
        });

        return employees; // Trả về mảng JSON
    }
    //Ajax danh sách sinh viên theo đơn vị liên kết
    //Sau khi chọn niên khoá
    function get_students_list(api, token, selectedValue, types) {   
        let data =  null;
        if(types == 1) {
            data = {
                "academic_terms_id": selectedValue
            }
        }
        $.ajax({
            url: api,
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: data,
            success: (response) => {                
                if (response.code == 422) {
                    $.notify(response.message, "error");
                } else {
                    render_leads_table(response, types);
                }
            },
            error: (err) => {
                console.log(err);
            },
            complete: () => {
                $('.hte_loading_wrapper').remove();
            }
        })
    }
    // Danh sach sinh viên click
    $(document).on('click', '#leads_by_sources', function(e){
        const dataID = $('#leads_by_sources').attr('data-id');
        const api = baseUrl + leadsBySourcesApi + dataID;
        const apiAjax = baseUrl + leadsBySourcesApiAjax + dataID;
        const token = localStorage.getItem('jwt_token');
        const types = 0;
        get_students_list(api, token, null, types);
    })
})
