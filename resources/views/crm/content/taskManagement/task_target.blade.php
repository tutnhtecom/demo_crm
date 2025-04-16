<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý nhân viên')
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
                    <li class="breadcrumb-item text-primary">Chỉ tiêu tuyển sinh</li>
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
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chỉ tiêu tuyển sinh</h3>
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
                            <input id="search_task_target" type="text"
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
                        <div class="vr d-none d-md-block text-gray-400 mx-4"></div>
                    </div>                   
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">

                        <!--begin:Action Buttons-->
                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <button id="task_target_btn_submit" type="submit"
                                class="btn btn-primary bg-primary d-flex align-items-center gap-1 task_target_btn_submit">
                                <span class="d-none d-md-inline">Lưu thay đổi</span>
                            </button>
                            <button id="task_target_btn_submit" type="submit"
                                class="btn btn-success d-flex align-items-center gap-1 task_auto"
                                data-bs-toggle="modal" data-bs-target="#taskAuto">
                                <span class="d-none d-md-inline">Chia KPI tự động</span>
                            </button>
                            @include('crm.content.taskManagement.task_auto_device_kpi')
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>

            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6"></div>     
                    <div class="col-md-3"></div>               
                    <div class="col-md-3">                                                
                        <select id="kpi_semester_select" name="kpi_semester_select" aria-label="Chọn Học kỳ "
                            data-placeholder="Chọn Học kỳ" class="form-select h-lg-40px">
                            @if (isset($dvlk_semesters) && count($dvlk_semesters) > 0)
                                @foreach ($dvlk_semesters as $semester)
                                    @if ($semester->types == 0)
                                        <option value="{{ $semester->id }}" data-name="{{ $semester->note }}"
                                            data-academy-id="{{ $semester->academy_id }}"
                                            data-admission-date = "{{ $semester->admission_date }}"
                                            data-semesters-from-year="{{ $semester->semesters_from_year }}"
                                            data-semesters-to-year = "{{ $semester->semesters_to_year }}">
                                            {{ $semester->note }}
                                        </option>
                                    @endif
                                @endforeach
                            @else
                                <option value="#">Chọn học kỳ</option>
                            @endif
                        </select>
                       
                    </div>
                </div>
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table id="task_target_table"
                        class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-white">
                                <th rowspan="2" class="text-center align-middle w-80px p-4">STT</th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center">Nhân viên</th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center min-w-100px">Vai trò
                                </th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center min-w-100px">Ngày bắtđầu</th>
                                <th rowspan="2" class="text-nowrap align-middle fs-5 text-center min-w-100px">Ngày kếtthúc</th>
                                <th colspan="2" class="text-nowrap align-middle fs-5 text-center w-800px">Giao chỉ tiêutuyển sinh (KPI)</th>
                            </tr>
                            <tr class="text-white secondary-table-head">
                                <th class="text-nowrap align-middle fs-5 text-center w-400px">Học phí phải thu (VND/Khoá)
                                </th>
                                <th class="text-nowrap align-middle fs-5 text-center w-400px">Thí sinh (Thí sinh/Khoá)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if (isset($data->data))
                                @foreach ($data->data as $employee)
                                    <tr>
                                        <td class="align-middle text-center p-4">
                                            {{ $count++ }}
                                        </td>
                                        <td class="align-middle px-2 px-md-4 py-4">
                                            <div class="d-flex flex-stack">
                                                <!--begin::Symbol-->
                                                <div class="symbol rounded-full overflow-hidden symbol-40px me-5">
                                                    @if (!empty($employee->files))
                                                        @foreach ($employee->files as $file)
                                                            @if ($file->types == 0 && $file != null)
                                                                <img src="{{ $file->image_url }}" class="h-40 align-self-center"
                                                                    alt="">
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <img src="assets/crm/media/svg/avatars/blank.svg"
                                                            class="h-40 align-self-center" alt="">
                                                    @endif
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Section-->
                                                <div class="d-flex flex-column align-items-start flex-row-fluid flex-wrap">
                                                    <!--begin:Author-->
                                                    <div class="flex-grow-1 me-2">
                                                        <span class="text-nowrap text-gray-800 text-hover-primary fs-5 fw-bold">
                                                            {{ $employee->name ?? '' }}
                                                        </span>
                                                        <span
                                                            class="text-muted fw-semibold d-block fs-6">{{ $employee->code }}</span>
                                                    </div>
                                                    <!--end:Author-->
                                                </div>
                                                <!--end::Section-->
                                            </div>
                                        </td>
                                        <td class="align-middle text-center px-2 px-md-4 py-4">                                        
                                            <!--begin:Author Tag-->
                                            <span class="text-nowrap fs-7 text-primary bg-primary bg-opacity-20 rounded-full px-3 py-1" 
                                                style="background-color:rgba(3, 78, 162, 0.15)!important;">
                                                {{$employee->roles->name}}
                                            </span>
                                            <!--end:Author Tag-->
                                        </td>
                                        <td class="align-middle text-center px-2 px-md-4 py-4">                                     
                                            <input name="kpi_from_date_{{ $employee->id }}"
                                                id="kpi_from_date_{{ $employee->id }}" type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ isset($kpis[$employee->id])? \Carbon\Carbon::parse($kpis[$employee->id]['from_date'])->setTimezone('+7')->format('d/m/Y'): \Carbon\Carbon::now()->startOfMonth()->setTimezone('+7')->format('d/m/Y') }}" />
                                            <!--end:Author Tag-->
                                        </td>
                                        <td class="align-middle text-center px-2 px-md-4 py-4">
                                            <!--begin:Author Tag-->
                                            <input name="kpis_to_date_{{ $employee->id }}"
                                                id="kpis_to_date_{{ $employee->id }}" type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ isset($kpis[$employee->id])? \Carbon\Carbon::parse($kpis[$employee->id]['to_date'])->setTimezone('+7')->format('d/m/Y'): \Carbon\Carbon::now()->endOfMonth()->setTimezone('+7')->format('d/m/Y') }}" />
                                            <!--end:Author Tag-->
                                        </td>
                                        <td class="align-middle text-start px-2 px-md-4 py-4">
                                            <input name="fee_kpi[{{ $employee->id }}]" id="fee_kpi_{{ $employee->id }}"
                                                type="text" class="form-control form-control-sm text-center fee_kpi_input"
                                                value="{{ isset($kpis[$employee->id]['price']) ? number_format($kpis[$employee->id]['price'], 0, ',', '.') : 0 }}">
                                            {{-- value="{{ number_format($employee->currentMonthKpis->sum('price'), 0, ',', '.') }}" /> --}}
                                        </td>
                                        <td class="align-middle text-left px-2 px-md-4 py-4">
                                            <input name="lead_kpi[{{ $employee->id }}]" id="lead_kpi_{{ $employee->id }}"
                                                type="text" class="form-control form-control-sm text-center lead_kpi_input"
                                                value="{{ isset($kpis[$employee->id]['quantity']) ? number_format($kpis[$employee->id]['quantity'], 0, ',', '.') : 0 }}">
                                            {{-- value="{{ $employee->currentMonthKpis->sum('quantity') }}" /> --}}
                                        </td>
                                    </tr>
                                @endforeach                                
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--begin::Pagination-->
                <div class="row justify-content-between">
                    <div class="col-3 d-flex align-items-center">
                        {{-- <div class="form-check form-check-sm cursor-pointer">
                            <input class="form-check-input" type="checkbox" value=""
                                name="keep_kpi_for_next_month" id="keep_kpi_for_next_month"
                                {{ $kpiStatus == 1 ? 'checked' : '' }}>
                                <label class="form-check-label text-gray-900" for="keep_kpi_for_next_month">
                                    Lưu KPI này cho các tháng tiếp theo
                                </label>
                        </div> --}}
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-end">
                            <button id="task_target_btn_submit" type="submit"
                                class="btn btn-primary bg-primary  d-flex align-items-center gap-1 task_target_btn_submit">
                                <span class="d-none d-md-inline">Lưu thay đổi</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Content-->


    </div>    
    <script>
        $(document).ready(() => {
            function updateURLParam(key, value) {
                let url = new URL(window.location);
                url.searchParams.set(key, value);
                window.history.pushState({}, '', url);
            }

            $(document).ready(function() {
                let urlParams = new URLSearchParams(window.location.search);
                let semesterId = urlParams.get('semesters_id');

                if (semesterId) {
                    $("#kpi_semester_select").val(
                    semesterId); // Chỉ cần gán giá trị, không cần trigger change
                }
            });

            $(document).on('change', '#kpi_semester_select', function(e) {
                let id = e.target.value;
                updateURLParam("semesters_id", id);                
                window.location.reload();
            });

            function updateURLParam(key, value) {
                let url = new URL(window.location.href);
                url.searchParams.set(key, value);
                window.history.pushState({}, '', url); // Cập nhật URL mà không reload
            }

        });
    </script>
@endsection
