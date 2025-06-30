import { baseUrl,leadsEditlURL, leadsDetailURL, getAllTags } from '/assets/crm/js/htecomJs/variableApi.js';

$(document).ready(()=>{
    const token = localStorage.getItem('jwt_token');
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
    // Prevent Bootstrap dialog from blocking focusin
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
            e.stopImmediatePropagation();
        }
    });

    //gắn tag cho lead
    function dropdown_render(list_tag, tagDropdown, inputValue){
        tagDropdown.empty(); // Xóa nội dung cũ
        if (inputValue.trim() !== '') {
            const filteredTags = list_tag.filter(tag =>
                tag.name.toLowerCase().includes(inputValue)
            );
            if (filteredTags.length > 0) {
                filteredTags.forEach(tag => {
                    tagDropdown.append(`<li data-id="${tag.id}">${tag.name}</li>`);
                });
                tagDropdown.show();
            } else {
                tagDropdown.hide();
            }
        } else {
            tagDropdown.hide();
        }
    }
    function tags_input_actions(){
        const tagInput = $('#edit_lead_tag');
        const tagDropdown = $('#tag-dropdown');
        const api = baseUrl+getAllTags;
        let list_tag = [];
        $(document).on('input', '#edit_lead_tag', function(){
            const inputValue = $(this).val().toLowerCase();
            $.ajax({
                url: api,
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                success: (res)=>{
                    if(res.code == 200){
                        if(res.data.length){
                            list_tag = res.data;
                            dropdown_render(list_tag, tagDropdown, inputValue)
                        }
                    }
                },
                error: function(error){
                    return [];
                }
            });

        });
        $(document).on('click', '#tag-dropdown li', function () {
            const selectedTag = $(this).text();
            tagInput.val(selectedTag);
            tagDropdown.hide(); // Ẩn dropdown
        });

        // Ẩn dropdown khi click ra ngoài
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.tag-input-wrapper').length) {
                tagDropdown.hide();
            }
        });
    }
    tags_input_actions();

    //Tìm kiếm trong popup nhân viên
    $('#search_employee_on_table').on('keyup', function() {
        let searchText = $(this).val().toLowerCase();
        $('.d-flex.flex-column.gap-1.pt-4.overflow-y-auto.mh-250px > div').each(function() {

            var employeeName = $(this).find('.text-gray-800').text().toLowerCase();
            var employeeCode = $(this).find('.text-muted').text().toLowerCase();
            // Kiểm tra nếu phần tử chứa cụm từ tìm kiếm
            if (employeeName.includes(searchText) || employeeCode.includes(searchText)) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
    });

    $('#search_employee_on_table_2').on('keyup', function() {
        let searchText = $(this).val().toLowerCase();
        $('.d-flex.flex-column.gap-1.pt-4.overflow-y-auto.mh-250px > div').each(function() {

            var employeeName = $(this).find('.text-gray-800').text().toLowerCase();
            var employeeCode = $(this).find('.text-muted').text().toLowerCase();
            // Kiểm tra nếu phần tử chứa cụm từ tìm kiếm
            if (employeeName.includes(searchText) || employeeCode.includes(searchText)) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
    });

    function clickMenuActive(){
        const currentUrl = window.location.href;
        $('#ti_app_sidebar_menu .menu-link').removeClass('active'); // Thêm class 'active'
        $('#ti_app_sidebar_menu .menu-link').parents('.menu-item, .menu-sub.menu-sub-accordion').removeClass('show');
        $('#ti_app_sidebar_menu .menu-link').each(function() {
            const linkUrl = $(this).attr('href');

            if (currentUrl.includes(linkUrl)) {
                $(this).addClass('active'); // Thêm class 'active'
                $(this).parents('.menu-item, .menu-sub.menu-sub-accordion').addClass('show');
                // $(this).parents('.menu-item.menu-accordion').addClass('show');
            }
        });
    }
    clickMenuActive();
    $(document).on('click', '.btn-employee-modal', function(){
        let item_id = $(this).attr('data-item-id');
        let item_full_name = $(this).attr('data-item-full_name');
        let modal_target = $(this).attr('data-bs-target');
        let assignments_id = $(this).attr('data-assignments-id');
        $(modal_target).find('.item_full_name').html(item_full_name);
        $(modal_target).find('.form-check-input.employee-radio').attr('data-id', item_id);
        $(modal_target).find('.form-check-input.employee-radio[value="'+assignments_id+'"]').prop('checked', true);
    });

    function formatTime(createdAt) {
        const date = new Date(createdAt);

        const hours = String(date.getUTCHours()).padStart(2, '0'); // Thêm 0 ở đầu nếu cần
        const minutes = String(date.getUTCMinutes()).padStart(2, '0'); // Thêm 0 ở đầu nếu cần

        return `${hours}:${minutes}`;
    }
    function convertDateFormat(dateStr) {
        let new_str = dateStr.replaceAll("/", "-");
        const [day, month, year] = new_str.split("-");
        // let new_date = new Date(`${year}-${month}-${day}`);
        let new_date = moment(`${year}-${month}-${day}`).format("YYYY-MM-DD");        
        return new_date;
    }

    function setDateInput(inputSelector, dateStr) {
        if (!dateStr) return; // Nếu null hoặc rỗng thì không làm gì
    
        let parts = dateStr.split("/");
        if (parts.length !== 3) return; // Kiểm tra xem có đủ 3 phần không
    
        let formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
        $(inputSelector).val(formattedDate);
    }

    // function set_data_filter(filter) {        
    //     let id = document.getElementById('icon_filter');
    //     if (!id) return; // Tránh lỗi nếu không tìm thấy phần tử
    //     let from_date;
    //     let to_date;
    //     if (filter == "#") {
    //         // from_date = moment($('#filter-start-date').html()).format("YYYY-MM-DD");
    //         from_date = $('#filter-start-date').text();
    //         to_date = $('#filter-end-date').text();
    //     }
                       
    //     if (filter == "#") {
    //         // id.setAttribute("data-start-date", from_date);
    //         // id.setAttribute("data-end-date", to_date);
    //         setDateInput("#start_date", from_date);            
    //         setDateInput("#end_date", to_date);            
    //     } else {
    //         // let filterValue = $('#icon_filter').text();
    //         // id.setAttribute("data-id", filterValue);            
    //     }
    // }

    $(document).on('click', '#icon_filter', (e)=>{
        let from_date;
        let to_date;
        let filter = $('#config-filter').val();
        if (filter == "#") {
            from_date = $('#filter-start-date').text();
            to_date = $('#filter-end-date').text();
            setTimeout(()=>{
                setDateInput("#start_date", from_date);            
                setDateInput("#end_date", to_date);            
            },500)
        }
    })

    // $(document).on('change', '#config-filter', ()=>{
    //     console.log($('#config-filter option:selected').attr('data-start-date'));
    // });
    
    var tableLeads;
    var dataTableInit = function() {
        //Được dùng cho 2 page: Leads và chi tiết Nhân viên
        let leadsAjaxApi    = $('#table-leads').attr('data-ajax-url');
        let employeeId      = $('#table-leads').attr('data-employee-id');
        let employeeName    = $('#table-leads').attr('data-employee-name');
        tableLeads = new DataTable('#table-leads', {
            ajax: {
                url: baseUrl + leadsAjaxApi,
                type: "POST",
                data: function(d) {                    
                    d.employeeId = employeeId;
                    d.filters = $('#config-filter').val();
                    d.keyword = $('#search-table-leads').val();
                    d.sources_id = $('#sources-filter').val();
                    d.lst_status_id = $('#status-filter').val();
                    d.tags_id = $('#tags-filter').val();
                    d.marjors_id = $('#marjor-filter').val();
                    d.assignments_id = employeeId ? employeeId : $('#assignment-filter').val();
                    if(d.filters == "#"){
                        d.from_date = $('#filter-start-date').html();
                        d.to_date = $('#filter-end-date').html();
                    } else {
                        d.from_date = $('#config-filter option:selected').attr('data-start-date');
                        d.to_date = $('#config-filter option:selected').attr('data-end-date')
                    }
                },
                beforeSend: function(xhr) {
                    var token = localStorage.getItem('jwt_token');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
            },
            columns: [
                {
                    orderable: false,
                    render: DataTable.render.select(),
                },
                {   data: 'id',
                    name: 'id',
                    className: 'align-middle text-center ps-2 id_lead',
                    searchable: false,
                    render: function(data, type, row) {
                        return `<span class="id_lead">`+data+`</span>`;
                    }
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    className: 'align-middle px-2 px-md-4 py-4',
                    render: function(data, type, row) {
                        let name_address = '';
                        if (row.address){
                            name_address = `<span class="d-flex gap-1 align-items-center text-muted text-nowrap d-block fs-6">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z" fill="currentColor" />
                                        </svg>
                                        `+row.address+`
                                    </span>`;
                        }

                        //let urlDetail;
                        
                        // urlDetail = (row.employees && row.employees.id == employeeLoginId) || 
                        //             employeeLoginId == "" || 
                        //             employeeLoginRoleId == 1
                        //             ? baseUrl + leadsDetailURL + row.id 
                        //             : baseUrl + '/crm/leads';

                        return `<div class="d-flex justify-content-start flex-column">
                                    <a id="`+row.id+`" href="`+baseUrl + leadsDetailURL + row.id+`" class="text-private text-nowrap fw-bold text-hover-primary mb-1 fs-6">`+data+`</a>
                                    `+name_address+`
                                </div>`;
                    }
                },
                {
                    data: 'leads_code',
                    name: 'leads_code',
                    className: 'align-middle py-4',
                    render: function(data, type, row) {
                        let render;
                        if(row.leads_code){
                            render = `<span>${row.leads_code}</span>`
                        } else if(row.leads_code == null && row.leads == null){
                            render = `<span></span>`
                        }
                        return render;
                    }

                },
                // { data: 'full_name', name: 'full_name', title: 'Thí sinh' },  // Cột tên thí sinh
                {
                    data: 'phone',
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    render: function(data, type, row) {
                        return `<div class="d-flex justify-content-start flex-column">
                                    <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                        `+data+`
                                    </span>
                                </div>`;
                    }
                },
                {
                    data: 'email',
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    render: function(data, type, row) {
                        if (row.d_email_status !== null && row.d_email_status !== 0) {
                            return `<div class="d-flex justify-content-start flex-column">
                                    <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                        <span class="email_lead" style="color:red">`+row.email+`</span>
                                    </span>
                                </div>`;
                        } else {
                            return `<div class="d-flex justify-content-start flex-column">
                                    <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                        <span class="email_lead">`+row.email+`</span>
                                    </span>
                                </div>`;
                        }


                    }
                },
                {
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    render: function(data, type, row) {
                        let render_html = `<div class="d-flex flex-stack">
                                            <div class="d-flex align-items-center justify-content-between flex-row-fluid">`;
                        if(employeeId){
                            render_html += `<div id="employee-info-of-`+row.id+`" class="flex-grow-1 me-2 d-flex flex-stack border-bottom mb-2 py-2">
                                                <span class="fs-5">`+employeeName+`</span>
                                            </div>`;
                            return render_html;
                        }
                        if (row.assignments_id == 0 || row.employees === null){
                            render_html += `<div id="employee-info-of-`+row.id+`" class="flex-grow-1 me-2 d-flex flex-stack border-bottom mb-2 py-2">
                                                <span class="fs-5">Chưa có</span>
                                            </div>`
                        }else{
                            render_html +=`<div id="employee-info-of-`+row.id+`" class="d-flex flex-stack border-bottom mb-2 py-2">
                                                <div class="d-flex  align-items-between align-items-center flex-row-fluid flex-wrap">
                                                    <div class="d-flex flex-column flex-grow-0 me-2">
                                                        <span class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold"> `+row.employees.name+` </span>
                                                        <span class="text-muted fw-semibold d-block fs-7">`+row.employees.code+`</span>
                                                    </div>
                                                </div>
                                            </div>`
                        }
                         render_html += (row.employees && row.employees.id == employeeLoginId) || 
                         employeeLoginId == "" || 
                         employeeLoginRoleId == 1 ?  ` <button type="button" class="btn-employee-modal btn btn-ghost text-muted p-0" data-bs-toggle="modal" data-bs-target="#employeesModal" data-assignments-id="`+row.assignments_id+`" data-item-id="`+row.id+`" data-item-full_name="`+row.full_name+`">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z" fill="currentColor" />
                                        <path d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z" fill="currentColor" />
                                        <path d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z" fill="currentColor" />
                                    </svg>
                                </button>` : `<div></div>`;
                        render_html += `</div></div>`
                        return render_html;
                    }
                },
                {
                    className: 'align-middle text-start fs-5 px-2 px-md-4 py-4',
                    data: 'sources.name',
                    name: 'sources.name',
                },
                {
                    className: 'align-middle text-start fs-5 px-2 px-md-4 py-4',
                    data: 'tags.name',
                    name: 'tags.name',
                },
                {
                    className: 'align-middle text-start px-2 px-md-4 py-4',
                    data: 'marjors.name',
                },
                {
                    className: 'align-middle text-center',
                    render: function(data, type, row) {
                        let select_html = $(`<select data-id="`+row.id+`"`+selecter_status);
                        if ((row.employees && row.employees.id == employeeLoginId) || employeeLoginId == "" || employeeLoginRoleId == 1) {
                            select_html.attr('');
                        } else {
                            select_html.attr('disabled', 'disabled');
                        }

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
                    className: 'align-middle text-start fs-5 px-2 px-md-4 py-4',
                    data: 'created_at',
                    render: function(data, type, row) {
                        let date = new Date(row.created_at);
                        // Lấy ngày, tháng, năm và định dạng lại thành dd/mm/yyyy
                        let formattedDate = ("0" + date.getDate()).slice(-2) + "/" +
                                            ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
                                            date.getFullYear();
                        let formattedTime = ("0" + date.getHours()).slice(-2) + ":" +
                                            ("0" + date.getMinutes()).slice(-2);
                        let render_html = `<div class="d-flex justify-content-start flex-column">
                                    <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                        <i class="text-primary">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.52085 1.45837C4.52085 1.21675 4.32498 1.02087 4.08335 1.02087C3.84173 1.02087 3.64585 1.21675 3.64585 1.45837V2.37961C2.80624 2.44684 2.25505 2.61184 1.8501 3.01679C1.44516 3.42174 1.28015 3.97293 1.21292 4.81254H12.7871C12.7199 3.97293 12.5549 3.42174 12.1499 3.01679C11.745 2.61184 11.1938 2.44684 10.3542 2.37961V1.45837C10.3542 1.21675 10.1583 1.02087 9.91669 1.02087C9.67506 1.02087 9.47919 1.21675 9.47919 1.45837V2.3409C9.09112 2.33337 8.65612 2.33337 8.16669 2.33337H5.83335C5.34392 2.33337 4.90893 2.33337 4.52085 2.3409V1.45837Z" fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.16669 7.00004C1.16669 6.5106 1.16669 6.07561 1.17421 5.68754H12.8258C12.8334 6.07561 12.8334 6.5106 12.8334 7.00004V8.16671C12.8334 10.3666 12.8334 11.4665 12.1499 12.15C11.4665 12.8334 10.3666 12.8334 8.16669 12.8334H5.83335C3.63347 12.8334 2.53352 12.8334 1.8501 12.15C1.16669 11.4665 1.16669 10.3666 1.16669 8.16671V7.00004ZM9.91669 8.16671C10.2389 8.16671 10.5 7.90554 10.5 7.58337C10.5 7.26121 10.2389 7.00004 9.91669 7.00004C9.59452 7.00004 9.33335 7.26121 9.33335 7.58337C9.33335 7.90554 9.59452 8.16671 9.91669 8.16671ZM9.91669 10.5C10.2389 10.5 10.5 10.2389 10.5 9.91671C10.5 9.59454 10.2389 9.33337 9.91669 9.33337C9.59452 9.33337 9.33335 9.59454 9.33335 9.91671C9.33335 10.2389 9.59452 10.5 9.91669 10.5ZM7.58335 7.58337C7.58335 7.90554 7.32219 8.16671 7.00002 8.16671C6.67785 8.16671 6.41669 7.90554 6.41669 7.58337C6.41669 7.26121 6.67785 7.00004 7.00002 7.00004C7.32219 7.00004 7.58335 7.26121 7.58335 7.58337ZM7.58335 9.91671C7.58335 10.2389 7.32219 10.5 7.00002 10.5C6.67785 10.5 6.41669 10.2389 6.41669 9.91671C6.41669 9.59454 6.67785 9.33337 7.00002 9.33337C7.32219 9.33337 7.58335 9.59454 7.58335 9.91671ZM4.08335 8.16671C4.40552 8.16671 4.66669 7.90554 4.66669 7.58337C4.66669 7.26121 4.40552 7.00004 4.08335 7.00004C3.76119 7.00004 3.50002 7.26121 3.50002 7.58337C3.50002 7.90554 3.76119 8.16671 4.08335 8.16671ZM4.08335 10.5C4.40552 10.5 4.66669 10.2389 4.66669 9.91671C4.66669 9.59454 4.40552 9.33337 4.08335 9.33337C3.76119 9.33337 3.50002 9.59454 3.50002 9.91671C3.50002 10.2389 3.76119 10.5 4.08335 10.5Z" fill="#034EA2" />
                                            </svg>
                                        </i>
                                        `+formattedDate+`
                                    </span>
                                    <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                        <i class="text-primary">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.8334 6.99996C12.8334 10.2216 10.2217 12.8333 7.00002 12.8333C3.77836 12.8333 1.16669 10.2216 1.16669 6.99996C1.16669 3.7783 3.77836 1.16663 7.00002 1.16663C10.2217 1.16663 12.8334 3.7783 12.8334 6.99996Z" fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00002 4.22913C7.24165 4.22913 7.43752 4.425 7.43752 4.66663V6.81874L8.76771 8.14893C8.93857 8.31979 8.93857 8.5968 8.76771 8.76765C8.59686 8.93851 8.31985 8.93851 8.14899 8.76765L6.69066 7.30932C6.60861 7.22727 6.56252 7.11599 6.56252 6.99996V4.66663C6.56252 4.425 6.7584 4.22913 7.00002 4.22913Z" fill="white" />
                                            </svg>
                                        </i>
                                        `+formattedTime+`
                                    </span>
                                </div>`
                        return render_html;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'align-middle text-center fs-5 px-2 px-md-4 py-4',
                    render: function(data, type, row) {
                        // let render_html =  `<a href="`+baseUrl+leadsEditlURL+row.id+`" class="btn btn-ghost p-1 crm_lead_edit_lead">
                        //             <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                        //         </a>`;

                        let render_html;
                        render_html = (row.employees && row.employees.id == employeeLoginId) || 
                                        employeeLoginId == "" || 
                                        employeeLoginRoleId == 1
                                        ? `<a href="${baseUrl}${leadsEditlURL}${row.id}" class="btn btn-ghost p-1 crm_lead_edit_lead">
                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                        </a>`
                                        : '<div></div>';

                        render_html += (row.employees && row.employees.id == employeeLoginId) || 
                                        employeeLoginId == "" || 
                                        employeeLoginRoleId == 1
                                        ? ` <button type="button" class="btn_send_notification crm_notification_create btn btn-ghost p-1" data-bs-toggle="modal" data-bs-target="#ti_modal_send_notification" data-email="`+row.email+`">
                                                <img src="assets/crm/media/svg/crm/send.svg" alt="Gửi thông báo" width="18" height="18" />
                                            </button>`
                                        : '<div></div>';    
                        
                        // if(!employeeId ){
                        //     render_html +=  `<button type="button" class="btn_send_notification crm_notification_create btn btn-ghost p-1" data-bs-toggle="modal" data-bs-target="#ti_modal_send_notification" data-email="`+row.email+`">
                        //         <img src="assets/crm/media/svg/crm/send.svg" alt="Gửi thông báo" width="18" height="18" />
                        //     </button>`;
                        // }
                        // render_html +=  `<a href="`+baseUrl+leadsDetailURL+row.id+`" class="btn btn-ghost p-1">
                        //         <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18" height="18" />
                        //     </a>`;
                        // if(!employeeId ){
                        //     render_html +=  `<button type="button" class="btn_delete_item btn btn-ghost p-1" data-id="`+row.id+`" data-bs-toggle="modal" data-bs-target="#deleteItemModal">
                        //         <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                        //     </button>`;
                        // }
                        return render_html;
                    }
                }
            ],// Cột chức năng (thêm các nút tùy chỉnh)
                layout: {
                    topStart: {
                        buttons: [
                            {
                                extend: 'colvis',
                                text: 'Hiển thị'
                            }
                        ],
                    },
                topEnd:
                !employeeId ? {
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     text: 'Print current page',
                        //     exportOptions: {
                        //         modifier: {
                        //             page: 'current'
                        //         }
                        //     }
                        // },
                        {
                            text: 'Xoá',
                            className: 'crm_leads_delete',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_detele_ids = [];
                                    let selected_data = selected_rows.data();
                                    
                                    selected_data.each(function(rowData) {
                                        if(rowData.employees && rowData.employees.id == employeeLoginId || employeeLoginId == "" || employeeLoginRoleId == 1){
                                            arr_detele_ids.push(rowData.id);
                                        }
                                    });
                                    let data_id = arr_detele_ids.join(',');
                                    let firstTenItems = arr_detele_ids.slice(0, 10);
                                    let str = firstTenItems.join(',');
                                    if (arr_detele_ids.length > 10) {
                                        str += '...';
                                    }
                                    if(data_id != ''){
                                        $('#btn_delete_item').attr('data-id', data_id);
                                        $('#btn_delete_item').prop('disabled', false);
                                        $('#deleteItemModal').modal('show');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="fs-10 fs-md-5 fw-normal">Xác nhận xoá các bản ghi có ID:</span> <span>'+str+'</span>');
                                    } else{
                                        $('#btn_delete_item').attr('disabled', 'disabled');
                                        $('#deleteItemModal').modal('show');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="fs-10 fs-md-5 fw-bold text-center">Bạn không được quyền xóa bản ghi này.</span>');
                                    }
                                    
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
                                        if(rowData.employees && rowData.employees.id == employeeLoginId || employeeLoginId == "" || employeeLoginRoleId == 1){
                                            arr_group_ids.push(rowData.id);
                                        }
                                    });
                                    let firstTenItems = arr_group_ids.slice(0, 10);
                                    let str = firstTenItems.join(',');
                                    if (arr_group_ids.length > 10) {
                                        str += '...';
                                    }
                                    if(arr_group_ids != ''){
                                        $('#groupLeadsModal').modal('show');
                                        $('#btn_group_leads_submit').attr('data-ids', arr_group_ids.join(','))
                                    } else {
                                        $('#deleteItemModal').modal('show');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="text-center">Bạn không được quyền tạo nhóm với bản ghi này</span>');
                                    }
                                }else{
                                    $('#deleteItemModal').modal('show');
                                    $('#deleteItemModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        },
                        {
                            text: 'Chuyển thành Sinh viên',
                            className: 'crm_student_create',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_convert_ids = [];
                                    let selected_data = selected_rows.data();
                                    selected_data.each(function(rowData) {
                                        if(rowData.employees && rowData.employees.id == employeeLoginId || employeeLoginId == "" || employeeLoginRoleId == 1){
                                            arr_convert_ids.push(rowData.id);
                                        }
                                    });
                                    
                                    let data_id = arr_convert_ids.join(',');
                                    let firstTenItems = arr_convert_ids.slice(0, 10);
                                    let str = firstTenItems.join(', ');
                                    if (arr_convert_ids.length > 10) {
                                        str += '...';
                                    }
                                    if(data_id != ''){
                                        $('#btn_convert_lead').attr('data-id', data_id);
                                        $('#convertLeadModal').find('.notice-text').html('<span class="fs-10 fs-md-5 fw-normal">Xác nhận chuyển thành sinh viên chính thức:</span> <span>'+str+'</span>');
                                        $('#convertLeadModal').modal('show');
                                        $('#btn_delete_item').prop('disabled', false);
                                    } else {
                                        $('#deleteItemModal').modal('show');
                                        $('#btn_delete_item').attr('disabled', 'disabled');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="text-center">Bạn không được quyền chuyển thành sinh viên với bản ghi này</span>');
                                    }
                                }else{
                                    $('#convertLeadModal').modal('show');
                                    $('#convertLeadModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        },
                        {
                            text: 'Chuyển đổi tư vấn viên',
                            className: 'crm_change_multi_employee',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_convert_ids = [];
                                    let selected_data = selected_rows.data();
                                    selected_data.each(function(rowData) {
                                        if(rowData.employees && rowData.employees.id == employeeLoginId || employeeLoginId == "" || employeeLoginRoleId == 1){
                                            arr_convert_ids.push(rowData.id);
                                        }
                                    });
                                    
                                    let data_id = arr_convert_ids.join(',');
                                    let firstTenItems = arr_convert_ids.slice(0, 10);
                                    let str = firstTenItems.join(', ');
                                    if (arr_convert_ids.length > 10) {
                                        str += '...';
                                    }
                                    if(data_id != ''){
                                        $('#btn_success_change_employee').attr('data-id', data_id);
                                        $('#modalChangeMultiEmployee').modal('show');
                                        $('#btn_delete_item').prop('disabled', false);
                                    } else {
                                        $('#deleteItemModal').modal('show');
                                        $('#btn_delete_item').attr('disabled', 'disabled');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="text-center">Bạn không được quyền chuyển thành sinh viên với bản ghi này</span>');
                                    }
                                }else{
                                    $('#convertLeadModal').modal('show');
                                    $('#convertLeadModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        },
                        {
                            text: 'Chuyển đổi trạng thái',
                            className: 'crm_change_multi_status',
                            action: function (e, dt, node, config) {
                                let selected_rows = dt.rows( { selected: true } );
                                if(selected_rows.count()){
                                    let arr_convert_ids = [];
                                    let selected_data = selected_rows.data();
                                    selected_data.each(function(rowData) {
                                        if(rowData.employees && rowData.employees.id == employeeLoginId || employeeLoginId == "" || employeeLoginRoleId == 1){
                                            arr_convert_ids.push(rowData.id);
                                        }
                                    });
                                    
                                    let data_id = arr_convert_ids.join(',');
                                    let firstTenItems = arr_convert_ids.slice(0, 10);
                                    let str = firstTenItems.join(', ');
                                    if (arr_convert_ids.length > 10) {
                                        str += '...';
                                    }
                                    if(data_id != ''){
                                        $('#btn_success_change_status').attr('data-id', data_id);
                                        $('#modalChangeMultiStatus').modal('show');
                                    } else {
                                        $('#deleteItemModal').modal('show');
                                        $('#btn_delete_item').attr('disabled', 'disabled');
                                        $('#deleteItemModal').find('.notice-text').html('<span class="text-center">Bạn không được quyền chỉnh sửa bản ghi này</span>');
                                    }
                                }else{
                                    $('#convertLeadModal').modal('show');
                                    $('#convertLeadModal').find('.notice-text').text('Vui lòng chọn ít nhất 1 bản ghi');
                                }
                            }
                        }
                        // {
                        //     text: 'Cập nhật Mã SV',
                        //     className: 'crm_student_update_code',
                        //     action: function (e, dt, node, config) {                                
                        //         $('#updateCodeLeadsModal').modal('show');                                
                        //     }
                        // }
                    ]
                } : null,
                // topEnd: null,
                bottomStart: 'pageLength',
                bottomEnd: 'info',
                bottom3: 'paging'
            },
            autoWidth: true,
            stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child',
                headerCheckbox: 'select-page'
            },
            order: [[1, 'desc']]
        });
    };    
    dataTableInit();
    $(document).on('change', '#config-filter', function(){        
        let value = $('#config-filter').val();                
        // set_data_filter(value);
        let id_filter = document.getElementById("option_select_time");
        if(value == '#') {
            document.getElementById("option_select_time").style.display="block";
        }
        else {
          id_filter.setAttribute('style', "display: none !important;");
        }   
    });
    $(document).on('change', '.data-filter', function(){
        tableLeads.ajax.reload();
    });
    $(document).on('input', '#search-table-leads', function(){
        tableLeads.ajax.reload();
    });
    $(document).on('click', '.daterangepicker .applyBtn', function(){
        tableLeads.ajax.reload();
    });
    $(document).on('click', '.btn_send_notification', function(){
        $('#send_noti_account').val($(this).attr('data-email')).trigger('change');
    });
    $('#btn_back_page').on('click', function () {
        window.history.back();
    });

    $(document).on('change', '.lead_status_select', function() {
        var selectedOption = $(this).find('option:selected');
        var selectedColor = selectedOption.data('bg-color');
        var selectedBorderColor = selectedOption.data('border-color');
        var selectedTextColor = selectedOption.data('text-color');

        $(this).css({
            'background-color': selectedColor,
            'border-color': selectedBorderColor,
            'color': selectedTextColor
        });
    });

    //Reset nội dung trong modal xoá về mặc định - xoá 1 item
    $('#deleteItemModal').on('hide.bs.modal', function (event) {
        $('#deleteItemModal').find('.notice-text').text('Xóa hồ sơ này?');
    });

    // icon luu lai
    // icon_filter

})

export function formatDate(inputDate) {
    const dateObj = new Date(inputDate);

    if (isNaN(dateObj.getTime())) {
        return null; // Nếu không hợp lệ, trả về null hoặc thông báo lỗi
    }

    const day = String(dateObj.getDate()).padStart(2, '0'); // Đảm bảo 2 chữ số
    const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = dateObj.getFullYear();

    return `${day}/${month}/${year}`;
}

export function handleError(field, wrapper, errors) {
    if (errors != null) {
        $(field).addClass('border-error');
        $(wrapper + ' .error-input').html(errors.join(', '));
        $(wrapper + ' .error-input').addClass('show-error');
    }
}

// handle remove error effect when click input \\
export function handleRemoveError(wrapper, id_input){
    $(wrapper).on('click', function() {
        $(this).find('.error-input').removeClass('show-error').html('');
        $(this).find(id_input).removeClass('border-error');
    });
}
