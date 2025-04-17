import { baseUrl, supportGetListApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { createSupportRequestApi } from '/assets/crm/js/htecomJs/variableApi.js';
import { handleError } from '/assets/crm/js/htecomJs/lead.js';
import { handleRemoveError } from '/assets/crm/js/htecomJs/lead.js';

$(document).ready(()=>{
    TI_Util.on(document.body, '[data-ti-button-action="row-remove"]', 'click', function (e) {
        e.preventDefault();

        const row = this.closest('tr');

        if (!row) {
            return;
        }

        const confirmMessage = this.getAttribute("data-ti-row-confirm-message");
        const confirm = this.getAttribute("data-ti-row-confirm") === "true";

        if (confirm) {
            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
            Swal.fire({
                title: confirmMessage ? confirmMessage : "Are you sure to remove ?",
                iconHtml: "<img src='assets/media/svg/crm/danger-triange.svg' />",
                buttonsStyling: true,
                confirmButtonText: "Xác nhận",
                cancelButtonText: "Hủy",
                showCancelButton: true,
                showCloseButton: true,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                    icon: "border-0",
                    title: "fs-2 fw-bold",
                    closeButton: "text-black"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    row.remove();
                }
            });
        } else {
            row.remove();
        }
    });

    // Change select lead status color
    var initLeadStatusSelect = function() {
        const elements = document.getElementsByClassName('status_select');
        if (elements.length === 0) {
            return;
        }

        Object.entries(elements).map(function([index, el]) {
            // Init on load
            var selectedColor = el.options[el.selectedIndex].getAttribute('data-color');
            var classes = el.className.split(' ');
            classes.push('bg-' + selectedColor);
            classes.push('bg-opacity-20');
            classes.push('border-' + selectedColor);
            classes.push('text-' + selectedColor);
            el.className = classes.join(' ');

            el.addEventListener('change', function() {
                var color = el.options[el.selectedIndex].getAttribute('data-color');
                // Change select color
                var classes = el.className.split(' ').map(function(item_class) {
                    return item_class.startsWith('bg-') || item_class.startsWith('border-') || item_class.startsWith('text-') ? '' : item_class;
                }).filter(function(item) {
                    return item !== '';
                });
                classes.push('bg-' + color);
                classes.push('bg-opacity-20');
                classes.push('border-' + color);
                classes.push('text-' + color);
                el.className = classes.join(' ');
            });
        });
    }

    // Prevent Bootstrap dialog from blocking focusin
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });
    var initialChart4 = function() {
        var ctx = document.getElementById('ti_overview_chart_demo_4');

        var color1 = TI_Util.getCssVariableValue('--bs-text-primary');

        const labels = [
            '11/04',
            '12/04',
            '13/04',
            '14/04',
            '15/04',
            '16/04',
            '17/04',
        ];
        // Chart data
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'data1',
                    data: [
                        152,
                        435,
                        367,
                        491,
                        195,
                        615,
                        506,
                    ],
                    backgroundColor: color1,
                    barThickness: 25,
                    maxBarThickness: 25,
                }
            ]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                elements: {
                    bar: {
                        borderWidth: 2,
                        barThickness: 6,
                        maxBarThickness: 8,
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    },
                    // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
                    labels: {
                        // render: function(args) {
                        //     return args.value + '<span style="color: #f90900">**</span>';
                        // },
                        render: 'value',
                        // fontColor: '#fff',
                        fontSize: 18,
                        textShadow: false,
                        arc: false,
                        precision: 0,
                        style: {
                            color: "red",
                        }
                    }
                },
                scales: {
                    y: {

                        title: {
                            display: true,
                            text: '(Người)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                    }
                }
            },
        };
        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        return new Chart(ctx, config);
    }
    // On document ready
    TI_Util.onDOMContentLoaded(function () {
        $.fn.datepicker.dates['vi'] = {
            days: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
            daysShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
            daysMin: ["CN", "H", "B", "T", "N", "S", "B"],
            months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
            monthsShort: ["Th 1", "Th 2", "Th 3", "Th 4", "Th 5", "Th 6", "Th 7", "Th 8", "Th 9", "Th 10", "Th 11", "Th 12"],
            today: "Hôm nay",
            clear: "Xóa",
            format: "dd/mm/yyyy",
            titleFormat: "MM, yyyy",
            weekStart: 0
        };

        $('#month_picker').datepicker({
            language: 'vi',
            format: 'MM, yyyy',
            startView: "months",
            minViewMode: "months",
            autoclose: true,   
            todayHighlight: true
        });
        $('#month_picker').datepicker('setDate', new Date());
        initLeadStatusSelect();
        initialChart4();
        // Init tinymce in modal
        tinymce.init({
            selector: 'textarea#content_no_contact',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
            setup: function (editor) {
                editor.on('input focus', function () {
                    const errorElement = document.querySelector('.content_no_contact_wrapper .error-input');
                    if (errorElement) {
                        errorElement.classList.remove('show-error');
                    }
                });
            }
        });
        tinymce.init({
            selector: 'textarea#content_have_contact',
            menubar: false,
            plugins: 'image lists link anchor',
            toolbar: 'bold italic underline strike bullist numlist | link image',
            setup: function (editor) {
                editor.on('input focus', function () {
                    const errorElement = document.querySelector('.content_have_contact_wrapper .error-input');
                    if (errorElement) {
                        errorElement.classList.remove('show-error');
                    }
                });
            }
        });
    });

    var newTableSupport;
    var dataTableSupportInit = function(){
        let api = baseUrl+supportGetListApi;

        newTableSupport = new DataTable('#table_supports_new',{
            ajax: {
                url: api,
                type: "POST",
                data: function(d) {
                    d.keyword         = $('#search-table-support').val();
                    d.sp_status_id    = $('#support_status').val();
                    d.priority_level  = $('#support_spriority').val();
                    d.employees_id    = $('#support_employees').val();
                    d.from_date       = $('#filter-start-date').html();
                    d.to_date         = $('#filter-end-date').html();
                },
                beforeSend: function(xhr) {
                    var token = localStorage.getItem('jwt_token');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function(data, type, row) {
                        return `<span class="id_lead">#${data}</span>`;
                    }
                },
                { 
                    data: 'full_name',
                    name: 'full_name',
                    className: 'align-middle px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = `<div class="d-flex">
                                    <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                        <img src="assets/crm/media/svg/avatars/blank.svg" class="h-40 align-self-center" alt="">
                                    </div>

                                    <div class="d-flex align-items-center flex-nowrap text-nowrap flex-wrap">
                                        <div class="flex-grow-1 me-2 text-left">
                                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                <div id="detail_support_and_update_stt" data-id="${row.id}" style="cursor:pointer;">
                                                    ${row.full_name}
                                                </div>
                                            </span>
                                            <span class="text-muted fw-semibold d-block fs-6">
                                                ${row.leads && row.leads.leads_code ? row.leads.leads_code : '-'}
                                            </span>
                                        </div>
                                    </div>
                                </div>`;
                        return render;
                    }
                },
                {   
                    data: 'phone',
                    name: 'phone',
                    className: 'align-middle text-center px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = `<div class="d-flex justify-content-start flex-column">
                                    <span class="d-flex gap-1 align-items-center d-block fs-5">
                                        <i class="text-primary">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </i>
                                        ${row.phone}
                                    </span>
                                    <span class="d-flex gap-1 align-items-center d-block fs-5">
                                        <i class="text-primary">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                    fill="currentColor" />
                                            </svg>

                                        </i>
                                        ${row.email}
                                    </span>
                                </div>`;
                        return render;
                    }
                },
                {   
                    data: 'employees',
                    name: 'employees',
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = `<div class="d-flex align-items-center flex-nowrap text-nowrap flex-wrap">
                                        <div class="flex-grow-1 me-2 text-left">
                                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                                <div id="">
                                                    ${row && row.employees ? row.employees.name : ''}
                                                </div>
                                            </span>
                                            <span class="text-muted fw-semibold d-block fs-6">
                                                ${row && row.employees ?  row.employees.code : ''}
                                            </span>
                                        </div>
                                    </div>`;
                        return render;
                    }
                },
                {   
                    data: 'descriptions',
                    name: 'descriptions',
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let maxLength = 40;
                        let description = row.descriptions || "";
                    
                        if (description.length > maxLength) {
                            description = description.substring(0, maxLength) + "...";
                        }
                    
                        return `<span>${description}</span>`;
                    }
                },
                {   
                    data: 'file_url',
                    name: 'file_url',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = row.file_url && row.file_url != null && row.file_url != '0' 
                                    ? `<a href="${row.file_url}" target="_blank">File</a>` : '';
                        return render;
                    }
                },
                {   
                    data: 'sp_status_id',
                    name: 'sp_status_id',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function(data, type, row) {
                        let select_html = $(`<select class="ticket_status_select w-auto form-select form-select-sm" data-ticket-id="`+row.id+`"`+selecter_status);
                        if (row.status && row.status.bg_color && row.status.border_color && row.status.color) {
                            select_html.css({'background-color':row.status.bg_color, 'border-color':row.status.border_color, 'color':row.status.color});
                        }
                        if (row.status && row.status.id) {
                            select_html.find('option[value="'+row.status.id+'"]').attr('selected', 'selected');
                        }
                        let updatedHtmlString = select_html.prop('outerHTML');
                        return updatedHtmlString;
                    }
                },
                {   
                    data: 'priority_level',
                    name: 'priority_level',
                    className: 'align-middle text-center fs-5 px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let color = row.priority_level == 0 ? "rgb(0, 0, 255)" : "rgb(252, 5, 5)";
                        let name = row.priority_level == 0 ? "Thấp" : "Cao";
                    
                        return `<span style="color:${color}; font-size:13px">${name}</span>`;
                    }
                },
                {   data: 'created_at',
                    name: 'created_at',
                    className: 'align-middle text-center fs-5 px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let date = new Date(row.created_at);
                        let formattedDate = ("0" + date.getDate()).slice(-2) + "/" +
                                            ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
                                            date.getFullYear();
                        let formattedTime = ("0" + date.getHours()).slice(-2) + ":" +
                                            ("0" + date.getMinutes()).slice(-2);
                        return `<span>${formattedDate} - ${formattedTime}</span>`;
                    }
                },
                {   data: 'id',
                    name: 'id',
                    className: 'align-middle text-center fs-5 px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let date = new Date(row.updated_at);
                        let formattedDate = ("0" + date.getDate()).slice(-2) + "/" +
                                            ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
                                            date.getFullYear();
                        let formattedTime = ("0" + date.getHours()).slice(-2) + ":" +
                                            ("0" + date.getMinutes()).slice(-2);
                        return `<span>${formattedDate} - ${formattedTime}</span>`;
                    }
                },
                {   data: null,
                    name: null,
                    className: 'align-middle text-center fs-5 px-2 px-md-4 py-4',
                    searchable: false,
                    render: function(data, type, row) {
                        let render = ""; // Khởi tạo biến rỗng
                    
                        render = `<button type="button" class="btn btn-ghost p-1 deleteTicketModal" data-bs-toggle="modal" data-id="${row.id}" data-bs-target="#deleteTicketModal">
                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                        height="18" />
                                </button>`;
                        if (row.leads == null) {
                            render += `<button type="button" class="convert_to_lead btn btn-ghost p-1" 
                                            data-user-name="${row.full_name}" 
                                            data-user-email="${row.email}" 
                                            data-user-phone="${row.phone}" 
                                            data-user-id="${row.id}" 
                                            title="Tạo sinh viên tiềm năng mới">
                                            <img src="assets/crm/media/svg/crm/user-single.svg" 
                                                alt="Tạo sinh viên tiềm năng mới" width="18" height="18" />
                                        </button>`;
                        }
                    
                        return render;
                    }
                },
            ],
            layout: {
                topStart: null,
                topEnd: null,
                bottomStart: 'pageLength',
                bottomEnd: 'info',
                bottom3: 'paging'
            },
            autoWidth: true,
            stateSave: true,
            order: [[0, 'desc']]
        });
    };
    dataTableSupportInit()

    $(document).on('click', '.deleteTicketModal', (e)=>{
        let id = $(e.currentTarget).attr('data-id');
        $('#btn_delete_ticket').attr('data-id', id);
    })

    $(document).on('input', '#search-table-support', function(){
        newTableSupport.ajax.reload();
    });

    $(document).on('change', '.data-filter', function(){
        newTableSupport.ajax.reload();
    });

    $(document).on('click', '.daterangepicker .applyBtn', function(){
        newTableSupport.ajax.reload();
    });



    // Handle create request support ticket no contact \\
    $(document).on('submit', '#ticket_no_contact_form', (e) => {
        e.preventDefault();
        const api        = baseUrl+createSupportRequestApi;
        const token      = localStorage.getItem('jwt_token');
        let subject      = $('#subject_no_contact').val();
        let tag          = $('#tags_no_contact').val();
        let send_cc      = $('#send_cc_no_contact').val();
        let send_to      = $('#send_to_no_contact').val();
        let new_full_name= $('#new_full_name').val();
        let new_phone    = $('#new_phone').val();
        let description  = tinymce.get('content_no_contact').getContent({ format: 'text' });
        const submitButton = $('#btn_submit_ticket_no_contact');
        submitButton.prop('disabled', true).html('Đang tạo...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "subject"      : subject,
                "tag_id"       : tag,
                "send_to"      : send_to,
                "send_cc"      : send_cc,
                "descriptions" : description,
                "full_name"    : new_full_name,
                "phone"        : new_phone,
                "email"        : send_to,
                'priority_level': 0
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#subject_no_contact', '.subject_no_contact_wrapper', res.data.subject);
                    handleError('#send_to_no_contact', '.send_to_no_contact_wrapper', res.data.email);
                    handleError('#content_no_contact', '.content_no_contact_wrapper', res.data.descriptions);
                }else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                submitButton.prop('disabled', false).html('Tạo');
            },
            error: (err) => {
                $('#btn_submit_ticket_no_contact').html('Tạo yêu cầu hỗ trợ');
                console.error(err);
            }
        })
    })
    handleRemoveError('.subject_no_contact_wrapper', '#subject_no_contact');
    handleRemoveError('.send_to_no_contact_wrapper', '#send_to_no_contact');
    // END Handle create request support ticket no contact \\

    // Handle create request support ticket have contact \\
    $('#select_lead_have_contact').on('change', function() {
        let email = $(this).val();
        let name = $(this).find('option:selected').data('name');
        $('#name_have_contact').val(name);  // Cập nhật tên
        $('#send_to_have_contact').val(email);  // Cập nhật email
    });

    $(document).on('submit', '#ticket_have_contact_form', (e) => {
        e.preventDefault();
        const api          = baseUrl+createSupportRequestApi;
        const token        = localStorage.getItem('jwt_token');
        let subject        = $('#subject_have_contact').val();
        let tag            = $('#tags_have_contact').val();
        let send_cc        = $('#send_cc_have_contact').val();
        let send_to        = $('#send_to_have_contact').val();
        let description    = tinymce.get('content_have_contact').getContent({ format: 'text' });
        let btnHaveContact = $('#btn_submit_ticket_have_contact');
        let full_name      = $('#name_have_contact').val();  // Cập nhật tên
        let phone          = $('#select_lead_have_contact option:selected').attr('data-phone');

        // let email          = $('#send_to_have_contact').val();  // Cập nhật tên
        btnHaveContact.prop('disabled', true).html('Đang tạo...');
        // $('#btn_submit_ticket_have_contact').html('Đang tạo...');

        $.ajax({
            url: api,
            type: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            data: {
                "subject"      : subject,
                "tag_id"       : tag,
                "send_to"      : send_to,
                "send_cc"      : send_cc,
                "descriptions" : description,
                "email"        : send_to,
                "full_name"    : full_name,
                "phone"        : phone,
            },
            success: (res) => {
                if(res.code == 422){
                    handleError('#subject_have_contact', '.subject_have_contact_wrapper', res.data.subject);
                    handleError('#select_lead_have_contact', '.select_lead_have_contact_wrapper', res.data.email);
                    handleError('#content_have_contact', '.content_have_contact_wrapper', res.data.descriptions);
                }else{
                    $.notify(res.message, "success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
                // $('#btn_submit_ticket_have_contact').html('Tạo');
                btnHaveContact.prop('disabled', false).html('Tạo');
            },
            error: (err) => {
                $('#btn_submit_ticket_have_contact').html('Tạo yêu cầu hỗ trợ');
                console.error(err);
            }
        })
    })
    handleRemoveError('.subject_have_contact_wrapper', '#subject_have_contact');
    handleRemoveError('.select_lead_have_contact_wrapper', '#select_lead_have_contact');
    // END Handle create request support ticket have contact \\
});
