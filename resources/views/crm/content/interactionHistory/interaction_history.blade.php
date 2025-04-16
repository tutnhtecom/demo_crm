<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý thí sinh mới')
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
                    <li class="breadcrumb-item text-primary">Lịch sử tương tác</li>
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
                            <!--begin::Number-->
                            <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                                <span class="fs-2 fw-bold text-primary">186</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-primary text-hover-primary mb-2">Cuộc gọi</span>
                                <div class="fw-semibold fs-7 text-muted">Số cuộc gọi đi, đến của tư vấn viên với thí sinh
                                    mới</div>
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
                                <span class="fs-2 fw-bold text-warning">39</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-warning text-hover-warning mb-2">Email</span>
                                <div class="fw-semibold fs-7 text-muted">Số email gửi đi, đến của tư vấn viên với thí sinh
                                    mới</div>
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
                                <span class="fs-2 fw-bold text-success">09</span>
                            </div>
                            <!--end::Number-->
                            <!--begin::Details-->
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-success text-hover-success mb-2">SMS</span>
                                <div class="fw-semibold fs-7 text-muted">Số SMS gửi đi, đến của tư vấn viên với thí sinh mới
                                </div>
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
                                <span class="fs-5 fw-bold text-danger text-hover-danger mb-2">Hủy liên hệ</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh hủy liên hệ</div>
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
            <div class="card-header p-4">
                <!--begin::Toolbar wrapper-->
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Lịch sử tương tác</h3>
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
                            <input type="text"
                                class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm..." />
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
                        <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                        <div class="d-flex align-items-center justify-content-start">
                            <select class="lead_ordering_select w-auto form-select">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select>
                        </div>
                        <div class="vr d-none d-xl-block text-gray-400 mx-8"></div>
                    </div>
                    <!--begin::Search & Sort-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1">
                            <button type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">
                                <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Xuất file</span>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary lh-0 bg-primary bg-opacity-50">
                                <img src="assets/crm/media/svg/crm/printer.svg" width="22" height="22" />
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Body-->
            <div class="card-body p-4">
                <div
                    class="d-flex flex-wrap flex-lg-wrap flex-xl-nowrap flex-column flex-lg-row align-items-center filter_toolbar d-flex flex-stack gap-2 overflow-y-auto">
                    <div class="d-flex flex-wrap flex-md-nowrap flex-md-row flex-grow-1 gap-1 gap-lg-0">
                        <select data-label="Tất cả thí sinh" data-placeholder="Tất cả thí sinh" data-control="select2"
                            data-hide-search="false" class="form-select form-select-sm">
                            <option></option>
                            <option value="1">Nguyễn Văn A</option>
                            <option value="2">Nguyễn Văn B</option>
                            <option value="3">Phạm Thị C</option>
                        </select>
                        <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                        <select data-label="Hình thức liên hệ" data-placeholder="Hình thức liên hệ" data-control="select2"
                            data-multi-checkboxes="true" data-select-all="true" data-hide-search="true"
                            class="form-select form-select-sm" multiple>

                            <option value="1">Gọi đi</option>
                            <option value="2">Gọi đến</option>
                            <option value="3">Email</option>
                            <option value="4">SMS</option>
                        </select>
                        <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                        <select data-result-template="data-result-template-1" data-label="Chọn tư vấn viên"
                            data-control="select2" data-multi-checkboxes="true" data-select-all="true"
                            data-select-all-label="Tất cả tư vấn viên" data-dropdown-css-class=""
                            class="form-select form-select-sm" multiple>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/svg/avatars/blank.svg", "tag": "Tư vấn viên", "code": "NV12345"}'
                                value="1">Nguyễn Thị A</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-1.jpg", "tag": "Tư vấn viên", "code": "NV12345"}'
                                value="2">Nguyễn Thị B</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-2.jpg", "tag": "Tư vấn viên", "code": "NV12346"}'
                                value="3">Nguyễn Thị C</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-3.jpg", "tag": "Tư vấn viên", "code": "NV12347"}'
                                value="4">Nguyễn Thị D</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-4.jpg", "tag": "Tư vấn viên", "code": "NV12348"}'
                                value="5">Nguyễn Thị E</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-5.jpg", "tag": "Tư vấn viên", "code": "NV12349"}'
                                value="6">Nguyễn Thị F</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-5.jpg", "tag": "Tư vấn viên", "code": "NV12349"}'
                                value="7">Nguyễn Thị G LONG LONG</option>
                            <option
                                data-item-data='{"avatar": "assets/crm/media/avatars/300-5.jpg", "tag": "Tư vấn viên", "code": "NV12349"}'
                                value="8">Nguyễn Thị H LONG LONG LONG LONG</option>

                        </select>
                        <div class="vr d-none d-md-block text-gray-400 mx-3"></div>
                        <select data-label="Chọn trạng thái" data-control="select2" data-hide-search="true"
                            data-multi-checkboxes="true" class="form-select form-select-sm" multiple>
                            <option value="0">Tất cả</option>
                            <option value="1">Kết thúc</option>
                            <option value="2">Gọi lỡ</option>
                            <option value="3">Đã gửi</option>
                            <option value="4">Gửi lỗi</option>
                        </select>
                        <script id="data-result-template-1" type="script/template">
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                <img src="/assets/crm/media/avatars/300-1.jpg" class="h-50 align-self-center" alt="">
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                <!--begin:Author Tag-->
                                <span class="fs-8 text-primary text-nowrap bg-primary bg-opacity-20 rounded-full px-3 py-1">tag</span>
                                <!--end:Author Tag-->
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <span class="text-gray-800 text-nowrap text-hover-primary fs-6 fw-bold">text</span>

                                    <span class="text-muted fw-semibold d-block fs-7">code</span>
                                </div>
                                <!--end:Author-->
                            </div>
                            <!--end::Section-->
                        </div>
                    </script>
                        <div class="vr d-none d-xl-block text-gray-400 mx-3"></div>
                    </div>
                    <div class="d-flex flex-stack">
                        <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                        <div data-ti-daterangepicker="true" data-ti-daterangepicker-initial="true"
                            data-ti-daterangepicker-opens="right"
                            class="btn btn-sm text-nowrap btn-light d-flex align-items-center border border-gray-300 px-4 py-1">
                            <!--end::Display range-->
                            <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                            <!--begin::Display range-->
                            <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                        </div>
                        <!--end::Daterangepicker-->
                    </div>
                    <div class="d-flex flex-stack">
                        <div class="vr d-none d-xl-block text-gray-400 mx-3"></div>
                        <button type="button"
                            class="btn btn-sm btn-primary text-nowrap lh-1 lh-md-0 bg-primary bg-opacity-50">
                            <i class="fas fa-check"></i>
                            <span>Áp dụng</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0"
                        id="table">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="w-40px"></th>
                                <th class="text-nowrap fs-5 text-start">Thí sinh</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Thông tin liên hệ</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Liên hệ</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Tư vấn viên</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Trạng thái</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Thời gian</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Nội dung</th>
                                <th class="text-nowrap fs-5 text-center pe-7">Ghi âm</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Chức năng</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr>
                                <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </td>
                                <td class="align-middle px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="/candidate/detail.html"
                                            class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn A</a>
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <i class="text-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </i>

                                            0123.456.789
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
                                            example@gmail.com
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 18 18" fill="none">
                                            <path d="M11.25 6.75L14.25 3.75M14.25 3.75V6M14.25 3.75H12" stroke="#7E7E7E"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                fill="#7E7E7E" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex flex-stack">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="flex-grow-1 me-2">
                                                <span class="fs-5">Chưa có</span>
                                            </div>
                                            <!--end:Author-->
                                        </div>
                                        <!--end::Section-->
                                    </div>
                                </td>
                                <td class="align-middle text-left">
                                    <span class="text-success">Kết thúc</span>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span>09:49 • 27/04/2024</span>
                                        <span class="fs-7 text-muted">5 phút 12 giây</span>
                                    </div>
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    Khách cần tư vấn về học phí
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                fill="#1EBB79" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost p-1" data-ti-menu-trigger="click"
                                        data-ti-menu-placement="bottom-end">
                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                            height="18" />
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-ti-menu="true"
                                        id="ti-toolbar-candidate-note-editor-1" style="">
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="text-start mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú nội dung cuộc
                                                    gọi
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
                                                    data-ti-menu-dismiss="true" data-ti-candidate-table-action="update"
                                                    data-candidate-id="997">Lưu</button>
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-ti-menu-dismiss="true"
                                                    data-ti-candidate-table-action="reset">Hủy</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18"
                                            height="18" />
                                    </a>
                                    <button type="button" class="btn btn-ghost p-1"
                                        data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                        data-ti-row-confirm="true">
                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                            height="18" />
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </td>
                                <td class="align-middle px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="/candidate/detail.html"
                                            class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn B</a>
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <i class="text-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </i>

                                            0123.456.789
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
                                            example@gmail.com
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 18 18" fill="none">
                                            <path d="M11.25 6.75L14.25 3.75M14.25 3.75V6M14.25 3.75H12" stroke="#7E7E7E"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                fill="#7E7E7E" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex flex-stack">
                                        <!--begin::Symbol-->
                                        <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                            <img src="assets/crm/media/svg/avatars/blank.svg" class="h-50 align-self-center"
                                                alt="">
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">Nguyễn Thị
                                                    B</a>

                                                <span class="text-muted fw-semibold d-block fs-7">NV2403</span>
                                            </div>
                                            <!--end:Author-->
                                        </div>
                                        <!--end::Section-->
                                    </div>

                                </td>
                                <td class="align-middle text-left">
                                    <span class="text-success">Kết thúc</span>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span>09:49 • 27/04/2024</span>
                                        <span class="fs-7 text-muted">5 phút 12 giây</span>
                                    </div>
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    -
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                fill="#1EBB79" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost p-1" data-ti-menu-trigger="click"
                                        data-ti-menu-placement="bottom-end">
                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                            height="18" />
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-ti-menu="true"
                                        id="ti-toolbar-candidate-note-editor-1" style="">
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="text-start mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú nội dung cuộc
                                                    gọi
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
                                                    data-ti-menu-dismiss="true" data-ti-candidate-table-action="update"
                                                    data-candidate-id="997">Lưu</button>
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-ti-menu-dismiss="true"
                                                    data-ti-candidate-table-action="reset">Hủy</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18"
                                            height="18" />
                                    </a>
                                    <button type="button" class="btn btn-ghost p-1"
                                        data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                        data-ti-row-confirm="true">
                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                            height="18" />
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </td>
                                <td class="align-middle px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="/candidate/detail.html"
                                            class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn B</a>
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <i class="text-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </i>

                                            0123.456.789
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
                                            example@gmail.com
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 18 18" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2.37868 3.87868C1.5 4.75736 1.5 6.17157 1.5 9C1.5 11.8284 1.5 13.2426 2.37868 14.1213C3.25736 15 4.67157 15 7.5 15H10.5C13.3284 15 14.7426 15 15.6213 14.1213C16.5 13.2426 16.5 11.8284 16.5 9C16.5 6.17157 16.5 4.75736 15.6213 3.87868C14.7426 3 13.3284 3 10.5 3H7.5C4.67157 3 3.25736 3 2.37868 3.87868ZM13.9321 5.6399C14.131 5.87855 14.0988 6.23324 13.8601 6.43212L12.2127 7.80492C11.548 8.35892 11.0092 8.80794 10.5336 9.11379C10.0382 9.43239 9.55581 9.63366 9 9.63366C8.44419 9.63366 7.96176 9.43239 7.46638 9.11379C6.99084 8.80794 6.45203 8.35892 5.78727 7.80493L4.1399 6.43212C3.90124 6.23324 3.869 5.87855 4.06788 5.6399C4.26676 5.40124 4.62145 5.369 4.8601 5.56788L6.47928 6.91719C7.179 7.50028 7.6648 7.90381 8.07494 8.1676C8.47196 8.42294 8.7412 8.50866 9 8.50866C9.2588 8.50866 9.52804 8.42294 9.92506 8.1676C10.3352 7.90381 10.821 7.50028 11.5207 6.91718L13.1399 5.56788C13.3786 5.369 13.7332 5.40124 13.9321 5.6399Z"
                                                fill="#7E7E7E" />
                                        </svg>
                                    </button>

                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex flex-stack">
                                        <!--begin::Symbol-->
                                        <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                            <img src="assets/crm/media/svg/avatars/blank.svg" class="h-50 align-self-center"
                                                alt="">
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">Nguyễn Thị
                                                    B</a>

                                                <span class="text-muted fw-semibold d-block fs-7">NV2403</span>
                                            </div>
                                            <!--end:Author-->
                                        </div>
                                        <!--end::Section-->
                                    </div>

                                </td>
                                <td class="align-middle text-left">
                                    <span class="text-danger">Gọi lỡ</span>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span>09:49 • 27/04/2024</span>
                                        <span class="fs-7 text-muted">5 phút 12 giây</span>
                                    </div>
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    -
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                fill="#1EBB79" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost p-1" data-ti-menu-trigger="click"
                                        data-ti-menu-placement="bottom-end">
                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                            height="18" />
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-ti-menu="true"
                                        id="ti-toolbar-candidate-note-editor-1" style="">
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="text-start mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú nội dung cuộc
                                                    gọi
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
                                                    data-ti-menu-dismiss="true" data-ti-candidate-table-action="update"
                                                    data-candidate-id="997">Lưu</button>
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-ti-menu-dismiss="true"
                                                    data-ti-candidate-table-action="reset">Hủy</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18"
                                            height="18" />
                                    </a>
                                    <button type="button" class="btn btn-ghost p-1"
                                        data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                        data-ti-row-confirm="true">
                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                            height="18" />
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </td>
                                <td class="align-middle px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="/candidate/detail.html"
                                            class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn B</a>
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <i class="text-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </i>

                                            0123.456.789
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
                                            example@gmail.com
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-sm btn-ghost">
                                        <svg width="17" height="18" viewBox="0 0 15 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
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
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex flex-stack">
                                        <!--begin::Symbol-->
                                        <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                            <img src="assets/crm/media/svg/avatars/blank.svg" class="h-50 align-self-center"
                                                alt="">
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">Nguyễn Thị
                                                    B</a>

                                                <span class="text-muted fw-semibold d-block fs-7">NV2403</span>
                                            </div>
                                            <!--end:Author-->
                                        </div>
                                        <!--end::Section-->
                                    </div>

                                </td>
                                <td class="align-middle text-left">
                                    <span class="text-primary">Đã gửi</span>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span>09:49 • 27/04/2024</span>
                                        <span class="fs-7 text-muted">5 phút 12 giây</span>
                                    </div>
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    -
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                fill="#1EBB79" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost p-1" data-ti-menu-trigger="click"
                                        data-ti-menu-placement="bottom-end">
                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                            height="18" />
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-ti-menu="true"
                                        id="ti-toolbar-candidate-note-editor-1" style="">
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="text-start mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú nội dung cuộc
                                                    gọi
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
                                                    data-ti-menu-dismiss="true" data-ti-candidate-table-action="update"
                                                    data-candidate-id="997">Lưu</button>
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-ti-menu-dismiss="true"
                                                    data-ti-candidate-table-action="reset">Hủy</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18"
                                            height="18" />
                                    </a>
                                    <button type="button" class="btn btn-ghost p-1"
                                        data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                        data-ti-row-confirm="true">
                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                            height="18" />
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </td>
                                <td class="align-middle px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="/candidate/detail.html"
                                            class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn B</a>
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
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
                                        <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                            <i class="text-primary">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </i>

                                            0123.456.789
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
                                            example@gmail.com
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle text-center px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 18 18" fill="none">
                                            <path d="M14.25 3.75L11.25 6.75M11.25 6.75V4.5M11.25 6.75H13.5"
                                                stroke="#7E7E7E" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M7.52819 3.98713L8.01495 4.85933C8.45423 5.64644 8.27789 6.67899 7.58604 7.37085C7.58603 7.37085 7.58603 7.37085 7.58603 7.37085C7.58592 7.37097 6.74694 8.21016 8.26839 9.73161C9.78918 11.2524 10.6283 10.4148 10.6291 10.414C10.6292 10.4139 10.6292 10.414 10.6292 10.4139C11.321 9.72211 12.3536 9.54578 13.1407 9.98505L14.0129 10.4718C15.2014 11.1351 15.3418 12.8019 14.2971 13.8466C13.6693 14.4744 12.9003 14.9629 12.0502 14.9951C10.6191 15.0493 8.18871 14.6872 5.75078 12.2492C3.31285 9.81129 2.95066 7.38092 3.00491 5.94982C3.03714 5.0997 3.5256 4.33068 4.15335 3.70292C5.19807 2.65821 6.86488 2.79858 7.52819 3.98713Z"
                                                fill="#7E7E7E" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex flex-stack">
                                        <!--begin::Symbol-->
                                        <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                            <img src="assets/crm/media/svg/avatars/blank.svg" class="h-50 align-self-center"
                                                alt="">
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                            <!--begin:Author-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary fs-6 fw-bold">Nguyễn Thị
                                                    B</a>

                                                <span class="text-muted fw-semibold d-block fs-7">NV2403</span>
                                            </div>
                                            <!--end:Author-->
                                        </div>
                                        <!--end::Section-->
                                    </div>

                                </td>
                                <td class="align-middle text-left">
                                    <span class="text-primary">Đã gửi</span>
                                </td>
                                <td class="align-middle text-start px-2 px-md-4 py-4">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span>09:49 • 27/04/2024</span>
                                        <span class="fs-7 text-muted">5 phút 12 giây</span>
                                    </div>
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    -
                                </td>
                                <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5ZM13.3669 19.8073L19.2671 16.3237C20.2443 15.7468 20.2443 14.2532 19.2671 13.6763L13.3669 10.1927C12.4171 9.63201 11.25 10.3618 11.25 11.5164V18.4836C11.25 19.6382 12.4171 20.368 13.3669 19.8073Z"
                                                fill="#1EBB79" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                    <button type="button" class="btn btn-ghost p-1" data-ti-menu-trigger="click"
                                        data-ti-menu-placement="bottom-end">
                                        <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                            height="18" />
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-ti-menu="true"
                                        id="ti-toolbar-candidate-note-editor-1" style="">
                                        <!--begin::Content-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="text-start mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú nội dung cuộc
                                                    gọi
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
                                                    data-ti-menu-dismiss="true" data-ti-candidate-table-action="update"
                                                    data-candidate-id="997">Lưu</button>
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-ti-menu-dismiss="true"
                                                    data-ti-candidate-table-action="reset">Hủy</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <a href="/candidate/detail.html" class="btn btn-ghost p-1">
                                        <img src="assets/crm/media/svg/crm/view.svg" alt="Xem chi tiết" width="18"
                                            height="18" />
                                    </a>
                                    <button type="button" class="btn btn-ghost p-1"
                                        data-ti-row-confirm-message="Xóa hồ sơ này?" data-ti-button-action="row-remove"
                                        data-ti-row-confirm="true">
                                        <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                            height="18" />
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
                            <input class="form-check-input" type="checkbox" value="" id="select_all"
                                data-select-all="true" data-target="table">
                            <label class="form-check-label text-gray-900" for="select_all">
                                Chọn tất cả
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <nav aria-label="...">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Trang trước</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
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
            <!--end::Body-->
        </div>
        <!--end::Content-->


    </div>
@endsection
