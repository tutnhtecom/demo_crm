<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Dashboard')
<script type="module" src="{{ asset('assets/crm/js/htecomJs/global.js') }}" ></script>
{{-- <script type="module" src="{{ asset('assets/crm/js/htecomJs/dashboard.js') }}" ></script> --}}
@section('content')

    <div class="px-6">
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboard</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Thống kê</li>
                </ul>
            </div>
            <div class="d-flex justify-content-start align-items-center gap-1">
                <i class="text-primary">
                    <img src="assets/crm/media/svg/crm/calendar-2.svg" width="18" height="18" />
                </i>

                <span class="fs-6">{{ \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->locale('vi')->isoFormat('dddd • DD [tháng] MM, YYYY') }}</span>
            </div>
        </div>
        <div class="app-overview-stats">
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card p-2 mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="symbol  symbol-40px symbol-rounded bg-primary bg-opacity-15 p-4">
                                <span class="report_new_leads fs-2 fw-bold text-primary">0</span>
                            </div>
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-primary text-hover-primary mb-2">Thí sinh mới</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh mới đăng ký</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card p-2 mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="symbol  symbol-40px symbol-rounded bg-warning bg-opacity-15 p-4">
                                <span class="report_profile_success fs-2 fw-bold text-warning">0</span>
                            </div>
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-warning text-hover-warning mb-2">Hồ sơ đã nộp</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh đã nộp hồ sơ</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card p-2 mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="symbol  symbol-40px symbol-rounded bg-success bg-opacity-15 p-4">
                                <span class="report_to_students fs-2 fw-bold text-success">0</span>
                            </div>
                            <div class="ms-4">
                                <span class="fs-5 fw-bold text-success text-hover-success mb-2">Thí sinh chính
                                    thức</span>
                                <div class="fw-semibold fs-7 text-muted">Số thí sinh hoàn tất đăng ký trở thành
                                    chính thức</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 list_tasks_for_employee_wrapper">
            <div class="col-12">
                <h3>Danh sách công việc của bạn</h3>
                <div class="list_tasks_for_employee"></div>
            </div>
        </div>
        <div class="card candidate_data_status_transition_chart">
            <div class="card-header p-4">
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <h3 class="card-title text-dark fw-bolder m-md-0">Biểu đồ số lượng thí sinh theo trạng thái
                    </h3>
                    <div class="d-flex justify-content-end">
                        <div class="d-none d-md-flex align-items-center pe-4">
                            <div class="symbol symbol-40px p-0">
                                <img src="assets/crm/media/svg/crm/user-group.svg" />
                            </div>
                            <div class="mx-4">
                                <span class="fs-6 fw-bold text-muted mb-2">Tổng cộng</span>
                                <div class="report_total_leads fw-bold fs-4">0</div>
                            </div>
                        </div>
                        <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                        <div class="d-none d-md-flex align-items-center pe-4">
                            <div class="symbol symbol-40px p-0">
                                <img src="assets/crm/media/svg/crm/chart-increase.svg" />
                            </div>
                            <div class="mx-4">
                                <span class="fs-6 fw-bold text-muted mb-2">Tỷ lệ chuyển đổi</span>
                                <div class="d-flex align-items-center"><div class="rate_converts fw-bold fs-4">0</div><span>%</span></div>
                            </div>
                        </div>
                        <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                        <div id="report_total_by_status" data-ti-daterangepicker="true"
                            data-ti-daterangepicker-opens="right"
                            class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                            <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                            <div class="text-gray-600 fw-bold fs-5">Lọc</div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card-body p-4">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <table class="table table-sm table-bordered bg-transparent position-relative bordered rounded-3 m-0"
                        style="z-index: 1">
                        <tr class="table_statuses_label">

                        </tr>
                        <tr class="table_statuses_value">
                        </tr>
                        <tr class="table_dropoff_value">
                            
                        </tr>
                    </table>
                    <canvas id="ti_overview_chart_demo" class="d-none d-md-block h-300px position-absolute"
                        style="bottom: 140px;margin: 0 1px;" data-color="rgba(3,78,162,0.15)" />
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <canvas id="ti_overview_chart_demo" class="h-450px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row gx-3 gx-lg-5 mt-3">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header p-4">
                        <div
                            class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                            <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê học phí theo khoa</h3>
                            <div class="d-flex justify-content-end">
                                <div id="ti_overview_chart_legend_2" class="d-flex flex-stack align-items-center"></div>
                                <div id="filter_date_price_list" data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                    <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                    <div class="text-gray-600 fw-bold fs-5 price_list_date">Lọc</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="ti_overview_chart_demo_2" class="h-450px" />
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header p-4">
                        <div
                            class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                            <h3 class="card-title text-dark fw-bolder m-md-0">Lượng thí sinh nguồn MKT</h3>
                            <div class="d-flex justify-content-end">
                                <div id="filter_date_sources" data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
                                    <i class="ki-duotone ki-calendar-8 fs-1 ms-0 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                    <div class="text-gray-600 fw-bold fs-5 sources_date">Lọc</div>
                                </div>
                            </div>
                        </div>
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
                        <!--begin::Toolbar wrapper-->
                        <div
                            class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                            <!--begin::Title-->
                            <h3 class="card-title text-dark fw-bolder m-md-0">Thí sinh mới</h3>
                            <!--end::Title-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div id="filter_date_new_leads" data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
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
                                    <div class="text-gray-600 fw-bold fs-5 new_leads_date">Lọc</div>
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
                        <!--begin::Toolbar wrapper-->
                        <div
                            class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                            <!--begin::Title-->
                            <h3 class="card-title text-dark fw-bolder m-md-0">Top Ngành học thí sinh quan tâm</h3>
                            <!--end::Title-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div id="filter_date_major_rate" data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
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
                                    <div class="text-gray-600 fw-bold fs-5 major_rate_date">Lọc</div>
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
                                <canvas id="ti_doughnut_chart_demo_5" class="h-450px"
                                    data-legend-container="ti_doughnut_chart_legend_5" />
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
                        <!--begin::Toolbar wrapper-->
                        <div
                            class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                            <!--begin::Title-->
                            <h3 class="card-title text-dark fw-bolder m-md-0">Thống kê trạng thái </h3>
                            <!--end::Title-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div id="filter_date_status_rate" data-ti-daterangepicker="true" data-ti-daterangepicker-opens="right"
                                    class="btn btn-sm btn-light d-flex align-items-center border border-gray-300 px-4 mx-auto mx-md-none">
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
                                    <div class="text-gray-600 fw-bold fs-5 status_rate_date">Lọc</div>
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
                                <canvas id="ti_doughnut_chart_demo_6" class="h-450px"
                                    data-legend-container="ti_doughnut_chart_legend_6" />
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
        <div class="row gx-3 gx-lg-5 mt-3 py-5">
            <p></p>
        </div>
    </div>
