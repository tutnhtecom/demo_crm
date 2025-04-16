<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-1 mx-auto mx-md-0" disabled="true">
    <div class="d-flex align-items-center gap-1 gap-md-0" id="option_select_time" style="display: none !important;">
        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
        <div data-ti-daterangepicker="true" data-ti-daterangepicker-initial="true"
            data-ti-daterangepicker-opens="right" data-ti-single-datepicker="true"
            data-ti-daterangepicker-format="DD/MM/YYYY" data-placeholder="Từ ngày"
            class="btn btn-sm text-nowrap btn-light d-flex align-items-center border border-gray-300 px-4 py-1">
            <!--begin::Display range-->
            <div id="filter-start-date" class="filter-start-date text-gray-600 fw-bold fs-5">Từ ngày
            </div>
            <!--end::Display range-->
            <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
            </i>
        </div>
        <!--end::Daterangepicker-->
        <i class="d-none d-md-block fas fa-arrow-right-arrow-left px-4"></i>
        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
        <div data-ti-daterangepicker="true" data-ti-daterangepicker-range="today"
            data-ti-daterangepicker-initial="true" data-ti-daterangepicker-opens="right"
            data-ti-single-datepicker="true" data-ti-daterangepicker-format="DD/MM/YYYY"
            class="btn btn-sm text-nowrap btn-light d-flex align-items-center border border-gray-300 px-4 py-1">
            <!--begin::Display range-->
            <div id="filter-end-date" class="filter-end-date text-gray-600 fw-bold fs-5">Đến ngày
            </div>
            <!--end::Display range-->
            <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
            </i>
        </div>
        <!-- data-bs-target="#modal_add_filter" -->
        <a id="icon_filter" onclick="create_filter_from_leads()">
            <i class="fa fa-save fa-lg mx-2 w-100 text-primary fa-2x"></i>
        </a>
    </div>
    <!--end::Daterangepicker-->
    @include('crm.content.filters.modal.modal_add_filter')
    <script type="module" src="/assets/crm/js/htecomJs/Filters/createFilter.js"></script>
</div>
<script>
    function create_filter_from_leads() {
        let id = document.getElementById("icon_filter");
        // let start_date = id.getAttribute("data-start-date");
        // let end_date =  moment().format("YYYY-MM-DD");
        // let end_date = id.getAttribute("data-end-date");
        let html = ` <form id="create-filter-form">
                    <!-- Họ và tên -->
                    <div class="row create_filter_name">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Tên bộ lọc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 ">
                            <input type="text" name="name" id="name" placeholder="Nhập..." class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày bắt đầu -->
                    <div class="row my-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Ngày bắt đầu</span>
                            <span class="text-danger"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_start_date">
                            <input type="date" name="start_date" id="start_date"  placeholder="dd-mm-yyyy" class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày kết thúc -->
                    <div class="row mb-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Kết thúc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_end_date" >
                            <input type="date" name="end_date" id="end_date"  placeholder="dd-mm-yyyy" class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary py-2" id="btn_add_filter">
                                Tạo mới
                            </button>
                        </div>
                    </div>
                </form> `;

        $('#modal_add_filter').modal("show");
        $('#create_html_append').html(html);
    }    
</script>