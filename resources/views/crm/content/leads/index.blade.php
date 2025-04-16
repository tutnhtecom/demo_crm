<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('header','Quản lý sinh viên tiềm năng')
@section('title','Quản lý sinh viên tiềm năng')
<script type="module" src="{{ asset('assets/crm/js/htecomJs/lead.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/exportItems.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/Lead/changeStatusLead.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/deleteItem.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/Lead/convertLead.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/Lead/changeEmployeeForLead.js') }}"></script>
@section('content')
<div class="px-6">
    <!--begin::App Breadcrumb-->
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <!--begin:Breadcrumb-->
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thí sinh mới</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-primary">Sinh viên tiềm năng</li>
                <!--end::Item-->
            </ul>
        </div>
        <!--end:Breadcrumb-->

    </div>
    <!--end::App Breadcrumb-->
    <!--begin::Overview Stats-->
    {{-- <div class="app-overview-stats">
            <div class="row mb-3 gy-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card p-2 mb-2 mb-md-0">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-primary">53</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-primary text-hover-primary mb-2">Thí sinh mới</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh mới đăng ký</div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card p-2 mb-2 mb-md-0">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <div class="symbol  symbol-40px symbol-rounded bg-warning bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-warning">16</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-warning text-hover-warning mb-2">Hồ sơ đã nộp</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh đã nộp hồ sơ</div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card p-2 mb-2 mb-md-0">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <div class="symbol  symbol-40px symbol-rounded bg-success bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-success">20</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-success text-hover-success mb-2">Thí sinh chính
                                    thức</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh hoàn tất đăng ký trử thành
                                    chính thức</div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card p-2">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <div class="symbol  symbol-40px symbol-rounded bg-danger bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-danger">02</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-danger text-hover-danger mb-2">Từ chối</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh từ chối nhập học</div>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
            </div>
        </div> --}}
    <!--end::Overview Stats-->
    <!--begin::Content-->
    <div class="card">
        <!--begin::Toolbar-->
        <div class="card-header p-4">
            <!--begin::Toolbar wrapper-->
            <div
                class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                <!--begin::Title-->
                <h3 class="card-title text-dark fw-bolder m-md-0">Sinh viên tiềm năng</h3>
                <!--end::Title-->

                <!--begin::Search & Sort-->
                <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <div class="w-100 position-relative mb-lg-0" autocomplete="off">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        <!--begin::Icon-->
                        <i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input id="search-table-leads" type="search"
                            class="data-filter search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                            name="search" value="" placeholder="Tìm kiếm..." maxlength="20" />
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
                    </div>
                    <!--end::Form-->
                    <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                </div>
                <!--begin::Search & Sort-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-end btn_group_index_leads">
                    <!--begin:Action Buttons-->
                    <div class="d-flex align-items-center gy-2 gap-1">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#ti_modal_send_notification"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_notification_create">
                            <img src="assets/crm/media/svg/crm/letter-unread.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Gửi thông báo</span>
                        </a>
                        <a href="{{ route('crm.lead.create_lead') }}"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead">
                            <img src="assets/crm/media/svg/crm/add-circle.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Thêm mới</span>
                        </a>
                        <button id="btn_export_list" type="button"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 "
                            data-bs-toggle="modal" data-bs-target="#exLeadsLists">
                            <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Xuất file</span>
                        </button>
                        <button id="btn_import_leads" type="button"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead"
                            data-bs-toggle="modal" data-bs-target="#importLeadsModal">
                            <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Nhập dữ liệu</span>
                        </button>

                        <!-- Import giao dịch cho nhân viên -->
                        <div class="wrap_btn crm_notification_pricelist">
                            <button id="btn_import_price_list" type="button"
                                class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 "
                                data-bs-toggle="modal" data-bs-target="#modal_import_price_list">
                                <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Import học phí</span>
                            </button>
                        </div>

                        <div class="crm_lead_transaction">
                            <button id="btn_transactions_leads" type="button"
                                class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1"
                                data-bs-toggle="modal" data-bs-target="#modal_import_tractions">
                                <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Import giao dịch</span>
                            </button>
                        </div>

                        <!-- {{-- Modal Create Group --}} -->
                        <div class="modal fade" id="groupLeadsModal" tabindex="-1"
                            aria-labelledby="groupLeadsModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tạo nhóm thí sinh</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="group_input_wrapper">
                                            <p class="notice-text"></p>
                                            <label for="" class="mb-1">Tên nhóm <span
                                                    class="text-danger">*</span></label>
                                            <input id="name_group_input" type="text"
                                                placeholder="VD: Nhóm học sinh 1">
                                            <p class="error-input mt-1"></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn_group_leads_submit" type="button" data-types="0"
                                            class="btn btn-primary">Tạo nhóm</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- {{-- END Modal Create Group --}} -->
                        <!-- {{-- <button type="button" class="btn btn-sm btn-primary lh-0 bg-primary bg-opacity-50">
                                <img src="assets/crm/media/svg/crm/printer.svg" width="22" height="22" />
                            </button> --}} -->
                    </div>

                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Body-->
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between filter_toolbar gap-1">
                <div class="d-flex flex-wrap flex-md-nowrap flex-stack flex-grow-1 gap-1">
                    <select id="sources-filter" data-label="Nguồn MKT" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                        class="data-filter form-select form-select-sm" multiple>
                        @foreach ($sources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="status-filter" data-label="Chọn trạng thái" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                        class="data-filter form-select form-select-sm" multiple>
                        @foreach ($status as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="tags-filter" data-label="Chọn thẻ" data-placeholder="Chọn thẻ" data-control="select2" data-hide-search="true" data-multi-checkboxes="true" data-select-all="true" class="data-filter form-select form-select-sm" data-checkbox-type="badge" multiple>
                        @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="marjor-filter" data-label="Chọn ngành" data-control="select2"
                        data-multi-checkboxes="true" data-select-all="true" data-dropdown-css-class="w-300px"
                        class="data-filter form-select form-select-sm" multiple>
                        @foreach ($marjors as $marjor)
                        <option value="{{ $marjor->id }}">{{ $marjor->name }}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="assignment-filter" data-result-template="data-result-template-1" data-placeholder-length="140" data-label="Chọn tư vấn viên"
                        data-control="select2" data-multi-checkboxes="true" data-select-all="true" data-dropdown-css-class="w-fit" data-select-all-label="Tất cả tư vấn viên" 
                        class="data-filter form-select form-select-sm" multiple>
                            @foreach ($employees as $employee)
                            @php
                            $imgSrc = "assets/crm/media/svg/avatars/blank.svg";
                            @endphp
                            @if (!empty($employee->files) && is_countable($employee->files) && count($employee->files) > 0)
                            @foreach ($employee->files as $file)
                            @if ($file != null && $file->types == 0)
                            @php
                            $imgSrc = $file->image_url;
                            @endphp
                            @break
                            @endif
                            @endforeach
                            @endif
                        <option
                            data-item-data='{"avatar": "{{ $imgSrc }}", "tag": "{{ $employee->roles->name }}", "code": "{{ $employee->code }}"}'
                            value="{{ $employee->id }}">
                            {{ $employee->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                    <select id="config-filter" data-label="Chọn thời gian" data-placeholder="Chọn thời gian" data-control="select2" data-hide-search="true"
                        data-multi-checkboxes="false" data-select-all="false" class="data-filter form-select form-select-sm" data-checkbox-type="badge">
                        <option value="">Chọn thời gian</option>
                        @if (isset($filters) && count($filters) > 0)
                            @foreach ($filters as $filter)
                                <option onclick="data_click()" value="{{ $filter->id }}" 
                                    data-start-date="{{ \Carbon\Carbon::parse($filter->start_date)->format('d/m/Y') }}"
                                    data-end-date="{{ \Carbon\Carbon::parse($filter->end_date)->format('d/m/Y') }}">
                                    {{ $filter->name }}
                                </option>
                            @endforeach
                        @endif
                        <option value="#"> Tùy chỉnh thời gian </option>
                    </select>
                    <script id="data-result-template-1" type="script/template">
                        <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                    <img src="@{{avatar}}" class="h-40 align-self-center" alt="">
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                    <!--begin:Author Tag-->
                                    <span class="fs-8 text-primary text-nowrap bg-primary bg-opacity-20 rounded-full px-3 py-1 text-nowrap" style="background-color:rgba(3, 78, 162, 0.15)!important;">@{{tag}}</span>
                                    <!--end:Author Tag-->
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <span class="text-gray-800 text-hover-primary fs-6 fw-bold text-nowrap">@{{item.text}}</span>

                                        <span class="text-muted text-nowrap fw-semibold d-block fs-7">@{{code}}</span>
                                    </div>
                                    <!--end:Author-->
                                </div>
                                <!--end::Section-->
                            </div>
                        </script>
                    <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                </div>
                @include('crm.content.leads.option_select_time')
            </div>            
            <div class="table-responsive position-relative border rounded-3 my-3">
                <!--begin::Table-->                
                <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 display nowrap table-list-leads"
                    id="table-leads" data-ajax-url="/api/leads/ajax">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="w-40px" data-orderable="false"></th>
                            <th class="w-40px">ID</th>
                            <th class="text-nowrap fs-5 text-start">Họ và tên</th>
                            <th class="text-nowrap fs-5 text-start w-40px">Mã số sinh viên</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Số điện thoại</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Email</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Tư vấn viên</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Nguồn đăng ký</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Gắn thẻ</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Ngành học</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Mức độ tiềm năng</th>
                            <th class="text-nowrap fs-5 text-start pe-7">Thời gian</th>
                            <th class="text-nowrap fs-5 text-start pe-7 min-w-150px">Chức năng</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                </table>
                <!--end::Table-->
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Content-->
</div>
<div class="modal fade" id="employeesModal" tabindex="-1" aria-labelledby="employeesModalLabel"
    aria-hidden="true">
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
                                            style="width:max-content;"> {{ $employee->roles->name }} </span>

                                        <span
                                            class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold">{{ $employee->name }}</span>
                                        <span
                                            class="text-muted fw-semibold d-block fs-7">{{ $employee->code }}</span>
                                    </div>
                                    <input data-id="{{ $item->id ?? '' }}" type="radio"
                                        class="ms-auto form-check-input employee-radio" name="supporter"
                                        value="{{ $employee->id }}" data-name="{{ $employee->name }}"
                                        data-code="{{ $employee->code }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var selecter_status = ` class="lead_status_select w-auto form-select form-select-sm" data-label="Chọn trạng thái">
        @foreach ($status as $sItem)
            <option data-bg-color="{{ $sItem->bg_color }}" data-border-color="{{ $sItem->border_color }}" data-text-color="{{ $sItem->color }}" value="{{ $sItem->id }}">
                {{ $sItem->name }}
            </option>
        @endforeach
    </select>`;

    function option_click() {        
        document.getElementById("option_select_time").style.display = "block";
    }
</script>
<!-- include modal -->

<script type="module" src="/assets/crm/js/htecomJs/importUpdateCodeLeads.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/import_price_list.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/import_transactions.js"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/importLeads.js') }}"></script>
@include('crm.content.leads.modal.modal_import_price_list_for_leads')
@include('crm.content.leads.modal.modal_import_transactions_for_leads')
@include('crm.content.leads.modal.modal_import_leads')
@include('crm.content.leads.modal.modal_delete_leads')
@include('crm.content.leads.modal.modal_convert_leads')
@include('crm.content.leads.modal.modal_update_code_leads')
@include('crm.content.leads.modal_noti_lead')
@include('crm.content.leads.modal.modal_exports_for_leads')

@endsection