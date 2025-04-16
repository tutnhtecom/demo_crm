<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhân viên')
<script type="module" src="{{ asset('assets/crm/js/htecomJs/lead.js') }}" ></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/Lead/changeStatusLead.js') }}" ></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/deleteItem.js') }}" ></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/Lead/convertLead.js') }}" ></script>
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý nhân viên</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('crm.employees.list') }}">
                            Danh sách nhân viên
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Thông tin tài khoản</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->

        </div>
        <!--end::App Breadcrumb-->

        <!--begin::Content-->
        <div class="card">
            <!--begin::Toolbar-->
            <div class="card-header p-4">
                <!--begin::Toolbar wrapper-->
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <!--begin:back button-->
                        <a href="{{route('crm.employees.list')}}" class="btn btn-ghost btn-sm">
                            <img src="assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                        </a>
                        <!--end:back button-->
                        <!--begin::Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Thông tin tài khoản</h3>
                        <!--end::Title-->
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1 btn_group_employees_wrapper">
                            <button type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_task_target_create"
                                data-bs-toggle="modal" data-bs-target="#ti_modal_job_assign">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 18 18"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M7.92051 1.6875C7.83538 1.68749 7.76912 1.68748 7.70643 1.69128C6.9111 1.73944 6.21466 2.24141 5.91746 2.98069C5.89351 3.04027 5.87222 3.10397 5.84375 3.18938C5.78124 3.35763 5.63779 3.54899 5.43691 3.70189C5.41454 3.71892 5.39209 3.73499 5.36963 3.75013L6.82613 3.75C6.84777 3.70533 6.86773 3.65991 6.88585 3.61381L6.887 3.61119L6.89013 3.60376L6.89379 3.59467L6.89723 3.5857L6.89995 3.57824L6.90129 3.57448L6.90447 3.5653L6.90734 3.55683L6.90891 3.55213L6.91096 3.54587L6.91264 3.5406L6.91398 3.53626C6.9431 3.44904 6.95261 3.42185 6.96127 3.40032C7.09636 3.06428 7.41292 2.83611 7.77444 2.81422C7.79863 2.81275 7.82829 2.8125 7.93582 2.8125H10.0641C10.1717 2.8125 10.2013 2.81275 10.2255 2.81422C10.587 2.83611 10.9036 3.06428 11.0387 3.40032C11.0472 3.42153 11.0563 3.44773 11.0858 3.53624L11.0871 3.54053L11.0888 3.54584L11.0909 3.5521L11.0924 3.5568L11.0953 3.56525L11.0985 3.57441L11.0998 3.57817L11.1025 3.58561L11.1059 3.59453L11.1096 3.60354L11.1126 3.61087L11.1138 3.61358C11.132 3.65976 11.152 3.70525 11.1736 3.75L12.63 3.75013C12.6076 3.735 12.5852 3.71893 12.5628 3.70192C12.362 3.54904 12.2186 3.35769 12.156 3.18941L12.1538 3.1826C12.1269 3.10185 12.1059 3.03895 12.0825 2.98069C11.7853 2.24141 11.0888 1.73944 10.2935 1.69128C10.2308 1.68748 10.1646 1.68749 10.0794 1.6875H7.92051Z"
                                        fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.8943 3.75H5.10574C3.84021 3.75 3.20744 3.75 2.72451 3.99729C2.30432 4.21244 1.96244 4.55432 1.74729 4.97451C1.5 5.45744 1.5 6.09021 1.5 7.35574C1.5 7.67747 1.5 7.83833 1.55502 7.97395C1.60307 8.09238 1.68059 8.19657 1.78022 8.27662C1.89431 8.36829 2.04839 8.41452 2.35655 8.50696L6.375 9.7125V10.622C6.375 11.1962 6.71954 11.7256 7.26512 11.9472L7.68519 12.1179C8.52891 12.4607 9.47109 12.4607 10.3148 12.1179L10.7349 11.9472C11.2805 11.7256 11.625 11.1962 11.625 10.622V9.7125L15.6435 8.50696C15.9516 8.41452 16.1057 8.36829 16.2198 8.27662C16.3194 8.19657 16.3969 8.09238 16.445 7.97395C16.5 7.83833 16.5 7.67747 16.5 7.35574C16.5 6.09021 16.5 5.45744 16.2527 4.97451C16.0376 4.55432 15.6957 4.21244 15.2755 3.99729C14.7926 3.75 14.1598 3.75 12.8943 3.75ZM10.2 9H7.8C7.63431 9 7.5 9.13643 7.5 9.30472V10.622C7.5 10.7466 7.57469 10.8587 7.68858 10.905L8.10866 11.0756C8.68085 11.3081 9.31915 11.3081 9.89134 11.0756L10.3114 10.905C10.4253 10.8587 10.5 10.7466 10.5 10.622V9.30472C10.5 9.13643 10.3657 9 10.2 9Z"
                                        fill="white" />
                                    <path opacity="0.3"
                                        d="M2.25 8.47461C2.28334 8.48472 2.31879 8.49535 2.35655 8.50668L6.375 9.71221V10.6217C6.375 11.1959 6.71954 11.7253 7.26512 11.9469L7.68519 12.1176C8.52891 12.4604 9.47109 12.4604 10.3148 12.1176L10.7349 11.9469C11.2805 11.7253 11.625 11.1959 11.625 10.6217V9.71222L15.6435 8.50668C15.6812 8.49536 15.7166 8.48473 15.75 8.47462V9.22466C15.7493 11.9811 15.7238 14.7657 14.7615 15.6211C13.773 16.4998 12.182 16.4998 8.99998 16.4998C5.818 16.4998 4.22701 16.4998 3.2385 15.6211C2.27617 14.7657 2.25068 11.9811 2.25 9.22466V8.47461Z"
                                        fill="white" />
                                </svg>

                                <span class="d-none d-md-inline">Giao việc</span>
                            </button>
                            @php
                                $currentEmployeeId = auth()->user()->employees ? auth()->user()->employees->id : null;
                                $btnClass = ($currentEmployeeId == $dataId['data']->id) ? '' : 'crm_employees_edit';
                            @endphp

                            <a href="{{ route('crm.employees.edit', ['id' => $dataId['data']->id]) }}"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 {{ $btnClass }}">
                                <svg width="22" height="22" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z"
                                        fill="currentColor"/>
                                </svg>

                                <span class="d-none d-md-inline">Sửa thông tin</span>
                            </a>

                            {{-- <a href="{{ route('crm.employees.edit', ['id' => $dataId['data']->id]) }}"
                                class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_employees_edit">
                                <svg width="22" height="22" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z"
                                        fill="currentColor" />
                                    <path
                                        d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z"
                                        fill="currentColor" />
                                    <path
                                        d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z"
                                        fill="currentColor" />
                                </svg>

                                <span class="d-none d-md-inline">Sửa thông tin</span>
                            </a> --}}
                            @if(isset($dataId['data']) && isset($dataId['data']->user) && $dataId['data']->user->status == 0)
                            <a data-email-e="{{ $dataId['data']->email }}" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_employees_active h-100">
                                <svg width="22" height="22" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z"
                                        fill="currentColor"/>
                                </svg>
                                <span class="d-none d-md-inline">Kích hoạt</span>
                            </a>
                            @endif
                            {{-- <button type="button" class="btn btn-sm btn-secondary lh-0 d-flex align-items-center gap-1"
                                data-ti-button-action="lead-remove" data-ti-lead-confirm="true"
                                data-ti-lead-confirm-message="Xóa hồ sơ này" data-ti-lead-id="999" data-bs-toggle="modal"
                                data-bs-target="#deleteEmployeeModal">
                                <svg width="22" height="22" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.25 4.78948C2.25 4.42614 2.50904 4.13159 2.82857 4.13159L4.82675 4.13124C5.22377 4.1198 5.57401 3.83275 5.7091 3.40809C5.71266 3.39692 5.71674 3.38315 5.73139 3.33318L5.81749 3.03942C5.87018 2.8593 5.91608 2.70239 5.98031 2.56213C6.23407 2.00802 6.70356 1.62324 7.2461 1.52473C7.38343 1.49979 7.52886 1.4999 7.69579 1.50002H10.3043C10.4713 1.4999 10.6167 1.49979 10.754 1.52473C11.2966 1.62324 11.7661 2.00802 12.0198 2.56213C12.0841 2.70239 12.13 2.8593 12.1826 3.03942L12.2687 3.33318C12.2834 3.38315 12.2875 3.39692 12.291 3.40809C12.4261 3.83275 12.8458 4.12015 13.2429 4.13159H15.1714C15.491 4.13159 15.75 4.42614 15.75 4.78948C15.75 5.15282 15.491 5.44737 15.1714 5.44737H2.82857C2.50904 5.44737 2.25 5.15282 2.25 4.78948Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.06907 8.61114C7.37819 8.5786 7.65384 8.816 7.68475 9.14139L8.05975 13.0888C8.09066 13.4141 7.86513 13.7043 7.55601 13.7368C7.24689 13.7694 6.97125 13.532 6.94033 13.2066L6.56533 9.25922C6.53442 8.93383 6.75995 8.64368 7.06907 8.61114Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.931 8.61114C11.2401 8.64368 11.4657 8.93383 11.4348 9.25922L11.0598 13.2066C11.0288 13.532 10.7532 13.7694 10.4441 13.7368C10.135 13.7043 9.90942 13.4141 9.94033 13.0888L10.3153 9.14139C10.3462 8.816 10.6219 8.5786 10.931 8.61114Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M8.6967 16.5H9.3033C11.3903 16.5 12.4339 16.5 13.1123 15.8355C13.7908 15.1711 13.8602 14.0812 13.9991 11.9014L14.1991 8.76043C14.2744 7.57768 14.3121 6.98631 13.9717 6.61156C13.6313 6.23682 13.0565 6.23682 11.907 6.23682H6.09303C4.94345 6.23682 4.36866 6.23682 4.02829 6.61156C3.68792 6.98631 3.72558 7.57768 3.80091 8.76043L4.00094 11.9013C4.13977 14.0812 4.20919 15.1711 4.88767 15.8355C5.56615 16.5 6.60967 16.5 8.6967 16.5Z"
                                        fill="currentColor" />
                                </svg>

                                <span class="d-none d-md-inline">Xóa</span>
                            </button> --}}
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body p-0">
                <div class="row gx-0">
                    <div class="col-3 border-end border-gray-300">
                        <div
                            class="d-flex align-items-center flex-row flex-sm-column flex-md-column flex-lg-column flex-xl-row overflow-y-auto bg-gray-200 border-bottom border-start border-gray-300 p-6">
                            <!--begin::Symbol-->
                            <div
                                class="symbol rounded-full overflow-hidden symbol-100px symbol-md-90px me-5 me-sm-0 me-md-5 ">
                                <img src="{{ $imageEmployee ? $imageEmployee : asset('assets/crm/media/svg/avatars/blank.svg') }}"
                                    class="h-md-90 align-self-center" alt="">
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                <!--begin:Candidate Name-->
                                <div class="flex-grow-1 me-2 text-center text-lg-start">
                                    <div
                                        class="d-flex  flex-column flex-sm-column flex-lg-column flex-xl-row align-items-center gap-1 mb-2">
                                        <h1 class="text-primary text-hover-primary fs-2 fw-bold m-0">
                                            {{ $dataId['data']->name }} </h1>
                                        <span
                                            class="badge badge-light-primary rounded-pill fw-normal">{{ $dataId['data']->roles->name }}</span>
                                    </div>

                                    <span class="d-block fs-8">Trạng thái: <span class="text-success">Đang hoạt
                                            động</span></span>
                                    <span class="d-flex gap-1 align-items-center d-block fs-6">
                                        <i class="fas fa-user text-dark"></i>
                                        ID: {{ $dataId['data']->code }}
                                    </span>
                                    {{-- <span class="d-flex gap-1 align-items-center d-block fs-6">
                                        <i class="fas fa-location-dot text-dark"></i>
                                        Địa chỉ:
                                    </span> --}}
                                    <span class="d-flex gap-1 align-items-center d-block fs-6">
                                        <i class="fas fa-calendar text-dark"></i>
                                        Ngày tạo: {{ $dataId['data']->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                <!--end:Candidate Name-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <div class="d-flex flex-column py-4">
                            <div class="accordion accordion-borderless accordion-crm" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header fs-3" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Thông tin tài khoản
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne">
                                        <div class="accordion-body pt-1">
                                            <div class="rounded border border-gray-200 p-4">
                                                <div class="row gy-2">
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6 text-gray-700"><i
                                                            class="fas fa-user"></i> Họ và tên</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                                                        {{ $dataId['data']->name }}</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6 text-gray-700"><i
                                                            class="fas fa-phone-volume"></i> Số điện thoại</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                                                        {{ $dataId['data']->phone }}</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6 text-gray-700"><i
                                                            class="fas fa-envelope"></i> Email</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                                                        {{ $dataId['data']->email }}</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6 text-gray-700"><i
                                                            class="fas fa-calendar-days"></i> Ngày sinh</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                                                        {{ \Carbon\Carbon::parse($dataId['data']->date_of_birth)->format('d/m/Y') }}
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6 text-gray-700"><i
                                                            class="fas fa-briefcase"></i> Vị trí</div>
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                                                        {{ $dataId['data']->roles->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2 px-6">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- {{dd($dataId['data'])}} --}}
                                    {{-- <h2 class="fs-5 m-0">KPI</h2> --}}
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    {{-- <div data-ti-daterangepicker="true" data-ti-daterangepicker-initial="true"
                                        data-ti-daterangepicker-format="[Tháng] M, YYYY" data-ti-single-datepicker="true"
                                        data-ti-daterangepicker-opens="left"
                                        class="btn btn-sm btn-light d-flex align-items-center px-4">
                                        <!--begin::Display range-->
                                        <div class="text-gray-600 fw-bold">Loading date range...</div>
                                        <!--end::Display range-->
                                        <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                        </i>
                                    </div> --}}
                                    <!--end::Daterangepicker-->
                                </div>
                                {{-- <div class="d-flex flex-column align-items-center rounded rounded-3 border py-4"
                                    data-bs-toggle="modal" data-bs-target="#ti_modal_kpi_detail">
                                    <!-- Circular Progress Bar -->
                                    <div class="circular-progress" data-percent="60" style="--progress: 52;"></div>
                                    <!-- Text Below Progress Bar -->
                                    <div class="progress-label fw-bold">
                                        <span>10</span>/25 thí sinh
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center rounded rounded-3 border py-4">
                                    <!-- Circular Progress Bar -->
                                    <div class="circular-progress" data-percent="50" style="--progress: 50;"></div>
                                    <!-- Text Below Progress Bar -->
                                    <div class="progress-label fw-bold">
                                        <span>10.000.000</span>/12.000.000 thí sinh
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-9 border-bottom border-gray-300">
                        <div class="d-flex flex-column justify-content-start p-4">
                            <ul class="crm_tabs nav nav-tabs nav-small-tabs pb-3 border-bottom" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="candidate-list-tab" data-bs-toggle="tab"
                                        data-bs-target="#candidate-list" type="button" role="tab"
                                        aria-controls="candidate-list" aria-selected="false">
                                        <span>Danh sách thí sinh quản lý</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="activities-history-tab" data-bs-toggle="tab"
                                        data-bs-target="#activities-history" type="button" role="tab"
                                        aria-controls="activities-history" aria-selected="true">
                                        <span>Lịch sử tương tác</span>
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" id="job-calendar-tab" data-bs-toggle="tab"
                                        data-bs-target="#job-calendar" type="button" role="tab"
                                        aria-controls="job-calendar" aria-selected="false">
                                        <span>Lịch làm việc</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content mt-2" id="myTabContent">
                                <!--begin::Danh sách thí sinh quản lý-->
                                <div class="tab-pane fade show active" id="candidate-list" role="tabpanel"
                                    aria-labelledby="candidate-list-tab">
                                    <!--begin::Toolbar wrapper-->
                                    <div
                                        class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                                        <!--begin::Title-->
                                        <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách thí sinh</h3>
                                        <!--end::Title-->

                                        <!--begin::Search & Sort-->
                                        <div
                                            class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
                                            <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                                            <input id="search-table-leads" type="search"
                                            class="data-filter search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                            name="search" value="" placeholder="Tìm kiếm..." maxlength="20"/>
                                        </div>

                                        <!--begin::Search & Sort-->
                                        <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                                        <!--begin::Actions-->
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
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Toolbar wrapper-->
                                    <div class="table-responsive position-relative border rounded-3 my-3">
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 display nowrap table-list-leads"
                                            id="table-leads"
                                            data-employee-id="{{ $dataId['data']->id }}"
                                            data-employee-name="{{ $dataId['data']->name }}"
                                            data-ajax-url="/api/leads/ajax">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="bg-primary text-white">
                                                    <th class="w-40px" data-orderable="false"></th>
                                                    <th class="w-40px">ID</th>
                                                    <th class="text-nowrap fs-5 text-start">Họ và tên</th>
                                                    <th class="text-nowrap fs-5 text-start">Mã số sinh viên</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Số điện thoại</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Email</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Tư vấn viên</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Nguồn đăng ký</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Gắn thẻ</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Ngành học</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Mức độ tiềm năng</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7">Thời gian</th>
                                                    <th class="text-nowrap fs-5 text-start pe-7 min-w-150px">Chức năng
                                                    </th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                        </table>
                                    </div>
                                </div>
                                <!--end::Danh sách thí sinh quản lý-->
                                <!--begin::Lịch sử tương tác-->
                                <div class="tab-pane fade" id="activities-history" role="tabpanel"
                                    aria-labelledby="activities-history-tab">
                                    <!--begin::Toolbar wrapper-->
                                    <div
                                        class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                                        <!--begin::Title-->
                                        <h3 class="card-title text-dark fw-bolder m-md-0">Lịch sử tương tác</h3>
                                        <!--end::Title-->

                                        <!--begin::Search & Sort-->
                                        <div
                                            class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
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
                                                <input type="text"
                                                    class="search-input form-control form-control-sm border border-gray-300 rounded h-lg-40px ps-13"
                                                    name="search" value="" placeholder="Tìm kiếm..." />
                                                <!--end::Input-->
                                                <!--begin::Spinner-->
                                                <span
                                                    class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                                                    <span
                                                        class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
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
                                            {{-- <div class="vr d-none d-md-block text-gray-400 mx-4"></div> --}}
                                            {{-- <div class="d-flex align-items-center justify-content-start">
                                                <select class="lead_ordering_select w-auto form-select form-select-sm">
                                                    <option value="date-desc">Mới nhất</option>
                                                    <option value="date-asc">Cũ nhất</option>
                                                </select>
                                            </div> --}}
                                            {{-- <div class="vr d-none d-md-block text-gray-400 mx-4"></div> --}}
                                        </div>

                                        <!--begin::Search & Sort-->

                                        <!--begin::Actions-->
                                        {{-- <div class="d-flex justify-content-end align-items-center gap-1">
                                            <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                            <div data-ti-daterangepicker="true" data-ti-single-datepicker="true"
                                                data-ti-daterangepicker-initial="true"
                                                data-ti-daterangepicker-format="[Tháng] M, YYYY"
                                                data-ti-daterangepicker-opens="right"
                                                class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-2 py-2 mx-auto mx-md-none">
                                                <i class="ki-duotone ki-calendar-8 fs-1 me-2 ms-0">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                    <span class="path6"></span>
                                                </i>
                                                <!--begin::Display range-->
                                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                                                <!--end::Display range-->
                                            </div>
                                            <!--end::Daterangepicker-->
                                        </div> --}}
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Toolbar wrapper-->
                                    <div class="table-responsive position-relative border rounded-3 my-3">
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0"
                                            id="table">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="bg-primary text-white">
                                                    <th class="w-40px"></th>
                                                    <th class="text-nowrap fs-5 text-start">Khách hàng</th>
                                                    <th class="text-nowrap fs-5 text-start">Thông tin liên hệ</th>
                                                    <th class="text-nowrap fs-5 text-center w-60px">Liên hệ</th>
                                                    <th class="text-nowrap fs-5 text-start">Trạng thái</th>
                                                    <th class="text-nowrap fs-5 text-start min-w-150px">Thời gian</th>
                                                    <th class="text-nowrap fs-5 text-start">Nội dung</th>
                                                    <th class="text-nowrap fs-5 text-start">Ghi âm</th>
                                                    <th class="text-nowrap fs-5 text-start min-w-150px">Chức năng</th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                                <tr>
                                                    <td class="align-middle text-center ps-4">
                                                        <div class="form-check form-check-sm">
                                                            <input class="form-check-input inrow-checkbox" type="checkbox"
                                                                value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="/candidate/detail.html"
                                                                class="text-private fw-bold text-hover-primary text-nowrap mb-1 fs-6">Nguyễn
                                                                Văn A</a>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block  text-nowrap fs-5">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                Quận 3, HCM
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </i>

                                                                0123.456.789
                                                            </span>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                            fill="currentColor" />
                                                                    </svg>

                                                                </i>
                                                                example@gmail.com
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-sm btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M11.25 6.75L14.25 3.75M14.25 3.75V6M14.25 3.75H12"
                                                                    stroke="#7E7E7E" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                                    fill="#7E7E7E" />
                                                            </svg>
                                                        </button>
                                                    </td>

                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <span class="text-success">Kết thúc</span>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <div class="fs-6">09:49 • 27/04/2024</div>
                                                        <div class="fs-7 text-muted">5 phút 12 giây</div>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        -
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                height="30" viewBox="0 0 30 30" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                                    fill="#1EBB79" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-menu-trigger="click"
                                                            data-ti-menu-placement="bottom-end">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                                                width="18" height="18" />
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-ti-menu="true" id="ti-toolbar-candidate-note-editor-1"
                                                            style="">
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="text-start mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi
                                                                        chú nội dung cuộc gọi
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control"></textarea>
                                                                        <!--end::Input-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="update"
                                                                        data-candidate-id="997">Lưu</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="reset">Hủy</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                                            <img src="assets/crm/media/svg/crm/view.svg"
                                                                alt="Xem chi tiết" width="18" height="18" />
                                                        </a>
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                                                width="18" height="18" />
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-center ps-4">
                                                        <div class="form-check form-check-sm">
                                                            <input class="form-check-input inrow-checkbox" type="checkbox"
                                                                value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="/candidate/detail.html"
                                                                class="text-private fw-bold text-hover-primary text-nowrap mb-1 fs-6">Nguyễn
                                                                Văn A</a>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block  text-nowrap fs-5">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                Quận 3, HCM
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </i>

                                                                0123.456.789
                                                            </span>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                            fill="currentColor" />
                                                                    </svg>

                                                                </i>
                                                                example@gmail.com
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-sm btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M11.25 6.75L14.25 3.75M14.25 3.75V6M14.25 3.75H12"
                                                                    stroke="#7E7E7E" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                                    fill="#7E7E7E" />
                                                            </svg>
                                                        </button>
                                                    </td>

                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <span class="text-success">Kết thúc</span>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <div class="fs-6">09:49 • 27/04/2024</div>
                                                        <div class="fs-7 text-muted">5 phút 12 giây</div>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        -
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                height="30" viewBox="0 0 30 30" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                                    fill="#1EBB79" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-menu-trigger="click"
                                                            data-ti-menu-placement="bottom-end">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                                                width="18" height="18" />
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-ti-menu="true" id="ti-toolbar-candidate-note-editor-1"
                                                            style="">
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="text-start mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi
                                                                        chú nội dung cuộc gọi
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control"></textarea>
                                                                        <!--end::Input-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="update"
                                                                        data-candidate-id="997">Lưu</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="reset">Hủy</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                                            <img src="assets/crm/media/svg/crm/view.svg"
                                                                alt="Xem chi tiết" width="18" height="18" />
                                                        </a>
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                                                width="18" height="18" />
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-center ps-4">
                                                        <div class="form-check form-check-sm">
                                                            <input class="form-check-input inrow-checkbox" type="checkbox"
                                                                value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="/candidate/detail.html"
                                                                class="text-private fw-bold text-hover-primary text-nowrap mb-1 fs-6">Nguyễn
                                                                Văn A</a>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block  text-nowrap fs-5">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                Quận 3, HCM
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </i>

                                                                0123.456.789
                                                            </span>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                            fill="currentColor" />
                                                                    </svg>

                                                                </i>
                                                                example@gmail.com
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-sm btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                <path
                                                                    d="M14.25 3.75L11.25 6.75M11.25 6.75V4.5M11.25 6.75H13.5"
                                                                    stroke="#7E7E7E" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                                    fill="#7E7E7E" />
                                                            </svg>
                                                        </button>
                                                    </td>

                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <span class="text-success">Kết thúc</span>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <div class="fs-6">09:49 • 27/04/2024</div>
                                                        <div class="fs-7 text-muted">5 phút 12 giây</div>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        Khách cần tư vấn về học phí
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                height="30" viewBox="0 0 30 30" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                                    fill="#1EBB79" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-menu-trigger="click"
                                                            data-ti-menu-placement="bottom-end">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                                                width="18" height="18" />
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-ti-menu="true" id="ti-toolbar-candidate-note-editor-1"
                                                            style="">
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="text-start mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi
                                                                        chú nội dung cuộc gọi
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control"></textarea>
                                                                        <!--end::Input-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="update"
                                                                        data-candidate-id="997">Lưu</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="reset">Hủy</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                                            <img src="assets/crm/media/svg/crm/view.svg"
                                                                alt="Xem chi tiết" width="18" height="18" />
                                                        </a>
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                                                width="18" height="18" />
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-center ps-4">
                                                        <div class="form-check form-check-sm">
                                                            <input class="form-check-input inrow-checkbox" type="checkbox"
                                                                value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="/candidate/detail.html"
                                                                class="text-private fw-bold text-hover-primary text-nowrap mb-1 fs-6">Nguyễn
                                                                Văn A</a>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block  text-nowrap fs-5">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                Quận 3, HCM
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </i>

                                                                0123.456.789
                                                            </span>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                            fill="currentColor" />
                                                                    </svg>

                                                                </i>
                                                                example@gmail.com
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-sm btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 18 18" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M2.37868 3.87868C1.5 4.75736 1.5 6.17157 1.5 9C1.5 11.8284 1.5 13.2426 2.37868 14.1213C3.25736 15 4.67157 15 7.5 15H10.5C13.3284 15 14.7426 15 15.6213 14.1213C16.5 13.2426 16.5 11.8284 16.5 9C16.5 6.17157 16.5 4.75736 15.6213 3.87868C14.7426 3 13.3284 3 10.5 3H7.5C4.67157 3 3.25736 3 2.37868 3.87868ZM13.9321 5.6399C14.131 5.87855 14.0988 6.23324 13.8601 6.43212L12.2127 7.80492C11.548 8.35892 11.0092 8.80794 10.5336 9.11379C10.0382 9.43239 9.55581 9.63366 9 9.63366C8.44419 9.63366 7.96176 9.43239 7.46638 9.11379C6.99084 8.80794 6.45203 8.35892 5.78727 7.80493L4.1399 6.43212C3.90124 6.23324 3.869 5.87855 4.06788 5.6399C4.26676 5.40124 4.62145 5.369 4.8601 5.56788L6.47928 6.91719C7.179 7.50028 7.6648 7.90381 8.07494 8.1676C8.47196 8.42294 8.7412 8.50866 9 8.50866C9.2588 8.50866 9.52804 8.42294 9.92506 8.1676C10.3352 7.90381 10.821 7.50028 11.5207 6.91718L13.1399 5.56788C13.3786 5.369 13.7332 5.40124 13.9321 5.6399Z"
                                                                    fill="#7E7E7E" />
                                                            </svg>
                                                        </button>
                                                    </td>

                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <span class="text-danger">Gọi lỡ</span>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <div class="fs-6">09:49 • 27/04/2024</div>
                                                        <div class="fs-7 text-muted">5 phút 12 giây</div>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        -
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                height="30" viewBox="0 0 30 30" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                                    fill="#1EBB79" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-menu-trigger="click"
                                                            data-ti-menu-placement="bottom-end">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                                                width="18" height="18" />
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-ti-menu="true" id="ti-toolbar-candidate-note-editor-1"
                                                            style="">
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="text-start mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi
                                                                        chú nội dung cuộc gọi
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control"></textarea>
                                                                        <!--end::Input-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="update"
                                                                        data-candidate-id="997">Lưu</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="reset">Hủy</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                                            <img src="assets/crm/media/svg/crm/view.svg"
                                                                alt="Xem chi tiết" width="18" height="18" />
                                                        </a>
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                                                width="18" height="18" />
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-center ps-4">
                                                        <div class="form-check form-check-sm">
                                                            <input class="form-check-input inrow-checkbox" type="checkbox"
                                                                value="" id="flexCheckDefault">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="/candidate/detail.html"
                                                                class="text-private fw-bold text-hover-primary text-nowrap mb-1 fs-6">Nguyễn
                                                                Văn A</a>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block  text-nowrap fs-5">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                Quận 3, HCM
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                                            fill="currentColor" />
                                                                    </svg>
                                                                </i>

                                                                0123.456.789
                                                            </span>
                                                            <span
                                                                class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                                <i class="text-primary">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z"
                                                                            fill="currentColor" />
                                                                    </svg>

                                                                </i>
                                                                example@gmail.com
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-sm btn-ghost">
                                                            <svg width="17" height="18" viewBox="0 0 15 16"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M8.72156 14.3539L8.31499 15.0408C7.95262 15.653 7.04735 15.653 6.68498 15.0408L6.2784 14.3539C5.96305 13.8211 5.80537 13.5547 5.55209 13.4074C5.29882 13.2601 4.97994 13.2546 4.34218 13.2436C3.40066 13.2274 2.81017 13.1697 2.31494 12.9645C1.39608 12.5839 0.66605 11.8539 0.285452 10.9351C0 10.2459 0 9.37228 0 7.625V6.875C0 4.41993 0 3.19239 0.5526 2.29063C0.86181 1.78605 1.28605 1.36181 1.79063 1.0526C2.69239 0.5 3.91993 0.5 6.375 0.5H8.625C11.0801 0.5 12.3076 0.5 13.2094 1.0526C13.714 1.36181 14.1382 1.78605 14.4474 2.29063C15 3.19239 15 4.41993 15 6.875V7.625C15 9.37228 15 10.2459 14.7145 10.9351C14.3339 11.8539 13.6039 12.5839 12.6851 12.9645C12.1898 13.1697 11.5993 13.2274 10.6578 13.2436C10.02 13.2546 9.7011 13.2601 9.44788 13.4074C9.1946 13.5547 9.03692 13.8211 8.72156 14.3539Z"
                                                                    fill="#7E7E7E" />
                                                                <path
                                                                    d="M12.9297 5.89134C12.9126 5.71946 12.8395 5.58594 12.7102 5.49077C12.581 5.3956 12.4055 5.34801 12.1839 5.34801C12.0334 5.34801 11.9063 5.36932 11.8026 5.41193C11.6989 5.45313 11.6193 5.51066 11.5639 5.58452C11.5099 5.65838 11.483 5.74219 11.483 5.83594C11.4801 5.91406 11.4964 5.98225 11.532 6.04048C11.5689 6.09872 11.6193 6.14915 11.6832 6.19176C11.7472 6.23296 11.821 6.26918 11.9048 6.30043C11.9886 6.33026 12.0781 6.35583 12.1733 6.37713L12.5653 6.47088C12.7557 6.5135 12.9304 6.57031 13.0895 6.64134C13.2486 6.71236 13.3864 6.79972 13.5028 6.90341C13.6193 7.0071 13.7095 7.12926 13.7734 7.26989C13.8388 7.41051 13.8722 7.57173 13.8736 7.75355C13.8722 8.0206 13.804 8.25213 13.669 8.44815C13.5355 8.64276 13.3423 8.79404 13.0895 8.90199C12.8381 9.00852 12.5348 9.06179 12.1797 9.06179C11.8274 9.06179 11.5206 9.00781 11.2592 8.89986C10.9993 8.7919 10.7962 8.6321 10.6499 8.42046C10.505 8.20739 10.429 7.94389 10.4219 7.62997H11.3146C11.3246 7.77628 11.3665 7.89844 11.4403 7.99645C11.5156 8.09304 11.6158 8.16619 11.7408 8.21591C11.8672 8.26421 12.0099 8.28835 12.169 8.28835C12.3253 8.28835 12.4609 8.26563 12.576 8.22017C12.6925 8.17472 12.7827 8.11151 12.8466 8.03054C12.9105 7.94958 12.9425 7.85654 12.9425 7.75142C12.9425 7.65341 12.9134 7.57102 12.8551 7.50426C12.7983 7.4375 12.7145 7.38068 12.6037 7.33381C12.4943 7.28693 12.3601 7.24432 12.201 7.20597L11.7259 7.08665C11.358 6.99716 11.0675 6.85725 10.8544 6.6669C10.6413 6.47656 10.5355 6.22017 10.5369 5.89773C10.5355 5.63352 10.6058 5.4027 10.7479 5.20526C10.8913 5.00781 11.0881 4.85369 11.3381 4.7429C11.5881 4.6321 11.8722 4.57671 12.1903 4.57671C12.5142 4.57671 12.7969 4.6321 13.0384 4.7429C13.2813 4.85369 13.4702 5.00781 13.6051 5.20526C13.7401 5.4027 13.8097 5.63139 13.8139 5.89134H12.9297Z"
                                                                    fill="white" />
                                                                <path
                                                                    d="M5.07227 4.63637H6.21005L7.41175 7.56819H7.46289L8.6646 4.63637H9.80238V9H8.90749V6.15981H8.87127L7.74201 8.9787H7.13263L6.00337 6.14915H5.96715V9H5.07227V4.63637Z"
                                                                    fill="white" />
                                                                <path
                                                                    d="M3.50781 5.89134C3.49077 5.71946 3.41761 5.58594 3.28835 5.49077C3.15909 5.3956 2.98366 5.34801 2.76207 5.34801C2.61151 5.34801 2.48438 5.36932 2.38068 5.41193C2.27699 5.45313 2.19744 5.51066 2.14205 5.58452C2.08807 5.65838 2.06108 5.74219 2.06108 5.83594C2.05824 5.91406 2.07457 5.98225 2.11009 6.04048C2.14702 6.09872 2.19744 6.14915 2.26136 6.19176C2.32528 6.23296 2.39915 6.26918 2.48295 6.30043C2.56676 6.33026 2.65625 6.35583 2.75142 6.37713L3.14347 6.47088C3.33381 6.5135 3.50852 6.57031 3.66761 6.64134C3.8267 6.71236 3.96449 6.79972 4.08097 6.90341C4.19744 7.0071 4.28764 7.12926 4.35156 7.26989C4.4169 7.41051 4.45028 7.57173 4.4517 7.75355C4.45028 8.0206 4.3821 8.25213 4.24716 8.44815C4.11364 8.64276 3.92045 8.79404 3.66761 8.90199C3.41619 9.00852 3.11293 9.06179 2.75781 9.06179C2.40554 9.06179 2.09872 9.00781 1.83736 8.89986C1.57741 8.7919 1.37429 8.6321 1.22798 8.42046C1.0831 8.20739 1.0071 7.94389 1 7.62997H1.89276C1.9027 7.77628 1.9446 7.89844 2.01847 7.99645C2.09375 8.09304 2.19389 8.16619 2.31889 8.21591C2.44531 8.26421 2.58807 8.28835 2.74716 8.28835C2.90341 8.28835 3.03906 8.26563 3.15412 8.22017C3.2706 8.17472 3.3608 8.11151 3.42472 8.03054C3.48864 7.94958 3.5206 7.85654 3.5206 7.75142C3.5206 7.65341 3.49148 7.57102 3.43324 7.50426C3.37642 7.4375 3.29261 7.38068 3.18182 7.33381C3.07244 7.28693 2.93821 7.24432 2.77912 7.20597L2.30398 7.08665C1.93608 6.99716 1.6456 6.85725 1.43253 6.6669C1.21946 6.47656 1.11364 6.22017 1.11506 5.89773C1.11364 5.63352 1.18395 5.4027 1.32599 5.20526C1.46946 5.00781 1.66619 4.85369 1.91619 4.7429C2.16619 4.6321 2.45028 4.57671 2.76847 4.57671C3.09233 4.57671 3.375 4.6321 3.61648 4.7429C3.85938 4.85369 4.0483 5.00781 4.18324 5.20526C4.31818 5.4027 4.38778 5.63139 4.39205 5.89134H3.50781Z"
                                                                    fill="white" />
                                                            </svg>
                                                        </button>
                                                    </td>

                                                    <td class="align-middle text-center px-2 px-md-4 py-4">
                                                        <span class="text-success">Kết thúc</span>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <div class="fs-6">09:49 • 27/04/2024</div>
                                                        <div class="fs-7 text-muted">5 phút 12 giây</div>
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        -
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn btn-ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                height="30" viewBox="0 0 30 30" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                                    fill="#1EBB79" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-menu-trigger="click"
                                                            data-ti-menu-placement="bottom-end">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                                                width="18" height="18" />
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                                            data-ti-menu="true" id="ti-toolbar-candidate-note-editor-1"
                                                            style="">
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="text-start mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi
                                                                        chú nội dung cuộc gọi
                                                                        <!--begin::Input-->
                                                                        <textarea class="form-control"></textarea>
                                                                        <!--end::Input-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="submit" class="btn btn-primary"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="update"
                                                                        data-candidate-id="997">Lưu</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light btn-active-light-primary me-2"
                                                                        data-ti-menu-dismiss="true"
                                                                        data-ti-candidate-table-action="reset">Hủy</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                                            <img src="assets/crm/media/svg/crm/view.svg"
                                                                alt="Xem chi tiết" width="18" height="18" />
                                                        </a>
                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                                                width="18" height="18" />
                                                        </button>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--begin::Pagination-->
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-center">
                                            <div class="form-check form-check-sm cursor-pointer">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="select_all" data-select-all="true" data-target="table">
                                                <label class="form-check-label text-gray-900" for="select_all">
                                                    Chọn tất cả
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <nav aria-label="...">
                                                <ul class="pagination">
                                                    <li class="page-item disabled">
                                                        <a class="page-link" href="#" tabindex="-1">Trang
                                                            trước</a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                    <li class="page-item active">
                                                        <a class="page-link" href="#">2 <span
                                                                class="sr-only">(current)</span></a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#">Trang tiếp</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="col-3"><!--placeholder--></div>
                                    </div>
                                    <!--end::Pagination-->
                                </div>
                                <!--end::Lịch sử tương tác-->
                                <!--begin::Lịch làm việc-->
                                <div class="tab-pane fade" id="job-calendar" role="tabpanel"
                                    aria-labelledby="job-calendar-tab">
                                    <!--begin::Toolbar wrapper-->
                                    <div
                                        class="app-toolbar-wrapper d-flex flex-column flex-wrap align-justify-start w-100 gap-2 mt-3">

                                        <!--begin::Title-->
                                        <h3 class="card-title text-dark fw-bolder m-md-0">Lịch làm việc</h3>
                                        <!--end::Title-->
                                {{-- {{dd($tasks->getData())}} --}}
                                        <!--begin::Search by Month-->
                                        <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                                        {{-- <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                                            <!--begin::Hidden input(Added to disable form autocomplete)-->
                                            <input type="hidden" />
                                            <!--end::Hidden input-->

                                            <!--begin::Input Group-->
                                            <div class="input-group">
                                                <input type="text" name="search_query"
                                                    class="search-input form-control border border-gray-300 ps-13"
                                                    value="" placeholder="Tìm kiếm..." />
                                                <button type="submit" class="input-group-text btn btn-primary">
                                                    Tìm lịch làm việc
                                                </button>
                                                <select name="search_month" class="input-group-text">
                                                    <option value="0">Tất cả</option>
                                                    <option value="1">Tháng 1</option>
                                                    <option value="2">Tháng 2</option>
                                                    <option value="3">Tháng 3</option>
                                                    <option value="4">Tháng 4</option>
                                                    <option value="5">Tháng 5</option>
                                                    <option value="6">Tháng 6</option>
                                                    <option value="7">Tháng 7</option>
                                                    <option value="8">Tháng 8</option>
                                                    <option value="9">Tháng 9</option>
                                                    <option value="10">Tháng 10</option>
                                                    <option value="11">Tháng 11</option>
                                                    <option value="12">Tháng 12</option>
                                                </select>
                                            </div>
                                            <!--end::Input Group-->
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"
                                                style="z-index: 6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--end::Icon-->
                                            <!--begin::Spinner-->
                                            <span
                                                class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                                                style="z-index: 6">
                                                <span
                                                    class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
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
                                        </form> --}}
                                        <!--end::Form-->
                                        <!--end::Search by Month-->
                                    </div>
                                    <!--end::Toolbar wrapper-->
                                    <!--begin::Calendar-->
                                    <div id="ti_calendar_app" class="mt-6"></div>
                                    <!--end::Calendar-->
                                </div>
                                <!--end::Trường tùy chỉnh-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Content-->


    </div>

    <div class="modal fade modal_delete" id="deleteEmployeeModal" tabindex="-1"
        aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:160px;">
            <div class="modal-content" style="max-width: 444px">
                <div class="">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center"
                        style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa hồ sơ này? </div>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <button id="btn_delete_employee" type="button" class="btn btn-primary btn_submit_delete"
                            data-id="{{ $dataId['data']->id }}">Xác nhận</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        var selecter_status = ` class="lead_status_select w-auto form-select form-select-sm" data-label="Chọn trạng thái">
                                    @foreach ($status['status'] as $item)
                                        @php
                                            $sItem = $item->toArray();
                                        @endphp
                                        <option data-bg-color="{{ $sItem['bg_color'] ?? $sItem['bg_color'] }}" data-border-color="{{ $sItem['border_color'] }}" data-text-color="{{ $sItem['color'] }}" value="{{ $sItem['id'] }}">
                                            {{ $sItem['name'] }}
                                        </option>
                                    @endforeach
                                </select>`;
    </script>

    @include('crm.content.employees.employees_modal_task')

    <script type="module" src="/assets/crm/js/htecomJs/activeEmployee.js"></script>
@endsection
