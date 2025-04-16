<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('title', 'Yêu cầu hỗ trợ')
@section('header', 'Hỗ trợ')
@section('meta')
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
@endsection
@section('content')
<div class="px-6">
    <!--begin::App Breadcrumb-->
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <!--begin:Breadcrumb-->
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Hỗ trợ</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-primary">Yêu cầu hỗ trợ</li>
                <!--end::Item-->
            </ul>
        </div>
        <!--end:Breadcrumb-->

    </div>
    <!--end::App Breadcrumb-->
    <div class="row gx-3 mb-3" style="display:none;">
        <div class="col-12 col-md-9">
            <div class="card">
                <div class="card-header p-4">
                    <!--begin::Toolbar wrapper-->
                    <div
                        class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <div class="d-flex align-items-center">
                            <!--begin::Title-->
                            <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê yêu cầu hỗ trợ theo ngày</h3>
                            <!--end::Title-->
                        </div>

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">

                            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                            <div class="btn btn-sm btn-light d-flex align-items-center px-4">
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <input type="text" id="month_picker"
                                    class="btn btn-sm btn-ghost bg-transparent p-0" />
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <canvas id="ti_overview_chart_demo_4" class="h-225px" />
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card p-2">
                <!--begin::Details-->
                <div class="d-flex align-items-center">
                    <!--begin::Number-->
                    <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                        <span class="d-block fs-2 w-25px fw-bold text-center text-primary">53</span>
                    </div>
                    <!--end::Number-->
                    <!--begin::Details-->
                    <div class="ms-4">
                        <span class="fs-5 fw-bold text-primary text-hover-danger mb-2">Yêu cầu hỗ trợ mới</span>
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::Details-->
            </div>
            <div class="card p-2 mt-2">
                <!--begin::Details-->
                <div class="d-flex align-items-center">
                    <!--begin::Number-->
                    <div class="symbol  symbol-40px symbol-rounded bg-success bg-opacity-15 p-4">
                        <span class="d-block fs-2 w-25px fw-bold text-center text-success">36</span>
                    </div>
                    <!--end::Number-->
                    <!--begin::Details-->
                    <div class="ms-4">
                        <span class="fs-5 fw-bold text-success text-hover-danger mb-2">Mở</span>
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::Details-->
            </div>
            <div class="card p-2 mt-2">
                <!--begin::Details-->
                <div class="d-flex align-items-center">
                    <!--begin::Number-->
                    <div class="symbol  symbol-40px symbol-rounded bg-danger bg-opacity-15 p-4">
                        <span class="d-block fs-2 w-25px fw-bold text-center text-danger">21</span>
                    </div>
                    <!--end::Number-->
                    <!--begin::Details-->
                    <div class="ms-4">
                        <span class="fs-5 fw-bold text-danger text-hover-danger mb-2">Đóng</span>
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::Details-->
            </div>
            <div class="card p-2 mt-2">
                <!--begin::Details-->
                <div class="d-flex align-items-center">
                    <!--begin::Number-->
                    <div class="symbol symbol-40px symbol-rounded text-purple bg-purple bg-opacity-15 p-4">
                        <span class="d-block fs-2 w-25px fw-bold text-center text-purple">0</span>
                    </div>
                    <!--end::Number-->
                    <!--begin::Details-->
                    <div class="ms-4">
                        <span class="fs-5 fw-bold text-purple text-hover-danger mb-2">Quá hạn</span>
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::Details-->
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div class="card">
        <!--begin::Toolbar-->
        <div class="card-header p-4">
            <!--begin::Toolbar wrapper-->
            <div
                class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                <!--begin::Title-->
                <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách yêu cầu hỗ trợ</h3>
                <!--end::Title-->

                <!--begin::Search & Sort-->
                <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-2 mb-3 mb-md-0">
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        <!--begin::Icon-->
                        <i
                            class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" id="search-table-support" name="search" value="" placeholder="Tìm kiếm..."
                            class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13" />
                        <!--end::Input-->
                        <!--begin::Spinner-->
                        <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                            <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                        </span>
                        <!--end::Spinner-->
                        <!--begin::Reset-->
                        <span
                            class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                            <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <!--end::Reset-->
                    </form>
                    <!--end::Form-->
                    <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                    {{-- <div class="d-flex align-items-center justify-content-start">
                        <select class="lead_ordering_select w-auto form-select">
                            <option value="date-desc">Mới nhất</option>
                            <option value="date-asc">Cũ nhất</option>
                        </select>
                    </div> --}}

                </div>
                <!--begin::Search & Sort-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-end">

                    <!--begin:Action Buttons-->
                    <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ti_modal_new_ticket"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18"
                                fill="none">
                                <path opacity="0.3"
                                    d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z"
                                    fill="white" />
                                <path
                                    d="M9.5625 6.75C9.5625 6.43934 9.31066 6.1875 9 6.1875C8.68934 6.1875 8.4375 6.43934 8.4375 6.75L8.4375 8.43752H6.75C6.43934 8.43752 6.1875 8.68936 6.1875 9.00002C6.1875 9.31068 6.43934 9.56252 6.75 9.56252H8.4375V11.25C8.4375 11.5607 8.68934 11.8125 9 11.8125C9.31066 11.8125 9.5625 11.5607 9.5625 11.25L9.5625 9.56252H11.25C11.5607 9.56252 11.8125 9.31068 11.8125 9.00002C11.8125 8.68936 11.5607 8.43752 11.25 8.43752H9.5625V6.75Z"
                                    fill="white" />
                            </svg>

                            <span class="d-none d-md-inline">Yêu cầu mới</span>
                        </a>
                        <button id="btn_export_ticket" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                            <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Xuất file</span>
                        </button>
                        {{-- <button type="button" class="btn btn-sm btn-primary lh-0 bg-primary bg-opacity-50">
                            <img src="assets/crm/media/svg/crm/printer.svg" width="22" height="22" />
                        </button> --}}
                    </div>

                    @include('crm.content.requestSupport.modal_create_rs')

                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->

        </div>

        <div class="card-body p-4 overflow-x-auto">
            <div class="d-flex flex-wrap justify-content-between filter_toolbar gap-1">
                <div class="d-flex flex-wrap flex-md-nowrap flex-stack flex-grow-1 gap-1">                    
                    <select id="support_status" data-label="Trạng thái" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                        class="data-filter form-select form-select-sm" multiple data-placeholder-length="55">
                        @foreach ($data_support_status as $status)
                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="support_spriority" data-label="Mức độ ưu tiên" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                        class="data-filter form-select form-select-sm" multiple>
                        <option value="0">Thấp</option>
                        <option value="1">Cao</option>
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="support_employees" data-label="Tư vấn viên" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-hide-search="false"
                        class="data-filter form-select form-select-sm" multiple data-placeholder-length="45">
                        @if (isset($employees))
                            @foreach ($employees as $employee)
                                <option value="{{$employee['id']}}">{{$employee['name']}} - {{$employee['code']}}</option>
                            @endforeach                            
                        @endif
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                </div>

                <div
                    class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-1 mx-auto mx-md-0">
                    <div class="d-flex align-items-center gap-1 gap-md-0">
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
                    </div>
                    <!--end::Daterangepicker-->
                </div>
            </div>

            <div class="table-responsive position-relative border rounded-3 my-3">
                <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 display nowrap table-list-leads" id="table_supports_new">
                    <thead>
                        <tr class="bg-primary text-white">
                            {{-- <th class="w-40px text-center"></th> --}}
                            <th class="text-left fs-5 px-6">#</th>
                            <th class="w-200px text-nowrap align-middle fs-5 text-center w-225px">Người gửi yêu cầu</th>
                            <th class="text-nowrap align-middle fs-5 text-center">Liên hệ</th>
                            <th class="text-nowrap align-middle fs-5 text-center">Tư vấn viên</th>
                            <th class="text-nowrap align-middle fs-5 text-center w-300px">Mô tả yêu cầu</th>
                            <th class="text-nowrap align-middle fs-5 text-center">File đính kèm</th>
                            {{-- <th class="w-200px text-nowrap align-middle fs-5 text-start w-225px">Phụ trách tư vấn</th> --}}
                            <th class="text-nowrap align-middle fs-5 text-center">Trạng thái</th>
                            <th class="text-nowrap align-middle fs-5 text-center">Ưu tiên</th>
                            <th class="text-nowrap align-middle fs-5 text-center">Ngày tạo</th>
                            <th class="text-nowrap align-middle fs-5 text-center">Ngày cập nhật</th>
                            <th class="text-nowrap align-middle fs-5 text-center pe-4">Chức năng</th>
                        </tr>
                    </thead>
                </table>
                @include('crm.content.requestSupport.modal_delete_rs')
            </div>
        </div>
    </div>

    <div class="modal fade" id="employeesModal" tabindex="-1" aria-labelledby="employeesModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeesModalLabel">Chọn tư vấn viên hỗ trợ <span
                            class="item_full_name"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="" data-ti-menu="true" id="ti_menu_supporter">
                        <div class="d-flex flex-column bg-white bgi-no-repeat rounded p-4">
                            <form class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                                <input type="hidden">
                                <i
                                    class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input id="search_employee_on_table" type="text"
                                    class="search-input form-control form-control border border-gray-200 rounded h-lg-40px ps-13"
                                    name="search" value="" placeholder="Tìm kiếm...">
                            </form>
                            <div class="d-flex flex-column gap-1 pt-4 overflow-y-auto mh-250px">
                                @if (isset($employees))
                                    @foreach ($employees as $employee)
                                        <div class="d-flex flex-stack border-bottom mb-2 py-2">
                                            <div class="symbol rounded-full overflow-hidden symbol-50px me-5">
                                                @if (!empty($employee->files) && is_countable($employee->files) && count($employee->files) > 0)
                                                    @php
                                                        $imageShown = false;
                                                        $files = $employee->files->toArray();
                                                    @endphp
                                                    @foreach ($files as $file)
                                                        @if ($file['types'] == 0 && $file != null)
                                                            @php
                                                                $employeeAvatar = $file['image_url'];
                                                                $imageShown = true;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if (!$imageShown)
                                                        <img src="assets/crm/media/svg/avatars/blank.svg"
                                                            class="h-40 align-self-center" alt="">
                                                    @else
                                                        <img src="{{ $employeeAvatar }}" class="h-40 align-self-center"
                                                        alt="">
                                                    @endif
                                                @else
                                                    <img src="assets/crm/media/svg/avatars/blank.svg"
                                                        class="h-40 align-self-center" alt="">
                                                @endif
                                        </div>
                                        <div
                                            class="d-flex  align-items-between align-items-center flex-row-fluid flex-wrap">
                                            <div class="d-flex flex-column flex-grow-0 me-2">
                                                <span class="badge badge-outline rounded-full badge-primary fs-8 fw-bold"
                                                    style="width:max-content;"> {{ $employee['roles_name'] }} </span>

                                                <span
                                                    class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold">{{ $employee['name'] }}</span>
                                                <span
                                                    class="text-muted fw-semibold d-block fs-7">{{ $employee['code'] }}</span>
                                            </div>
                                            <input data-id="{{ $item['id'] ?? ''}}" type="radio"  class="ms-auto form-check-input employee-radio" name="supporter"
                                                value="{{ $employee['id'] }}" data-name="{{ $employee['name'] }}" data-code="{{ $employee['code'] }}">
                                        </div>
                                        </div>
                                    @endforeach
                                    
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" src="/assets/crm/js/htecomJs/supports.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/createSupportRequest.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/exportSupportTicket.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/deleteTicket.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || window.performance && window.performance.navigation.type === 2) {
            location.reload();
        }
    });
    var selecter_status = ` >
            <option value="">__Chọn trạng thái__</option>
            @foreach($data_support_status ?? [] as $status)
                <option value="{{ $status['id'] }}" 
                    data-color="{{ $status['color'] }}" 
                    data-bg-color="{{ $status['bg_color'] }}" 
                    data-border-color="{{ $status['border_color'] }}">
                    {{ $status['name'] }}
                </option>
            @endforeach
        </select>`;
</script>
@endsection
