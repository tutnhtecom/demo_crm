$(document).ready(()=>{
    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#tiny',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
            setup: function (editor) {
                editor.on('input focus', function () {
                    const errorElement = document.querySelector('.send_noti_content_employee_wrapper .error-input');
                    if (errorElement) {
                        errorElement.classList.remove('show-error');
                    }
                });
            }
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#create_lead_note',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#edit_lead_note',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
        });
    });

    TI_Util.onDOMContentLoaded(()=> {
        tinymce.init({
            selector: 'textarea#create_noti_content',
            menubar: false,
            plugins: 'image lists link anchor charmap',
            toolbar: 'bold italic underline strike bullist numlist | link image charmap',
            setup: function (editor) {
                editor.on('input focus', function () {
                    const errorElement = document.querySelector('.create_noti_content_wrapper .error-input');
                    if (errorElement) {
                        errorElement.classList.remove('show-error');
                    }
                });
            }
        });
    });
    var tableEmployees;

    var dataTableInit = function() {
        tableEmployees = new DataTable('#table-employees', {
            columns: [
                {
                    data: 'sorting',
                    orderable: false,
                    render: DataTable.render.select(),
                },
                { data: 'id' },
                { data: 'name' },
                { data: 'contact' },
                { data: 'role' },
                { data: 'kpi_price' },
                { data: 'kpi_qty' },
                { data: 'total_price' },
                { data: 'total_qty' },
                { data: 'actions' }
            ],
            layout: {
                // topStart: 'info',
                topEnd:{
                    buttons: [
                        {
                            text: 'Xoá',
                            className: 'crm_employees_delete',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_detele_ids = [];
                                    let selected_data = selected_rows.data();
                                    selected_data.each(function(rowData) {
                                        arr_detele_ids.push(rowData.id);
                                    });
                                    let data_id = arr_detele_ids.join(',');
                                    let firstTenItems = arr_detele_ids.slice(0, 10);
                                    let str = firstTenItems.join(',');
                                    if (arr_detele_ids.length > 10) {
                                        str += '...';
                                    }
                                    $('#btn_delete_item').attr('data-id', data_id);
                                    $('#deleteItemModal').modal('show');
                                    $('#deleteItemModal').find('.notice-text').html('<span class="fs-10 fs-md-5 fw-normal">Xác nhận xoá các bản ghi có ID:</span> <span>'+str+'</span>');
                                }else{
                                    $('#deleteItemModal').modal('show');
                                    $('#deleteItemModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        },
                        {
                            text: 'Tạo nhóm',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_group_ids = [];
                                    let selected_data = selected_rows.data();
                                    selected_data.each(function(rowData) {
                                        arr_group_ids.push(rowData.id);
                                    });
                                    let firstTenItems = arr_group_ids.slice(0, 10);
                                    let str = firstTenItems.join(',');
                                    if (arr_group_ids.length > 10) {
                                        str += '...';
                                    }
                                    $('#groupLeadsModal').modal('show');
                                    $('#btn_group_leads_submit').attr('data-ids', arr_group_ids.join(','))
                                }else{
                                    $('#deleteItemModal').modal('show');
                                    $('#deleteItemModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        }
                    ]
                },
                bottomStart: 'pageLength',
                bottomEnd: 'info',
                bottom3: 'paging'
            },
            order: [[1, 'desc']],
            autoWidth: true,
            stateSave: false,
            select: {
                style: 'multi',
                selector: 'td:first-child',
                headerCheckbox: 'select-page'
            },
        });
    };

    $('.col_progress_price').each(function() {
        let rawData = $(this).find('.percent_price').text();
        let ratePrice = parseFloat(rawData.replace('%', '').trim());

        if (!isNaN(ratePrice)) {
            $(this).find('div[role="progressbar"]').css('width', ratePrice + '%');
            $(this).find('div[role="progressbar"]').attr('aria-valuenow', ratePrice);
        }
    });

    $('.col_progress_student').each(function() {
        let rawData = $(this).find('.percent_student').text();
        let ratePrice = parseFloat(rawData.replace('%', '').trim());

        if (!isNaN(ratePrice)) {
            $(this).find('div[role="progressbar"]').css('width', ratePrice + '%');
            $(this).find('div[role="progressbar"]').attr('aria-valuenow', ratePrice);
        }
    });

    // custome input search \\
    $('#search_employees').on('input', function() {
        tableEmployees.search(this.value).draw();
    });
    dataTableInit();

    // custome upload file \\
    $(document).on('click', '[data-file-trigger]', function (e) {
        e.preventDefault();

        var file_elm_id = $(this).attr('data-file-trigger');
        $('#' + file_elm_id).click();

        $('#' + file_elm_id).on('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                var $img = $('<img>', {
                    src: e.target.result,
                    class: 'w-175px h-175px object-cover rounded position-absolute',
                    alt: 'preview'
                });

                $('[data-file-trigger="' + file_elm_id + '"]').html($img);

                // Thêm các nút hành động cạnh ảnh
                var $actions = $('<div>', {
                    class: 'position-absolute translate-middle-y d-flex gap-2 justify-content-center',
                    css: { bottom: '-60px' }
                });

                // Nút chỉnh sửa
                var $edit_btn = $('<button>', {
                    type: 'button',
                    'data-file-trigger-id': file_elm_id,
                    'data-action': 'edit',
                    class: 'btn btn-ghost p-2 btn-sm',
                    html: '<i class="fas fa-edit text-gray-600 fs-4"></i>'
                });

                // Nút xoá
                var $remove_btn = $('<button>', {
                    type: 'button',
                    'data-file-trigger-id': file_elm_id,
                    'data-action': 'delete',
                    class: 'btn btn-ghost p-2 btn-sm',
                    html: '<i class="fas fa-trash text-gray-600 fs-4"></i>'
                });

                $actions.append($edit_btn).append($remove_btn);
                $('[data-file-trigger="' + file_elm_id + '"]').append($actions);
            };

            reader.readAsDataURL(file);
        });
    });

    // On document ready
    TI_Util.onDOMContentLoaded(function () {
        $('#job-calendar-tab').one('click', function() {
            $(this).click();
            $('#ti_calendar_app').data('calendar').render();
        })
        // initLeadStatusSelect();
        // Init tinymce in modal
        tinymce.init({
            selector: 'textarea#job_description',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
        });
    });

});
