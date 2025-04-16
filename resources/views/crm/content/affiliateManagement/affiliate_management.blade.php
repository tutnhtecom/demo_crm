@extends('crm.layouts.layout')
@section('header', 'Quản lý đơn vị liên kết')
@section('title', 'Quản lý đơn vị liên kết')
@section('content')
    <div class="px-6"> 
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý đơn vị liên kết</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Quản lý đơn vị liên kết</li>
                </ul>
            </div>

        </div>
        <div class="card">
            <div class="card-header p-4">
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">

                    <h3 class="card-title text-dark fw-bolder m-md-0">Đơn vị liên kết</h3>

                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
                        <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                            <input type="hidden" />
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input id="search-dvlk" type="text"
                                class="search-input form-control form-control border border-gray-300 rounded h-lg-40px ps-13"
                                name="search" value="" placeholder="Tìm kiếm..." />
                            <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                                <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                            </span>
                            <span
                                class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                                <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </form>
                        <div class="vr d-none d-md-block text-gray-400 mx-8"></div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex align-items-center gy-2 gap-1">
                            <a href="/candidate/add-new.html" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#affiliateCreateModal">
                                <img src="assets/crm/media/svg/crm/add-circle.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Thêm mới</span>
                            </a>
                        <button id="btn_import_sources" type="button"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead" 
                            data-bs-toggle="modal" data-bs-target="#importSourcesModal">
                            <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Import excel</span>
                        </button>
                        <button id="btn_import_sources" type="button"
                            class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead" 
                            data-bs-toggle="modal" data-bs-target="#importSourcesPriceListsModal">
                            <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Import học phí</span>
                        </button>
                        <button id="btn_export_overview" type="button" class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1">                            
                            <img src="assets/crm/media/svg/crm/calculator-excel.svg" width="22" height="22" />
                            <span class="d-none d-md-block">Xuất tổng quản</span>
                        </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0"
                        id="affiliate_sources_table">
                        <thead>
                            <tr class="bg-primary text-white">
                                {{-- <th class="w-40px"></th> --}}
                                <th class="text-nowrap fs-5 text-center pe-7">Phân loại</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Tên ĐVLK</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Mã ĐVLK</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Địa phương</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Lãnh đạo</th>
                                <th class="text-nowrap fs-5 text-start pe-7">Nhân sự đầu mối</th>
                                <th class="text-nowrap fs-5 text-center pe-7">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach ($affiliateSources as $item)
                                    @php
                                        if($item['sources_types'] == 1){
                                            continue;
                                        }
                                        $managers = json_decode($item['sources_manager_name'], true);
                                        $employees = json_decode($item['sources_employees_name'], true);
                                    @endphp
                                <tr>
                                    {{-- <td class="align-middle text-center ps-2">
                                        <div class="form-check form-check-sm">
                                            <input class="form-check-input inrow-checkbox" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td> --}}
                                    <td class="align-middle px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                                 {{$item['sources_types']}}
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="{{ route('crm.affiliate.detail', ['id' => $item['id']]) }}"
                                            class="text-private text-nowrap fw-bold text-hover-primary mb-1 fs-6">
                                                <span class="d-flex gap-1 align-items-center d-block fs-5">
                                                    {{$item['name'] ?? null}}
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-start px-2 px-md-4 py-4">
                                        <div class="d-flex flex-stack">
                                            {{$item['code'] ?? null}}
                                        </div>
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        {{$item['location_name'] ?? null}}
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        @if(is_array($managers) && count($managers) > 0)
                                            @foreach($managers as $key => $manager)
                                            <div class="employee_name">Tên: {{ $manager['name'] ?? null }}</div>
                                            <div class="employee_position">{{ $manager['positions'] ? 'Chức vụ: '. $manager['positions'] : null }}</div>
                                            <div class="employee_email">{{ $manager['email'] ? 'Email: '. $manager['email'] : null }}</div>
                                            <div class="employee_phone">{{ $manager['phone'] ? 'SĐT: '. $manager['phone'] : null }}</div>                                           
                                            @endforeach
                                        @else
                                            Không có quản lý nào.
                                        @endif
                                    </td>
                                    <td class="align-middle text-start fs-5 px-2 px-md-4 py-4">
                                        @if(is_array($employees) && count($employees) > 0)
                                            @foreach($employees as $k => $employee)
                                                <div class="employee_name">Tên: {{ $employee['name'] ?? null }}</div>
                                                <div class="employee_position">{{ $employee['positions'] ? 'Chức vụ: '. $employee['positions'] : null }}</div>
                                                <div class="employee_email">{{ $employee['email'] ? 'Email: '. $employee['email'] : null }}</div>
                                                <div class="employee_phone">{{ $employee['phone'] ? 'SĐT: '. $employee['phone'] : null }}</div>
                                                @if($k == 0 && count($employees) > 1)
                                                    <hr />
                                                @endif
                                            @endforeach
                                        @else
                                            Không có quản lý nào.
                                        @endif
                                    </td>
                                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                                        <button type="button" class="btn btn-ghost p-1" data-bs-toggle="modal" data-bs-target="#affiliateDeleteModal{{$item['id']}}">
                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                        </button>
                                        @include('crm.content.affiliateManagement.affiliate_modal_delete')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @include('crm.content.affiliateManagement.component.affiliate_modal_import_sources', ["academic_terms" => $academic_terms])
    @include('crm.content.affiliateManagement.affiliate_modal_create')
    @include('crm.content.affiliateManagement.component.affiliate_modal_import_sources_price_list')
    
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/affiliateSource.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/deleteAffiliateSource.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/importSources.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/importSourcesPriceLists.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/dvlk_importSourcesPriceLists.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/Affiliate/export_overview_affiliate.js"></script>
@endsection