@endsection

<script src="/assets/crm/plugins/global/plugins.bundle.js"></script>
<script src="/assets/crm/js/scripts.bundle.js"></script>
<script src="/assets/crm/plugins/custom/chartjs-plugin-labels.bundle.js"></script>
<script src="/assets/crm/js/custom/utilities/form/select.js"></script>
<script src="/assets/crm/js/custom/pages/dashboard/overview.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboard.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboardPriceList.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboardSources.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboardNewLeads.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboardMarjorRate.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/dashboardStatusRate.js"></script>

{{-- <script type="application/javascript">
    'use strict';
    var TI_Overview = function () {
        var getOrCreateLegendList = (chart, id) => {
            const legendContainer = document.getElementById(id);
            let listContainer = legendContainer.querySelector('ul');

            if (!listContainer) {
                listContainer = document.createElement('ul');
                listContainer.style.display = 'flex';
                listContainer.style.flexDirection = 'column';
                listContainer.style.margin = 0;
                listContainer.style.padding = 0;

                legendContainer.appendChild(listContainer);
            }

            return listContainer;
        };
        var htmlLegendPlugin = {
            id: 'htmlLegend',
            afterUpdate(chart, args, options) {
                const ul = getOrCreateLegendList(chart, options.containerID);

                // Remove old legend items
                while (ul.firstChild) {
                    ul.firstChild.remove();
                }

                // Reuse the built-in legendItems generator
                const items = chart.options.plugins.legend.labels.generateLabels(chart);

                items.forEach(item => {
                    const li = document.createElement('li');
                    li.style.alignItems = 'center';
                    li.style.cursor = 'pointer';
                    li.style.display = 'flex';
                    li.style.flexDirection = 'row';
                    li.style.marginLeft = '10px';
                    li.style.marginBottom = '10px';
                    li.className = 'fs-4';

                    li.onclick = () => {
                        const {type} = chart.config;
                        if (type === 'pie' || type === 'doughnut') {
                            // Pie and doughnut charts only have a single dataset and visibility is per item
                            chart.toggleDataVisibility(item.index);
                        } else {
                            chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                        }
                        chart.update();
                    };

                    // Color box
                    const boxSpan = document.createElement('span');
                    boxSpan.style.background = item.fillStyle;
                    boxSpan.style.borderColor = item.strokeStyle;
                    boxSpan.style.borderWidth = item.lineWidth + 'px';
                    boxSpan.style.display = 'inline-block';
                    boxSpan.style.flexShrink = 0;
                    boxSpan.style.height = '20px';
                    boxSpan.style.marginRight = '10px';
                    boxSpan.style.width = '20px';
                    boxSpan.style.borderRadius = '4px';

                    // Text
                    const textContainer = document.createElement('p');
                    textContainer.style.color = item.fontColor;
                    textContainer.style.margin = 0;
                    textContainer.style.padding = 0;
                    textContainer.style.textDecoration = item.hidden ? 'line-through' : '';

                    const text = document.createTextNode(item.text);
                    textContainer.appendChild(text);

                    li.appendChild(boxSpan);
                    li.appendChild(textContainer);
                    ul.appendChild(li);
                });
            }
        }
        var initialChart = function() {
            var ctx = document.getElementById('ti_overview_chart_demo');
            // Get table above current element
            var table = ctx.previousElementSibling;
            var lastRow = table.rows[ table.rows.length - 1 ];
            var lastRowHeight = lastRow.offsetHeight;

            ctx.style.bottom = lastRowHeight + 'px';
            // Define colors
            var chartColor = TI_Util.getCssVariableValue('--bs-text-gray-300');

            if (ctx.getAttribute('data-color-variable')) {
                chartColor = TI_Util.getCssVariableValue(ctx.getAttribute('data-color-variable'));
            }

            if (ctx.getAttribute('data-color')) {
                chartColor = ctx.getAttribute('data-color');
            }


            // Chart labels
            const labels = ['1', '2', '3', '4', '5', '6', '7', '8'];

            // Chart data
            const data = {
                labels: labels,
                datasets: [{
                    label: 'dataset',
                    data: [
                        90,
                        20,
                        30,
                        40,
                        90,
                        20,
                        30,
                        40
                    ],
                    borderColor: chartColor,

                    fill: true,
                    borderWidth: 0,
                    lineTension: 0.4,
                    backgroundColor: [
                        chartColor
                    ],
                    hoverOffset: 0
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    animation: {
                        onComplete: function() {


                        }
                    },
                    responsive: true,
                    plugins: {
                        tooltip: {
                            enabled: false
                        },
                        legend: {
                            display: false
                        },
                        filler: {
                            propagate: false,
                        },
                        title: {
                            display: false,
                        }
                    },
                    scales: {
                        x: {
                            display: false,

                        },
                        y: {
                            display: false
                        }
                    },

                    elements: {
                        point:{
                            radius: 0
                        }
                    },
                    interaction: {
                        intersect: false,
                    }
                },
            };


            // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
            return new Chart(ctx, config);
        }

        var initialChart2 = function() {
            var ctx = document.getElementById('ti_overview_chart_demo_2');

            var color1 = TI_Util.getCssVariableValue('--bs-text-gray-400');
            var color2 = TI_Util.getCssVariableValue('--bs-text-success');

            const labels = [
                'Khoa đào tạo sau đại học',
                'Khoa Công nghệ Thông tin',
                'Khoa kinh tế và Quản lý công',
                'Khoa Tài chính - Ngân hàng',
                'Khoa Khoa học cơ bản',
                'Khoa Đào tạo Đặc biệt',
                'Khoa Kế toán - Kiểm toán',
                'Khoa Ngoại ngữ',
                'Khoa Xây dựng',
                'Khoa Công nghệ Sinh học',
                'Khoa Luật',
                'Khoa XHH - CTXH - ĐNA'
            ];
            // Chart data
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Học phí dự kiến',
                        data: [
                            90,
                            20,
                            30,
                            40,
                            10,
                            20,
                            30,
                            40,
                            30,
                            20,
                            30,
                            40
                        ],
                        backgroundColor: color1
                    },
                    {
                        label: 'Học phí thu về',
                        data: [
                            60,
                            50,
                            30,
                            70,
                            20,
                            10,
                            70,
                            60,
                            30,
                            60,
                            20,
                            90
                        ],
                        backgroundColor: color2
                    }
                ]
            };
            const config = {
                type: 'bar',
                data: data,
                plugins: [{
                    id: "htmlLegend",
                    afterUpdate: function(chart, agrs, options) {
                        const legendContainer = document.getElementById(options.containerID);
                        // Remove old legend
                        legendContainer.innerHTML = '';
                        // Reuse the built-in legendItems generator
                        const items = chart.options.plugins.legend.labels.generateLabels(chart);

                        items.forEach(function(item) {
                            const wrapperDiv = document.createElement('div');
                            wrapperDiv.className = 'd-none d-md-flex align-items-center pe-4';
                            const formCheckDiv = document.createElement('div');
                            formCheckDiv.className = 'form-check form-switch form-check-custom form-switch-sm';
                            const input = document.createElement('input');
                            input.className = 'form-check-input';
                            input.type = 'checkbox';
                            // input.checked = 'checked';
                            input.checked = chart.isDatasetVisible(item.datasetIndex);
                            input.id = 'flexSwitchCheckChecked_' + item.datasetIndex;
                            input.onchange = (elm, event) => {
                                const {type} = chart.config;
                                if (type === 'pie' || type === 'doughnut') {
                                    // Pie and doughnut charts only have a single dataset and visibility is per item
                                    chart.toggleDataVisibility(item.index);
                                } else {
                                    chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                                }

                                chart.update();
                            };
                            const label = document.createElement('label');
                            label.className = 'form-check-label';
                            label.for = 'flexSwitchCheckChecked' + item.datasetIndex;
                            const text = document.createTextNode(item.text);
                            label.style.color = item.fillStyle;
                            label.appendChild(text);
                            formCheckDiv.appendChild(input);
                            formCheckDiv.appendChild(label);
                            wrapperDiv.appendChild(formCheckDiv);

                            legendContainer.appendChild(wrapperDiv);
                        });
                    }
                }],
                options: {
                    left: 500,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        bar: {
                            borderWidth: 0,
                        }
                    },
                    layout: {
                        padding: {
                            right: 20
                        }
                    },
                    responsive: true,
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
                            //     return args.value.label;
                            // },
                            render: 'value',
                            // fontSize: 12,
                            arc: false,
                            precision: 0,
                            // outsidePadding: -18,
                            textMargin: -6,
                            textHorizontalMargin: 12
                        },
                        htmlLegend: {
                            containerID: 'ti_overview_chart_legend_2'
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                align: 'start',
                                text: '(Triệu VND)',
                                crossAlign: "far",
                                padding: "-100 -100"
                            }
                        },

                    }
                },
            };
            // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
            return new Chart(ctx, config);
        }

        var initialChart3 = function() {
            var ctx = document.getElementById('ti_overview_chart_demo_3');

            var color1 = TI_Util.getCssVariableValue('--bs-text-secondary');
            var color2 = TI_Util.getCssVariableValue('--bs-text-danger');
            var color3 = TI_Util.getCssVariableValue('--bs-text-warning');
            var color4 = TI_Util.getCssVariableValue('--bs-text-success');
            var color5 = TI_Util.getCssVariableValue('--bs-text-primary');

            const labels = [
                'Facebook',
                'Website',
                'Landing page',
                'Tờ rơi',
                'Youtube'
            ];
            // Chart data
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'data1',
                        data: [
                            758,
                            580,
                            975,
                            430,
                            590
                        ],
                        backgroundColor: [
                            color1, color2, color3, color4, color5
                        ],
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
                            render: 'value',
                            precision: 0,
                            // textMargin: -6,
                            // textHorizontalMargin: 12
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

        var initialChart4 = function() {
            var ctx = document.getElementById('ti_overview_chart_demo_4');

            var color1 = TI_Util.getCssVariableValue('--bs-text-primary');

            const labels = [
                '15/3',
                '16/3',
                '17/3',
                '18/3',
                '19/3'
            ];
            // Chart data
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'data1',
                        data: [
                            152,
                            163,
                            336,
                            631,
                            503,
                            845,
                            804,
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
                            render: 'value',
                            precision: 0,
                            // textMargin: -6,
                            // textHorizontalMargin: 12
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
        var initialChart5 = function() {
            var ctx = document.getElementById('ti_doughnut_chart_demo_5');
            var legend_container_id = ctx.getAttribute('data-legend-container');

            // Define fonts
            var fontFamily = TI_Util.getCssVariableValue('--bs-font-sans-serif');

            // Chart labels
            const labels = [
                'Khoa học công nghệ - Thông tin',
                'Khoa Tài chính - Ngân hàng',
                'Khoa Kế toán - Kiểm toán',
                'Khoa Ngoại ngữ',
                'Khoa Luật'];

            // Chart data
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Chart 5',
                    data: [
                        20,
                        10,
                        28,
                        30,
                        12
                    ],
                    backgroundColor: [
                        '#034EA2',
                        '#387EC1',
                        '#6DABE5',
                        '#B8D2EC',
                        '#7E7E7E'
                    ],
                    hoverOffset: 4
                }]
            };
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: false,
                        },
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    size: 18
                                }
                            }
                        },
                        // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
                        labels: {
                            // render: function(args) {
                            //     return args.value.label;
                            // },
                            render: 'percentage',
                            fontColor: '#fff',
                            fontSize: 18,
                            textShadow: true,
                            arc: false,
                            precision: 0
                        }
                    },
                    cutout: '30%',
                },
                defaults:{
                    global: {
                        defaultFont: fontFamily
                    }
                }
            };
            if (legend_container_id) {
                config.options.plugins.legend.display = false;
                config.options.plugins.htmlLegend = {
                    // ID of the container to put the legend in
                    containerID: legend_container_id,
                };
                if (!Array.isArray(config.plugins)) {
                    config.plugins = [];
                }
                config.plugins.push(htmlLegendPlugin);
            }
            // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
            return new Chart(ctx, config);
        }

        var initialChart6 = function() {
            var ctx = document.getElementById('ti_doughnut_chart_demo_6');
            var legend_container_id = ctx.getAttribute('data-legend-container');

            // Define colors
            var primaryColor = TI_Util.getCssVariableValue('--bs-primary');
            var dangerColor = TI_Util.getCssVariableValue('--bs-danger');
            var successColor = TI_Util.getCssVariableValue('--bs-success');
            var infoColor = TI_Util.getCssVariableValue('--bs-info');

            // Define fonts
            var fontFamily = TI_Util.getCssVariableValue('--bs-font-sans-serif');

            // Chart labels
            const labels = ['Đang liên hệ', 'Đang nộp hồ sơ', 'Thí sinh chính thức', 'Thí sinh từ chối'];



            // Chart data
            const data = {
                labels: labels,
                datasets: [{
                    label: 'DEMO CHART',
                    data: [
                        10,
                        20,
                        30,
                        40
                    ],
                    backgroundColor: [
                        primaryColor,
                        dangerColor,
                        successColor,
                        infoColor,
                    ],
                    hoverOffset: 4
                }]
            };

            // Chart config
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: false,
                        },
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    size: 18
                                }
                            }
                        },
                        // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
                        labels: {
                            render: 'percentage',
                            fontColor: '#fff',
                            fontSize: 18,
                            textShadow: true,
                            arc: false,
                            precision: 0
                        }
                    },
                    cutout: '30%',
                    responsive: true,
                    maintainAspectRatio: false,
                },
                defaults:{
                    global: {
                        defaultFont: fontFamily
                    }
                }
            };

            if (legend_container_id) {
                config.options.plugins.legend.display = false;
                config.options.plugins.htmlLegend = {
                    // ID of the container to put the legend in
                    containerID: legend_container_id,
                };
                if (!Array.isArray(config.plugins)) {
                    config.plugins = [];
                }
                config.plugins.push(htmlLegendPlugin);
            }

            // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
            return new Chart(ctx, config);
        }

        return {
            init: function() {
                initialChart();
                initialChart2();
                initialChart3();
                initialChart4();
                initialChart5();
                initialChart6();
            }
        }
    }();
    // On document ready
    TI_Util.onDOMContentLoaded(function () {
        TI_Overview.init();
    });
</script> --}}
@php
    $jwt_token = isset($_GET['token']) ? $_GET['token'] : '';
@endphp
<script>
    $(document).ready(() => {
        const token = "{{ $jwt_token }}";
        if(token){
            localStorage.setItem('jwt_token', token);  // Lưu token vào localStorage
        }
    });
</script>
