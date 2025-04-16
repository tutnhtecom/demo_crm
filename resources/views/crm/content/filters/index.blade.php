{{-- <!DOCTYPE html> --}}
@extends('crm.layouts.layout')

@section('header', 'Cấu hình')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Bộ lọc thời gian</li>
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
                    <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách bộ lọc</h3>
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
                            <input id="search_input_status" type="text"
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
                    </div>
                    <!--begin::Search & Sort-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">

                        <!--begin:Action Buttons-->
                        <!-- data-bs-toggle="modal" data-bs-target="#modal_add_filter" -->
                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <a href="javascript:void(0);" onclick="create_item()" 
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
                                <span class="d-none d-md-inline">Thêm mới</span>
                            </a>                           
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->

            </div>
            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <div class="card-body p-4 overflow-x-auto">
                <div class="table-responsive position-relative border rounded-3 my-3">
                    <!--begin::Table-->
                    <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100"
                        id="table_status">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-center px-4 w-80px">STT</th>
                                <th class="text-nowrap align-middle fs-5 text-left px-4">Tên bộ lọc</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày bắt đầu</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày kết thúc</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data['data']))
                                @foreach ($data['data'] as $key => $item)                                
                                    <tr>
                                        <td class="align-middle px-2 text-primary text-center" > {{$key + 1}} </td>
                                        <td class="align-middle px-2 px-md-4 py-4 text-primary"> {{$item['name']}} </td>                                      
                                        <td class="align-middle px-2 px-md-4 py-4 text-center">
                                            {{ $item['start_date'] ? \Carbon\Carbon::parse($item['start_date'])->format('d/m/Y') : '-'  }}
                                        </td>
                                        <td class="align-middle px-2 px-md-4 py-4 text-center">
                                            {{ $item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('d/m/Y') : '-'  }}
                                        </td>
                                        <td class="align-middle text-center">     
                                            <button type="button" class="btn btn-ghost p-1 update_config_filter" data-id="{{$item['id']}}" name="update_item" onclick="update_item(<?= $item['id'] ?>)" id="update_filter_{{$item['id']}}" 
                                                data-name="{{$item['name']}}" data-start-date="{{$item['start_date']}}" data-end-date="{{$item['end_date']}}" >
                                                <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18" height="18" />
                                            </button>
                                            <button type="button" class="btn btn-ghost p-1" name="delete_item" onclick="delete_item(<?= $item['id'] ?>)" data-id="{{$item['id']}}">
                                                <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18" />
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach                            
                            @endif
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>                               
              
                <!--end::Pagination-->
            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Content-->
        @include('crm.content.filters.modal.modal_add_filter')
        @include('crm.content.filters.modal.modal_delete_filter')        
        @include('crm.content.filters.modal.modal_modify_filter')        
    </div>
    <script type="module" src="/assets/crm/js/htecomJs/Filters/createFilter.js"></script>
    <script type="module" src="/assets/crm/js/htecomJs/Filters/deleteFilters.js"></script>
    <script>
        $(document).ready(()=>{
            let name = null;
            let start_date = null;
            let end_date = null;
        });
        function delete_item(id) {
            $('#modal_delete_filter').modal("show");            
            let element = document.getElementById("btn_delete_filter");
            element.setAttribute("data-id", id);
        }
        function update_item(id) {            
            let name = $("#update_filter_" + id).attr('data-name'); 
            let start_date = $("#update_filter_" + id).attr('data-start-date'); 
            let end_date = $("#update_filter_" + id).attr('data-end-date'); 
            let html = ` <form id="create-filter-form">
                    <!-- Họ và tên -->
                    <div class="row create_filter_name">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Tên bộ lọc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_name_wrapper">
                            <input type="text" name="name" id="u_name" placeholder="Nhập..." class="form-control" value="`+ name +`">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày bắt đầu -->
                    <div class="row my-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Ngày bắt đầu</span>
                            <span class="text-danger"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_start_date">
                            <input type="date" name="start_date" id="u_start_date"  placeholder="dd/mm/yyyy"  class="form-control" value="`+ start_date +`" >
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày kết thúc -->
                    <div class="row">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Kết thúc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_end_date" >
                            <input type="date" name="end_date" id="u_end_date"  placeholder="dd-mm-yyyy" class="form-control" value="`+ end_date +`">
                            <p class="error-input mt-1"></p>
                        </div>
                        
                    </div>
                </form>`;
            $('#modal_update_filter').modal("show");
            $('#html_append').html(html);
            // let element = document.getElementById("btn_update_filter");
            // element.setAttribute("data-id", id);
        }
        function create_item(){
            $('#modal_add_filter').modal("show");  
            let html = ` <form id="create-filter-form">
                    <!-- Họ và tên -->
                    <div class="row create_filter_name">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Tên bộ lọc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_name_wrapper">
                            <input type="text" name="name" id="name" placeholder="Nhập..." class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày bắt đầu -->
                    <div class="row my-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Ngày bắt đầu</span>
                            <span class="text-danger"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_start_date">
                            <input type="date" name="start_date" id="start_date"  placeholder="dd/mm/yyyy"  class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!-- Ngày kết thúc -->
                    <div class="row mb-3">
                        <div class="col-lg-3 div_label">
                            <span class="span_lbl">Kết thúc</span>
                            <span class="text-danger pl-2"> (*)</span>
                        </div>
                        <div class="col-lg-9 create_filter_end_date" >
                            <input type="date" name="end_date" id="end_date"  placeholder="dd-mm-yyyy" class="form-control">
                            <p class="error-input mt-1"></p>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary py-2" id="btn_add_filter">
                                Tạo mới
                            </button>
                        </div>
                    </div>
                </form> `;
            $('#create_html_append').html(html);   
        }
    </script>

@endsection

