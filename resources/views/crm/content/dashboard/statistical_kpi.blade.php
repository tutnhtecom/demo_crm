@extends('crm.layouts.layout')

@section('header', 'Dashboard')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboard</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Thống kê KPI</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->
            <!--begin:Today-->
            <div class="d-flex justify-content-start align-items-center gap-1">
                <i class="text-primary">
                    <img src="assets/crm/media/svg/crm/calendar-2.svg" width="18" height="18" />
                </i>
                <span class="fs-6">Thứ tư • 27 tháng 12, 2024</span>
            </div>
            <!--end:Today-->
        </div>
        <!--end::App Breadcrumb-->

        <!--begin::Content-->
        <div class="card">
            <!--begin::Toolbar-->
            <div class="card-header p-4">
                <!--begin::Toolbar wrapper-->
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê KPI</h3>
                    <!--end::Title-->
                    <!--begin::Actions-->
                    <div class="page-actions d-flex flex-stack">
                        <a href="#" class="btn btn-sm btn-primary rounded-full ms-3 px-6 py-3">Theo tháng</a>
                        <a href="#" class="btn btn-sm btn-secondary btn-outline rounded-full ms-3 px-6 py-3">Theo
                            quý</a>
                        <a href="#" class="btn btn-sm btn-secondary btn-outline rounded-full ms-3 px-6 py-3">Theo
                            năm</a>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Top Chart-->
            <div class="card-body p-4">
                <div class="row gx-5 gx-xl-10 pt-6">
                    <!--begin::Col-->
                    <div class="col-12 mb-5">
                        <!--begin::Overview By Month-->
                        <div class="position-relative rounded border border-gray-300 p-6">
                            <div class="row gx-5">
                                <div class="col-12 col-md-4 border-end">
                                    <!--begin::Overview col-->
                                    <div class="p-6 ">
                                        <a href="" class="text-primary fw-bold fs-3 mb-2">
                                            Tổng quan tháng 3/2024
                                        </a>
                                        <div class="row gx-4 gy-4 fs-3">
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Thí sinh mới</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/new-student.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Chuyên viên đạt KPI</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/user-single.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Học phí (VND)</span>
                                                    <div class="flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/dollar-increase.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Thí sinh bị từ chối</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/user-times.svg" width="18"
                                                            height="22">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                        </div>
                                    </div>
                                    <!--end::Overview col-->
                                </div>
                                <div class="col-12 col-md-4 border-end">
                                    <!--begin::Target col-->
                                    <div class="p-6">
                                        <h3 class="fw-bold mb-2">Mục tiêu</h3>
                                        <div class="d-flex flex-column flex-column-fluid fs-3">
                                            <!--begin::Target info box-->
                                            <div class="d-flex flex-row gx-2 w-100 mb-8 py-2">
                                                <div
                                                    class="d-flex align-items-center justify-content-center bg-secondary rounded w-60px h-60px mr-2 p-4">
                                                    78%</div>
                                                <div class="flex flex-column w-100 ps-2 gap-y-2">
                                                    <span class="fw-bold fs-4">Lượng thí sinh mới đăng ký</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: 70%;"
                                                            role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-primary">156</span>
                                                        <span>/</span>
                                                        <span>200</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Target info box-->
                                            <!--begin::Target info box-->
                                            <div class="d-flex flex-row gx-2 w-100 mb-8 py-2">
                                                <div
                                                    class="d-flex align-items-center justify-content-center bg-secondary rounded w-60px h-60px mr-2 p-4">
                                                    40%</div>
                                                <div class="flex flex-column w-100 ps-2 gap-y-2">
                                                    <span class="fw-bold fs-4">Học phí thu được</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: 70%;"
                                                            role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-primary">65.000.000</span>
                                                        <span>/</span>
                                                        <span>250.000.000 VND</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Target info box-->
                                        </div>
                                    </div>
                                    <!--end::Target col-->
                                </div>
                                <div class="col-12 col-md-4">
                                    <!--begin::Donus Chart col-->
                                    <div class="p-6">
                                        <h3 class="fw-bold mb-2">Thống kê trạng thái</h3>
                                        <div class="row gy-md-4">
                                            <div class="col-12 col-md-6">
                                                <canvas id="ti_doughnut_chart_demo" class="h-250px"
                                                    data-legend-container="ti_doughnut_chart_legend" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div id="ti_doughnut_chart_legend"
                                                    class="d-flex align-items-center h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Donus Chart col-->
                                </div>
                            </div>
                            <div
                                class="box_status position-absolute bg-primary text-center text-white rounded-top px-3 py-1">
                                Đang hoạt động</div>
                        </div>
                        <!--end::Overview By Month-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-12 mb-5">
                        <!--begin::Overview By Month-->
                        <div class="position-relative rounded border border-gray-300 p-6">
                            <div class="row gx-5">
                                <div class="col-12 col-md-4 border-end">
                                    <!--begin::Overview col-->
                                    <div class="p-6 ">
                                        <a href="/dashboard/detail-kpi.html" class="text-primary fw-bold fs-3 mb-2">Tổng
                                            quan tháng 3/2024</a>
                                        <div class="row gx-4 gy-4 fs-3">
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Thí sinh mới</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/new-student.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Chuyên viên đạt KPI</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/user-single.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Học phí (VND)</span>
                                                    <div class="flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/dollar-increase.svg" width="28"
                                                            height="28">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                            <!--begin::Summary info box-->
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex flex-column bg-opacity-20 rounded px-5 py-8" style="background-color:#E6EEF6">
                                                    <span>Thí sinh bị từ chối</span>
                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                        <img src="assets/crm/media/svg/crm/user-times.svg" width="18"
                                                            height="22">
                                                        <span class="summary-amount fs-1 fw-bold">369</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Summary info box-->
                                        </div>
                                    </div>
                                    <!--end::Overview col-->
                                </div>
                                <div class="col-12 col-md-4 border-end">
                                    <!--begin::Target col-->
                                    <div class="p-6">
                                        <h3 class="fw-bold mb-2">Mục tiêu</h3>
                                        <div class="d-flex flex-column flex-column-fluid fs-3">
                                            <!--begin::Target info box-->
                                            <div class="d-flex flex-row gx-2 w-100 mb-8 py-2">
                                                <div
                                                    class="d-flex align-items-center justify-content-center bg-secondary rounded w-60px h-60px mr-2 p-4">
                                                    78%</div>
                                                <div class="d-flex flex-column w-100 ps-2 g-y-2">
                                                    <span class="fw-bold fs-4">Lượng thí sinh mới đăng ký</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: 70%;"
                                                            role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-primary">156</span>
                                                        <span>/</span>
                                                        <span>200</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Target info box-->
                                            <!--begin::Target info box-->
                                            <div class="d-flex flex-row gx-2 w-100 mb-8 py-2">
                                                <div
                                                    class="d-flex align-items-center justify-content-center bg-secondary rounded w-60px h-60px mr-2 p-4">
                                                    40%</div>
                                                <div class="d-flex flex-column w-100 ps-2 g-y-2">
                                                    <span class="fw-bold fs-4">Học phí thu được</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: 70%;"
                                                            role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-primary">65.000.000</span>
                                                        <span>/</span>
                                                        <span>250.000.000 VND</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Target info box-->
                                        </div>
                                    </div>
                                    <!--end::Target col-->
                                </div>
                                <div class="col-12 col-md-4">
                                    <!--begin::Donus Chart col-->
                                    <div class="p-6">
                                        <h3 class="fw-bold mb-2">Thống kê trạng thái</h3>
                                        <div class="row gy-md-4">
                                            <div class="col-12 col-md-6">
                                                <canvas id="ti_doughnut_chart_demo_9" class="h-250px"
                                                    data-legend-container="ti_doughnut_chart_legend_9" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div id="ti_doughnut_chart_legend_9"
                                                    class="d-flex align-items-center h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Donus Chart col-->
                                </div>
                            </div>
                        </div>
                        <!--end::Overview By Month-->
                    </div>
                    <!--end::Col-->

                </div>
                <!--begin::Pagination-->
                <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        <!--placeholder-->
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
            <!--end::Top Chart-->
        </div>
        <!--end::Content-->
    </div>
@endsection
