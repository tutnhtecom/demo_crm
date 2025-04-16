<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhân viên')
<script type="module" src="{{ asset('assets/crm/js/htecomJs/deleteItem.js') }}" ></script>
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="/crm" class="text-gray-500">
                            <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý nhân viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Danh sách nhân viên</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->

        </div>
        <!--end::App Breadcrumb-->
        <!--begin::Overview Stats-->
        <div class="app-overview-stats">
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card p-2 mb-2 mb-md-0">
                        <!--begin::Details-->
                        <div class="d-flex align-items-center">                          
                            @php
                                $countRolesId3 = 0;
                                if (!is_null($dataDB)) {
                                    $countRolesId3 = collect($dataDB)->where('roles_id', 3)->count();
                                    $countRolesId1 = collect($dataDB)->where('roles_id', 1)->count();
                                    $employeeActive = collect($dataDB)->where('deleted_at', null)->count();
                                    $employeeDisable = collect($dataDB)->filter(function ($employee) {
                                        return $employee->deleted_at !== null;
                                    })->count();
                                    
                                }
                            @endphp
                            <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-primary">{{ $countRolesId3 }}</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-primary text-hover-primary mb-2">Chuyên viên tuyển sinh</span>
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
                                <span class="fs-2 fw-bold text-warning"> {{$countRolesId1}} </span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-warning text-hover-warning mb-2">Admin</span>
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
                                <span class="fs-2 fw-bold text-success">{{$employeeActive}}</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-success text-hover-success mb-2">Đang hoạt động</span>
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
                                <span class="fs-2 fw-bold text-danger">{{ $employeeDisable }}</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-danger text-hover-danger mb-2">Ngưng hoạt động</span>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Overview Stats-->
        <!--begin::Content-->
        <div class="card">
            <!--begin::Toolbar-->
            <div class="card-header p-4 border-0">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách nhân viên</h3>
                    <!--end::Title-->

                    <!--begin::Search & Sort-->
                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
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
                            <input id="search_employees" type="text"
                                class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm..." data-ti-search-element="input" />
                            <!--end::Input-->
                            <!--begin::Spinner-->
                            <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                                data-ti-search-element="spinner">
                                <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                            </span>                           
                            <!--end::Spinner-->
                            <!--begin::Reset-->
                            <span
                                class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4"
                                data-ti-search-element="clear">
                                <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Reset-->

                        </form>
                        <!--end::Form-->
                        <!-- <div class="vr d-none d-md-block text-gray-400 mx-8"></div> -->
                        <!-- <div class="d-flex align-items-center justify-content-start">
                            <select class="lead_ordering_select w-auto form-select">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select>
                        </div> -->
                        <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                    </div>
                    <!--begin::Search & Sort-->
                    <div class="d-flex justify-content-end mx-4 ">
                        <select id="semesterSelect" name="semesterSelect" aria-label="Chọn Học kỳ " 
                                data-placeholder="Chọn Học kỳ" class="form-select h-lg-40px">
                            @foreach ($dvlk_semesters as $semester)
                                @if($semester->types == 0)
                                    <option value="{{$semester->id}}" data-name="{{$semester->note}}">{{$semester->note}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1 btn_group_employees">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#ti_modal_send_notification"
                                class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_notification_create">
                                <img src="/assets/crm/media/svg/crm/letter-unread.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Gửi thông báo</span>
                            </a>
                            <a href="{{ route('crm.employees.create') }}" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_employees_create">
                                <img src="/assets/crm/media/svg/crm/add-circle.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Thêm mới</span>
                            </a>
                            <button id="btn_export_employees" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                                <img src="/assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Xuất file</span>
                            </button>
                            <button id="btn_import_employees" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_employees_create" data-bs-toggle="modal" data-bs-target="#importEmployeesModal">
                                <img src="/assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Nhập dữ liệu</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary lh-0 bg-primary bg-opacity-50">
                                <img src="/assets/crm/media/svg/crm/printer.svg" width="22" height="22" />
                            </button>
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body p-4 pt-0">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table id="table-employees" class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th rowspan="2" class="w-40px"></th>
                                <th rowspan="2" class="w-40px">ID</th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-start">Tài khoản</th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-start">Thông tin Liên hệ
                                </th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center">Vai trò</th>
                                <th colspan="2" class="text-nowrap align-middle fs-5 text-center w-350px">KPI được giao
                                </th>
                                <th colspan="2" class="text-nowrap align-middle fs-5 text-center w-350px">KPI đạt được
                                </th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center">Chức năng</th>
                            </tr>
                            <tr class="bg-primary text-white secondary-table-head">
                                <th class="text-nowrap align-middle fs-5 text-center w-175px">Học phí (VND/Khoá)</th>
                                <th class="text-nowrap align-middle fs-5 text-center w-175px secondary-bordered">Thí sinh
                                    (TS/Khoá)</th>
                                <th class="text-nowrap align-middle fs-5 text-center w-175px">Học phí (VND/Khoá)</th>
                                <th class="text-nowrap align-middle fs-5 text-center w-175px secondary-bordered">Thí sinh
                                    (TS/Khoá)</th>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            @php
                                $currentMonth = now()->format('Y-m');
                            @endphp
                            @if(isset($data['data']) && count($data['data']) > 0)
                                @foreach ($data['data'] as $employee)
                                    <tr>
                                        <td class="align-middle text-center ps-2">

                                        </td>
                                        <td class="align-middle text-center ps-2">
                                            {{$employee['id']}}
                                        </td>
                                        <td class="align-middle px-2 px-md-4 py-4">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                                    @if (!empty($employee['files']))
                                                        @foreach ($employee['files'] as $file)
                                                            @if ($file['types'] == 0 && $file != null)
                                                                @php
                                                                    $employeeAvatar = $file['image_url'];
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <img src="{{$employeeAvatar}}" class="h-40 align-self-center" alt="">
                                                    @else
                                                        <img src="assets/crm/media/svg/avatars/blank.svg" class="h-40 align-self-center" alt="">
                                                    @endif
                                                </div>

                                                <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                                    <div class="flex-grow-1 me-2">
                                                        @php
                                                            $currentEmployeeId = auth()->user()->employees ? auth()->user()->employees->id : null;
                                                            $link = ($currentEmployeeId == $employee['id']) ? route('crm.employee.detail', ['id' => $employee['id']]) : '/crm/employees';
                                                        @endphp
                                                        <a href="{{ auth()->user()->id == 1 ? route('crm.employee.detail', ['id' => $employee['id']]) : $link }}" class="text-gray-800 text-hover-primary text-nowrap fs-5 fw-bold">{{ $employee['name'] }}</a>
                                                        <span class="text-muted fw-semibold d-block fs-6">{{ $employee['code'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-start px-2 px-md-4 py-4">
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                    <i class="text-primary">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </i>
                                                    {{ $employee['phone'] }}
                                                </span>
                                                <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                    <i class="text-primary">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                fill="currentColor" />
                                                        </svg>

                                                    </i>
                                                    {{ $employee['email'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center px-2 px-md-4 py-4">
                                            <span class="badge rounded-full px-4
                                                {{ $employee['roles']['name'] == 'Tư vấn viên' ? 'badge-light-primary badge-primary' : '' }}
                                                {{ $employee['roles']['name'] == 'Admin' ? 'badge-light-danger badge-danger' : 'badge-light-primary badge-primary' }}">
                                                {{ $employee['roles']['name'] ?? null }}
                                            </span>
                                        </td>
                                        @php
                                            $price = 0;
                                            $quantity = 0;                                            
                                        @endphp
                                        @if (isset($employee['kpis']) && is_array($employee['kpis']))
                                            @foreach ($employee['kpis'] as $kpi)
                                                @php
                                                    // Chuyển đổi from_date và to_date thành định dạng Y-m
                                                    $fromMonth = isset($kpi['from_date']) ? \Carbon\Carbon::parse($kpi['from_date'])->format('Y-m') : null;
                                                    $toMonth = isset($kpi['to_date']) ? \Carbon\Carbon::parse($kpi['to_date'])->format('Y-m') : null;
                                                @endphp
                                                    @php
                                                        $price = $kpi['price'];
                                                        $quantity = $kpi['quantity'];
                                                    @endphp
                                                {{-- @if ($fromMonth && $toMonth && $fromMonth <= $currentMonth && $currentMonth <= $toMonth)
                                                    @php
                                                        // Cập nhật giá trị price và quantity khi tìm thấy dữ liệu hợp lệ
                                                        $price = $kpi['price'];
                                                        $quantity = $kpi['quantity'];
                                                        break; // Thoát vòng lặp khi tìm thấy kết quả phù hợp
                                                    @endphp
                                                @endif --}}
                                            @endforeach
                                        @endif
                                        <td class="align-middle text-center">                                            
                                            {{ number_format($price, 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $quantity }}
                                        </td>
                                        {{-- <td class="align-middle text-center">
                                            120000
                                        </td>
                                        <td class="align-middle text-center">
                                            10
                                        </td> --}}
                                        <td class="align-middle text-center col_progress_price">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                    <span class="fs-6">{{ $employee['total_price'] }}</span>
                                                    <span class="fw-bold fs-6 percent_price">{{ $employee['rate_price'] }}%</span>
                                                </div>
                                                <div class="h-10px mx-3 w-100 mb-3 rounded" style="background-color: rgba(225, 225, 225, 1)">
                                                    <div class="bg-success rounded h-10px" role="progressbar" style="width: 0%;max-width:100%"
                                                        aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </td>
                                        <td class="align-middle text-center col_progress_student">
                                            <!--begin::Progress-->
                                            <div class="d-flex align-items-center flex-column mt-3">
                                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                    <span class="fs-6">{{$employee['total_quantity']}}</span>
                                                    <span class="fw-bold fs-6 percent_student">{{$employee['rate_quantity']}}%</span>
                                                </div>
                                                <div class="h-10px mx-3 w-100 mb-3 rounded" style="background-color: rgba(225, 225, 225, 1)">
                                                    <div class="bg-success rounded h-10px" role="progressbar" style="width: 0%;max-width:100%;"
                                                        aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                        </td>
                                        <td class="align-middle text-center fs-5 px-2 px-md-4 py-4 btn_action_employees_wrapper">
                                            @php
                                                $currentEmployeeId = auth()->user()->employees ? auth()->user()->employees->id : null;
                                                $btnClass = ($currentEmployeeId == $employee['id']) ? '' : 'crm_employees_edit';
                                                $link = ($currentEmployeeId == $employee['id']) ? route('crm.employee.detail', ['id' => $employee['id']]) : '/crm/employees';
                                            @endphp

                                            <a href="{{ auth()->user()->id == 1 ? route('crm.employee.detail', ['id' => $employee['id']]) : $link }}" class="btn btn-ghost p-1 {{ $btnClass }}">
                                                <img src="/assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                            </a>
                                            {{-- <a href="{{ route('crm.employee.detail', ['id' => $employee['id']]) }}" class="btn btn-ghost p-1 crm_employees_edit">
                                                <img src="/assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                    height="18" />
                                            </a> --}}

                                            <button type="button" class="btn btn-ghost p-1 btn_noti_employee crm_notification_create" data-bs-toggle="modal" data-bs-target="#ti_modal_send_notification" data-email="{{$employee['email']}}">
                                                <img src="/assets/crm/media/svg/crm/send.svg" alt="Gửi thông báo" width="18"
                                                    height="18" />
                                            </button>
                                            @include('crm.content.employees.modal_delete_employee')
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->


    </div>

    <div class="modal fade modal_import" id="importEmployeesModal" tabindex="-1" aria-labelledby="importEmployeesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm danh sách nhân viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="file_import_employees" type="file">
                    <p class="mt-3" style="margin-bottom:0"> Tải file mẫu: <a href="assets/file/employees_template.xlsx">FILE MẪU</a> </p>
                    <p class="error_log_employees mt-3" style="margin-bottom:0"></p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="import_btn_employees_now" type="button" class="btn btn-primary">Tải lên</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="false">
        <div class="modal-dialog" style="margin-top:160px;">
            <div class="modal-content" style="max-width: 444px">
                <div class="">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                    </div>
                    <div class="notice-text d-flex flex-column justify-content-center align-items-center"
                        style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa hồ sơ này? </div>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <button id="btn_delete_item" data-type="employee" data-dataTableName="#table-employees" type="button" class="btn btn-primary" data-id="0">Xác
                            nhận</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Create Group --}}
    <div class="modal fade" id="groupLeadsModal" tabindex="-1"
    aria-labelledby="groupLeadsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo nhóm thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="group_input_wrapper">
                    <p class="notice-text"></p>
                    <label for="" class="mb-1">Tên nhóm <span
                            class="text-danger">*</span></label>
                    <input id="name_group_input" type="text"
                        placeholder="VD: Nhóm nhân viên 1">
                    <p class="error-input mt-1"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_group_leads_submit" type="button" data-types="2"
                    class="btn btn-primary">Tạo nhóm</button>
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(()=>{
        function updateURLParam(key, value) {
            let url = new URL(window.location);
            url.searchParams.set(key, value);
            window.history.pushState({}, '', url);
        }

        $(document).ready(function () {
            let urlParams = new URLSearchParams(window.location.search);
            let semesterId = urlParams.get('semesters_id');

            if (semesterId) {
                $("#semesterSelect").val(semesterId); // Chỉ cần gán giá trị, không cần trigger change
            }
        });

        $(document).on('change', '#semesterSelect', function (e) {
            let id = e.target.value;
            updateURLParam("semesters_id", id);
            document.location.reload();
        });

        function updateURLParam(key, value) {
            let url = new URL(window.location.href);
            url.searchParams.set(key, value);
            window.history.pushState({}, '', url); // Cập nhật URL mà không reload
        }


        // $(document).on('change', '#semesterSelect', (e) => {
        //     let id = e.target.value;
        //     updateURLParam("semesters_id", id);
        //     const urlParams = new URLSearchParams(window.location.search);
        //     const semesterId = urlParams.get('semesters_id');
        //     console.log(semesterId);
            
        //     if (semesterId) {
        //         $("#semesterSelect").val(semesterId).trigger("change"); // Gán giá trị và kích hoạt sự kiện change
        //     }
        //     document.location.reload();
        // });
        
    });
        
</script>
@include('crm.content.employees.modal_noti_employees')
@endsection
