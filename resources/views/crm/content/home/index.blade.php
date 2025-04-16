@extends('crm.layouts.layout')

@section('title','Dashboard')

@section('content')
<div class="px-6">
    <!--  App Breadcrumb-->
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <!--begin:Breadcrumb-->
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                <!--  Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboard</li>
                <!--end::Item-->
                <!--  Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--  Item-->
                <li class="breadcrumb-item text-primary">Thống kê</li>
                <!--end::Item-->
            </ul>
        </div>
        <!--end:Breadcrumb-->
        <!--begin:Today-->
        <div class="d-flex justify-content-start align-items-center gap-1">
            <i class="text-primary">
                <img src="/assets/crm/media/svg/crm/calendar-2.svg" width="18" height="18" />
            </i>
            <span class="fs-6">Thứ tư • 27 tháng 12, 2024</span>
        </div>
        <!--end:Today-->
    </div>
    <!--end::App Breadcrumb-->
    <!--  Overview Stats-->
    <div class="app-overview-stats">
        <div class="row mb-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-2 mb-2 mb-md-0">
                    <!--  Details-->
                    <div class="d-flex align-items-center">
                        <!--  Number-->
                        <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                            <span class="fs-2 fw-bold text-primary">53</span>
                        </div>
                        <!--end::Number-->
                        <!--  Details-->
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
                    <!--  Details-->
                    <div class="d-flex align-items-center">
                        <!--  Number-->
                        <div class="symbol  symbol-40px symbol-rounded bg-warning bg-opacity-15 p-4">
                            <span class="fs-2 fw-bold text-warning">16</span>
                        </div>
                        <!--end::Number-->
                        <!--  Details-->
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
                    <!--  Details-->
                    <div class="d-flex align-items-center">
                        <!--  Number-->
                        <div class="symbol  symbol-40px symbol-rounded bg-success bg-opacity-15 p-4">
                            <span class="fs-2 fw-bold text-success">20</span>
                        </div>
                        <!--end::Number-->
                        <!--  Details-->
                        <div class="ms-4">
                            <span class="fs-5 fw-bold text-success text-hover-success mb-2">Thí sinh chính thức</span>
                            <div class="fw-semibold fs-7 text-muted">Số thí sinh hoàn tất đăng ký trở thành chính thức</div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Details-->
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-2">
                    <!--  Details-->
                    <div class="d-flex align-items-center">
                        <!--  Number-->
                        <div class="symbol  symbol-40px symbol-rounded bg-danger bg-opacity-15 p-4">
                            <span class="fs-2 fw-bold text-danger">02</span>
                        </div>
                        <!--end::Number-->
                        <!--  Details-->
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
    </div>
    <!--end::Overview Stats-->
    <!--  Content-->
    <div class="card">
        <!--  Toolbar-->
        <div class="card-header p-4">
            <!--  Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                <!--  Title-->
                <h3 class="card-title text-dark fw-bolder m-md-0">Biểu đồ quá trình chuyển đổi trạng thái data thí sinh</h3>
                <!--end::Title-->
                <!--  Actions-->
                <div class="d-flex justify-content-end">
                    <div class="d-none d-md-flex align-items-center pe-4">
                        <!--  Icon-->
                        <div class="symbol symbol-40px p-0">
                            <img src="/assets/crm/media/svg/crm/user-group.svg" />
                        </div>
                        <!--end::Icon-->
                        <!--  Details-->
                        <div class="mx-4">
                            <span class="fs-6 fw-bold text-muted mb-2">Tổng cộng</span>
                            <div class="fw-bold fs-4">156</div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                    <div class="d-none d-md-flex align-items-center pe-4">
                        <!--  Icon-->
                        <div class="symbol symbol-40px p-0">
                            <img src="/assets/crm/media/svg/crm/chart-increase.svg" />
                        </div>
                        <!--end::Icon-->
                        <!--  Details-->
                        <div class="mx-4">
                            <span class="fs-6 fw-bold text-muted mb-2">Tỷ lệ chuyển đổi</span>
                            <div class="fw-bold fs-4">0.05%</div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                    <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                    <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                        <!--end::Display range-->
                        <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                        </i>
                        <!--  Display range-->
                        <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                    </div>
                    <!--end::Daterangepicker-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar-->
        <!--  Top Chart-->
        <div class="card-body p-4">
            <div class="table-responsive position-relative border rounded-3 my-3">
                <table class="table table-sm table-bordered bg-transparent position-relative bordered rounded-3 m-0" style="z-index: 1">
                    <tr>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 1</div>
                            <div class="fs-10 fs-md-8 fw-bold">Raw lead</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 2</div>
                            <div class="fs-10 fs-md-8 fw-bold">Đang liên hệ</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 3</div>
                            <div class="fs-10 fs-md-8 fw-bold">Đang nộp hồ sơ</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 4</div>
                            <div class="fs-10 fs-md-8 fw-bold">Đã nộp hồ sơ</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 5</div>
                            <div class="fs-10 fs-md-8 fw-bold">Đang kiểm tra</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 6</div>
                            <div class="fs-10 fs-md-8 fw-bold">Chờ nộp học phí</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 7</div>
                            <div class="fs-10 fs-md-8 fw-bold">Đã nộp học phí</div>
                        </td>
                        <td class="w-180px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Giai đoạn 8</div>
                            <div class="fs-10 fs-md-8 fw-bold">Sinh viên chính thức</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Raw lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">156</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                        <td class="h-unset h-md-300px">
                            <div class="fs-10 fs-md-5 text-uppercase text-muted">Lead</div>
                            <div class="fs-10 fs-md-7 fw-bold">112</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-danger text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-muted text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                        <td class="text-success text-center position-relative">
                            <div class="d-none d-md-block" style="margin-top: -36px">
                                <svg width="52" height="52" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="12.5" fill="currentColor" />
                                    <circle cx="14" cy="14" r="12.5" stroke="white" stroke-width="1.5" />
                                    <path d="M10.875 15.875C11.4894 16.5071 13.1247 19 14 19M17.125 15.875C16.5106 16.5071 14.8753 19 14 19M14 19L14 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <p class="m-0 fs-10 fs-md-5 fw-bold">Drop off</p>
                            <p class="m-0 fs-8 fs-md-2 fw-bolder">66.7%</p>
                            <p class="m-0 fs-10 fs-md-5 fw-bold">(8)</p>
                        </td>
                    </tr>
                </table>
                <canvas id="ti_overview_chart_demo" class="d-none d-md-block h-300px position-absolute" style="bottom: 140px;margin: 0 1px;" data-color="rgba(3,78,162,0.15)" />
            </div>
        </div>
        <!--end::Top Chart-->
    </div>
    <!--end::Content-->
    <!--begin:Other Summaries-->
    <div class="row gx-3 gx-lg-5 mt-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê học phí theo khoa</h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <div id="ti_overview_chart_legend_2" class="d-flex flex-stack align-items-center"></div>
                            <!--
														<div class="d-none d-md-flex align-items-center pe-4">
															<div class="form-check form-switch form-check-custom form-switch-sm">
																<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
																<label class="form-check-label" for="flexSwitchCheckChecked">Học phí dự kiến</label>
															</div>
														</div>
														<div class="d-none d-md-flex align-items-center pe-4">
															<div class="form-check form-switch form-check-custom form-switch-sm">
																<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
																<label class="form-check-label" for="flexSwitchCheckChecked">Học phí thu về</label>
															</div>
														</div>
														-->
                            <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                <!--end::Display range-->
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <!--  Display range-->
                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <canvas id="ti_overview_chart_demo_2" class="h-450px" />
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Lượng thí sinh nguồn MKT</h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                <!--end::Display range-->
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <!--  Display range-->
                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <canvas id="ti_overview_chart_demo_3" class="h-450px" />
                </div>
            </div>
        </div>
    </div>
    <div class="row gx-3 gx-lg-5 mt-3">
        <!--begin: Thí sinh mới-->
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Thí sinh mới</h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                <!--end::Display range-->
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <!--  Display range-->
                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <canvas id="ti_overview_chart_demo_4" class="h-450px" />
                </div>
            </div>
        </div>
        <!--end: Thí sinh mới-->
        <!--begin: Top Ngành học thí sinh quan tâm-->
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Top Ngành học thí sinh quan tâm</h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                <!--end::Display range-->
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <!--  Display range-->
                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <div class="row g-y-3">
                        <div class="col-12 col-md-6">
                            <canvas id="ti_doughnut_chart_demo_5" class="h-450px" data-legend-container="ti_doughnut_chart_legend_5" />
                        </div>
                        <div class="col-12 col-md-6">
                            <div id="ti_doughnut_chart_legend_5" class="d-flex align-items-center h-100"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end: Top Ngành học thí sinh quan tâm-->
        <!--begin: Thống kê trạng thái -->
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê trạng thái </h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <!--  Daterangepicker(defined in src/js/layout/app.js)-->
                            <div data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right" class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                <!--end::Display range-->
                                <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <!--  Display range-->
                                <div class="text-gray-600 fw-bold fs-5">Đang tải...</div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <div class="row g-y-4">
                        <div class="col-12 col-md-6">
                            <canvas id="ti_doughnut_chart_demo_6" class="h-450px" data-legend-container="ti_doughnut_chart_legend_6" />
                        </div>
                        <div class="col-12 col-md-6">
                            <div id="ti_doughnut_chart_legend_6" class="d-flex align-items-center h-100"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end: Thống kê trạng thái -->
    </div>
    <div class="row gx-3 gx-lg-5 mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-4">
                    <!--  Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                        <!--  Title-->
                        <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách thí sinh mới</h3>
                        <!--end::Title-->
                        <!--  Actions-->
                        <div class="d-flex justify-content-end">
                            <a href="/#xem-them" class="text-primary fs-5">Xem thêm</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive position-relative border rounded-3 my-3">
                        <!--  Table-->
                        <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
                            <!--  Table head-->
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="w-40px"></th>
                                    <th class="text-nowrap fs-5 text-start">Thí sinh</th>
                                    <th class="text-nowrap fs-5 text-start pe-7">Liên hệ</th>
                                    <th class="text-nowrap fs-5 text-start pe-7">Tư vấn viên</th>
                                    <th class="text-nowrap fs-5 text-start pe-7">Trạng thái</th>
                                    <th class="text-nowrap fs-5 text-start pe-7">Nguồn MKT</th>
                                    <th class="text-nowrap fs-5 text-start pe-7">Thời gian</th>
                                    <th class="text-nowrap fs-5 text-start white-space- pe-7">Ngành học quan tâm</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--  Table body-->
                            <tbody>
                                <tr>
                                    <td class="align-middle text-center ps-2">1</td>
                                    <td class="align-middle px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="/../dist/pages/user-profile/overview.html" class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn A</a>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z" fill="currentColor" />
                                                </svg>
                                                Quận 3, HCM
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z" fill="currentColor" />
                                                    </svg>
                                                </i>

                                                0123.456.789
                                            </span>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z" fill="currentColor" />
                                                    </svg>

                                                </i>
                                                example@gmail.com
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex flex-stack">
                                            <!--  Section-->
                                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                <!--begin:Author-->
                                                <div class="flex-grow-1 me-2">
                                                    <span class="fs-5">Chưa có</span>
                                                </div>
                                                <!--end:Author-->

                                                <!--begin:Action-->
                                                <button type="button" class="btn btn-ghost text-muted p-0">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z" fill="currentColor" />
                                                        <path d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z" fill="currentColor" />
                                                        <path d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z" fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <!--end:Action-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <select class="lead_status_select w-auto form-select form-select-sm">
                                            <option data-color="gray-500" value="0">Raw lead</option>
                                            <option data-color="warning" value="1">Đang tư vấn</option>
                                            <option data-color="primary" value="2">Liên hệ sau</option>
                                            <option data-color="danger" value="3">Ưu tiên</option>
                                        </select>
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        Facebook
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.52085 1.45837C4.52085 1.21675 4.32498 1.02087 4.08335 1.02087C3.84173 1.02087 3.64585 1.21675 3.64585 1.45837V2.37961C2.80624 2.44684 2.25505 2.61184 1.8501 3.01679C1.44516 3.42174 1.28015 3.97293 1.21292 4.81254H12.7871C12.7199 3.97293 12.5549 3.42174 12.1499 3.01679C11.745 2.61184 11.1938 2.44684 10.3542 2.37961V1.45837C10.3542 1.21675 10.1583 1.02087 9.91669 1.02087C9.67506 1.02087 9.47919 1.21675 9.47919 1.45837V2.3409C9.09112 2.33337 8.65612 2.33337 8.16669 2.33337H5.83335C5.34392 2.33337 4.90893 2.33337 4.52085 2.3409V1.45837Z" fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.16669 7.00004C1.16669 6.5106 1.16669 6.07561 1.17421 5.68754H12.8258C12.8334 6.07561 12.8334 6.5106 12.8334 7.00004V8.16671C12.8334 10.3666 12.8334 11.4665 12.1499 12.15C11.4665 12.8334 10.3666 12.8334 8.16669 12.8334H5.83335C3.63347 12.8334 2.53352 12.8334 1.8501 12.15C1.16669 11.4665 1.16669 10.3666 1.16669 8.16671V7.00004ZM9.91669 8.16671C10.2389 8.16671 10.5 7.90554 10.5 7.58337C10.5 7.26121 10.2389 7.00004 9.91669 7.00004C9.59452 7.00004 9.33335 7.26121 9.33335 7.58337C9.33335 7.90554 9.59452 8.16671 9.91669 8.16671ZM9.91669 10.5C10.2389 10.5 10.5 10.2389 10.5 9.91671C10.5 9.59454 10.2389 9.33337 9.91669 9.33337C9.59452 9.33337 9.33335 9.59454 9.33335 9.91671C9.33335 10.2389 9.59452 10.5 9.91669 10.5ZM7.58335 7.58337C7.58335 7.90554 7.32219 8.16671 7.00002 8.16671C6.67785 8.16671 6.41669 7.90554 6.41669 7.58337C6.41669 7.26121 6.67785 7.00004 7.00002 7.00004C7.32219 7.00004 7.58335 7.26121 7.58335 7.58337ZM7.58335 9.91671C7.58335 10.2389 7.32219 10.5 7.00002 10.5C6.67785 10.5 6.41669 10.2389 6.41669 9.91671C6.41669 9.59454 6.67785 9.33337 7.00002 9.33337C7.32219 9.33337 7.58335 9.59454 7.58335 9.91671ZM4.08335 8.16671C4.40552 8.16671 4.66669 7.90554 4.66669 7.58337C4.66669 7.26121 4.40552 7.00004 4.08335 7.00004C3.76119 7.00004 3.50002 7.26121 3.50002 7.58337C3.50002 7.90554 3.76119 8.16671 4.08335 8.16671ZM4.08335 10.5C4.40552 10.5 4.66669 10.2389 4.66669 9.91671C4.66669 9.59454 4.40552 9.33337 4.08335 9.33337C3.76119 9.33337 3.50002 9.59454 3.50002 9.91671C3.50002 10.2389 3.76119 10.5 4.08335 10.5Z" fill="#034EA2" />
                                                    </svg>
                                                </i>

                                                12/10/2023
                                            </span>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.8334 6.99996C12.8334 10.2216 10.2217 12.8333 7.00002 12.8333C3.77836 12.8333 1.16669 10.2216 1.16669 6.99996C1.16669 3.7783 3.77836 1.16663 7.00002 1.16663C10.2217 1.16663 12.8334 3.7783 12.8334 6.99996Z" fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00002 4.22913C7.24165 4.22913 7.43752 4.425 7.43752 4.66663V6.81874L8.76771 8.14893C8.93857 8.31979 8.93857 8.5968 8.76771 8.76765C8.59686 8.93851 8.31985 8.93851 8.14899 8.76765L6.69066 7.30932C6.60861 7.22727 6.56252 7.11599 6.56252 6.99996V4.66663C6.56252 4.425 6.7584 4.22913 7.00002 4.22913Z" fill="white" />
                                                    </svg>

                                                </i>
                                                12:43
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        Khoa Công nghệ Thông tin
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle text-center ps-2">2</td>
                                    <td class="align-middle px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="/../dist/pages/user-profile/overview.html" class="text-private fw-bold text-hover-primary mb-1 fs-6">Nguyễn Văn A</a>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00001 1.16663C4.42268 1.16663 2.33334 3.50147 2.33334 6.12496C2.33334 8.7279 3.82278 11.5572 6.14663 12.6434C6.68836 12.8966 7.31166 12.8966 7.85339 12.6434C10.1772 11.5572 11.6667 8.72789 11.6667 6.12496C11.6667 3.50147 9.57734 1.16663 7.00001 1.16663ZM7.00001 6.99996C7.64434 6.99996 8.16668 6.47763 8.16668 5.83329C8.16668 5.18896 7.64434 4.66663 7.00001 4.66663C6.35568 4.66663 5.83334 5.18896 5.83334 5.83329C5.83334 6.47763 6.35568 6.99996 7.00001 6.99996Z" fill="currentColor" />
                                                </svg>
                                                Quận 3, HCM
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.77349 2.82261L6.17913 3.54944C6.54519 4.20536 6.39824 5.06582 5.8217 5.64237C5.82169 5.64238 5.8217 5.64237 5.82169 5.64238C5.82158 5.64249 5.12246 6.34182 6.39032 7.60968C7.65753 8.87688 8.35681 8.17912 8.35762 8.17831C8.35765 8.17828 8.35764 8.1783 8.35766 8.17827C8.93421 7.60175 9.79465 7.45482 10.4506 7.82087L11.1774 8.22651C12.1679 8.77927 12.2848 10.1683 11.4142 11.0389C10.8911 11.562 10.2502 11.969 9.54182 11.9959C8.34924 12.0411 6.32392 11.7393 4.29231 9.70769C2.2607 7.67608 1.95888 5.65077 2.00409 4.45818C2.03095 3.74975 2.438 3.1089 2.96113 2.58577C3.83172 1.71518 5.22073 1.83215 5.77349 2.82261Z" fill="currentColor" />
                                                    </svg>
                                                </i>

                                                0123.456.789
                                            </span>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.85008 3.01679C1.16666 3.70021 1.16666 4.80015 1.16666 7.00004C1.16666 9.19993 1.16666 10.2999 1.85008 10.9833C2.5335 11.6667 3.63344 11.6667 5.83333 11.6667H8.16666C10.3666 11.6667 11.4665 11.6667 12.1499 10.9833C12.8333 10.2999 12.8333 9.19993 12.8333 7.00004C12.8333 4.80015 12.8333 3.70021 12.1499 3.01679C11.4665 2.33337 10.3666 2.33337 8.16666 2.33337H5.83333C3.63344 2.33337 2.5335 2.33337 1.85008 3.01679ZM10.8361 4.38663C10.9908 4.57225 10.9657 4.84812 10.7801 5.0028L9.4988 6.07054C8.98175 6.50142 8.56268 6.85066 8.19281 7.08855C7.80752 7.33635 7.43229 7.49288 7 7.49288C6.5677 7.49288 6.19247 7.33635 5.80718 7.08855C5.43732 6.85066 5.01825 6.50143 4.5012 6.07054L3.21992 5.0028C3.0343 4.84812 3.00922 4.57225 3.1639 4.38663C3.31858 4.20101 3.59446 4.17593 3.78008 4.33061L5.03943 5.38007C5.58366 5.8336 5.96151 6.14745 6.2805 6.35262C6.5893 6.55122 6.79871 6.61788 7 6.61788C7.20129 6.61788 7.4107 6.55122 7.71949 6.35262C8.03849 6.14745 8.41634 5.8336 8.96056 5.38007L10.2199 4.33061C10.4055 4.17593 10.6814 4.20101 10.8361 4.38663Z" fill="currentColor" />
                                                    </svg>

                                                </i>
                                                example@gmail.com
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex flex-stack">
                                            <!--  Symbol-->
                                            <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                                <img src="/assets/crm/media/svg/avatars/blank.svg" class="h-50 align-self-center" alt="">
                                            </div>
                                            <!--end::Symbol-->

                                            <!--  Section-->
                                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                <!--begin:Author-->
                                                <div class="flex-grow-1 me-2">
                                                    <a href="/#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Nguyễn Thị B</a>

                                                    <span class="text-muted fw-semibold d-block fs-7">NV2403</span>
                                                </div>
                                                <!--end:Author-->

                                                <!--begin:Action-->
                                                <button type="button" class="btn btn-ghost text-muted p-0">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89583 12.8334C1.89583 12.5917 2.0917 12.3959 2.33333 12.3959H11.6667C11.9083 12.3959 12.1042 12.5917 12.1042 12.8334C12.1042 13.075 11.9083 13.2709 11.6667 13.2709H2.33333C2.0917 13.2709 1.89583 13.075 1.89583 12.8334Z" fill="currentColor" />
                                                        <path d="M6.72004 8.70851L6.72004 8.70851L10.1714 5.25711C9.70171 5.0616 9.14535 4.74045 8.61917 4.21428C8.09291 3.68802 7.77174 3.13156 7.57625 2.66178L4.12478 6.11325L4.12476 6.11326C3.85544 6.38259 3.72076 6.51726 3.60495 6.66575C3.46832 6.84091 3.35119 7.03044 3.25562 7.23097C3.1746 7.40097 3.11438 7.58165 2.99392 7.94301L2.35874 9.84857C2.29946 10.0264 2.34574 10.2225 2.47829 10.355C2.61084 10.4875 2.80689 10.5338 2.98472 10.4746L4.89028 9.83936C5.25163 9.71891 5.43232 9.65868 5.60232 9.57767C5.80285 9.4821 5.99238 9.36496 6.16754 9.22834C6.31602 9.11253 6.45071 8.97784 6.72004 8.70851Z" fill="currentColor" />
                                                        <path d="M11.1292 4.29939C11.8458 3.58272 11.8458 2.42078 11.1292 1.70412C10.4125 0.98746 9.25056 0.98746 8.5339 1.70412L8.11995 2.11807C8.12562 2.13519 8.1315 2.15255 8.1376 2.17012C8.28933 2.60746 8.5756 3.18076 9.11414 3.7193C9.65268 4.25784 10.226 4.54412 10.6633 4.69585C10.6808 4.70192 10.6981 4.70777 10.7151 4.71342L11.1292 4.29939Z" fill="currentColor" />
                                                    </svg>
                                                </button>
                                                <!--end:Action-->
                                            </div>
                                            <!--end::Section-->
                                        </div>

                                    </td>
                                    <td class="align-middle text-center">
                                        <select class="lead_status_select w-auto form-select form-select-sm">
                                            <option data-color="gray-500" value="0">Raw lead</option>
                                            <option data-color="warning" selected value="1">Đang tư vấn</option>
                                            <option data-color="primary" value="2">Liên hệ sau</option>
                                            <option data-color="danger" value="3">Ưu tiên</option>
                                        </select>
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        Facebook
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.52085 1.45837C4.52085 1.21675 4.32498 1.02087 4.08335 1.02087C3.84173 1.02087 3.64585 1.21675 3.64585 1.45837V2.37961C2.80624 2.44684 2.25505 2.61184 1.8501 3.01679C1.44516 3.42174 1.28015 3.97293 1.21292 4.81254H12.7871C12.7199 3.97293 12.5549 3.42174 12.1499 3.01679C11.745 2.61184 11.1938 2.44684 10.3542 2.37961V1.45837C10.3542 1.21675 10.1583 1.02087 9.91669 1.02087C9.67506 1.02087 9.47919 1.21675 9.47919 1.45837V2.3409C9.09112 2.33337 8.65612 2.33337 8.16669 2.33337H5.83335C5.34392 2.33337 4.90893 2.33337 4.52085 2.3409V1.45837Z" fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.16669 7.00004C1.16669 6.5106 1.16669 6.07561 1.17421 5.68754H12.8258C12.8334 6.07561 12.8334 6.5106 12.8334 7.00004V8.16671C12.8334 10.3666 12.8334 11.4665 12.1499 12.15C11.4665 12.8334 10.3666 12.8334 8.16669 12.8334H5.83335C3.63347 12.8334 2.53352 12.8334 1.8501 12.15C1.16669 11.4665 1.16669 10.3666 1.16669 8.16671V7.00004ZM9.91669 8.16671C10.2389 8.16671 10.5 7.90554 10.5 7.58337C10.5 7.26121 10.2389 7.00004 9.91669 7.00004C9.59452 7.00004 9.33335 7.26121 9.33335 7.58337C9.33335 7.90554 9.59452 8.16671 9.91669 8.16671ZM9.91669 10.5C10.2389 10.5 10.5 10.2389 10.5 9.91671C10.5 9.59454 10.2389 9.33337 9.91669 9.33337C9.59452 9.33337 9.33335 9.59454 9.33335 9.91671C9.33335 10.2389 9.59452 10.5 9.91669 10.5ZM7.58335 7.58337C7.58335 7.90554 7.32219 8.16671 7.00002 8.16671C6.67785 8.16671 6.41669 7.90554 6.41669 7.58337C6.41669 7.26121 6.67785 7.00004 7.00002 7.00004C7.32219 7.00004 7.58335 7.26121 7.58335 7.58337ZM7.58335 9.91671C7.58335 10.2389 7.32219 10.5 7.00002 10.5C6.67785 10.5 6.41669 10.2389 6.41669 9.91671C6.41669 9.59454 6.67785 9.33337 7.00002 9.33337C7.32219 9.33337 7.58335 9.59454 7.58335 9.91671ZM4.08335 8.16671C4.40552 8.16671 4.66669 7.90554 4.66669 7.58337C4.66669 7.26121 4.40552 7.00004 4.08335 7.00004C3.76119 7.00004 3.50002 7.26121 3.50002 7.58337C3.50002 7.90554 3.76119 8.16671 4.08335 8.16671ZM4.08335 10.5C4.40552 10.5 4.66669 10.2389 4.66669 9.91671C4.66669 9.59454 4.40552 9.33337 4.08335 9.33337C3.76119 9.33337 3.50002 9.59454 3.50002 9.91671C3.50002 10.2389 3.76119 10.5 4.08335 10.5Z" fill="#034EA2" />
                                                    </svg>
                                                </i>

                                                12/10/2023
                                            </span>
                                            <span class="d-flex gap-1 align-items-center text-muted d-block fs-5">
                                                <i class="text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.8334 6.99996C12.8334 10.2216 10.2217 12.8333 7.00002 12.8333C3.77836 12.8333 1.16669 10.2216 1.16669 6.99996C1.16669 3.7783 3.77836 1.16663 7.00002 1.16663C10.2217 1.16663 12.8334 3.7783 12.8334 6.99996Z" fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.00002 4.22913C7.24165 4.22913 7.43752 4.425 7.43752 4.66663V6.81874L8.76771 8.14893C8.93857 8.31979 8.93857 8.5968 8.76771 8.76765C8.59686 8.93851 8.31985 8.93851 8.14899 8.76765L6.69066 7.30932C6.60861 7.22727 6.56252 7.11599 6.56252 6.99996V4.66663C6.56252 4.425 6.7584 4.22913 7.00002 4.22913Z" fill="white" />
                                                    </svg>

                                                </i>
                                                12:43
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        Khoa Kinh tế và Quản lý công
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end:Other Summaries-->
</div>

@endsection