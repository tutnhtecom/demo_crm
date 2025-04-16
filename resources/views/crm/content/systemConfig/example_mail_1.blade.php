<!DOCTYPE html>
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
                    <li class="breadcrumb-item text-primary">Mẫu Email</li>
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
                    <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách mẫu Email</h3>
                    <!--end::Title-->

                    <!--begin::Search & Sort-->
                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-2 mb-3 mb-md-0">
                        <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                        {{-- <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                            <input type="hidden" />
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text"
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
                        </form> --}}
                        <!--end::Form-->
                        {{-- <div class="vr d-none d-md-block text-gray-400 mx-4"></div> --}}
                        {{-- <div class="d-flex align-items-center justify-content-start">
                            <select class="lead_ordering_select w-auto form-select">
                                <option value="date-desc">Mới nhất</option>
                                <option value="date-asc">Cũ nhất</option>
                            </select>
                        </div> --}}

                    </div>
                    <!--begin::Search & Sort-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <!--begin:Action Buttons-->
                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <button data-bs-toggle="modal" data-bs-target="#createExampleEmailModal"
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
                            </button>
                            <button data-bs-toggle="modal" data-bs-target="#createTypeEmailModal"
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

                                <span class="d-none d-md-inline">Thêm mới loại mẫu</span>
                            </button>
                            <!-- Modal Create Email -->
                            @include('crm.content.systemConfig.modal_create_email')
                            @include('crm.content.systemConfig.modal_create_type_email')                            
                            <!-- END Modal Create Email -->
                        </div>

                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <!-- Nội dung bảng -->
            <div class="card-body p-4 overflow-x-auto">
                <div class="row g-3">
                    @foreach ($email_types as $e_type)
                        <div class="col-12 col-md-6">
                            <div class="table-responsive position-relative border rounded-3 my-3">
                                <!--begin::Table-->
                                <table data-class="table_example_email_{{$e_type->id}}"
                                    class="table_example_email_{{$e_type->id}} table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="bg-primary text-white">
                                            <th class="text-nowrap align-middle fs-5 text-start px-4"> {{$e_type->name}} </th>
                                            <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $hasTemplate = false;
                                        @endphp
                                        @foreach ($email_template as $e_template)
                                            @php 
                                                $status = view()->exists('includes.template.' . $e_template->file_name); 
                                            @endphp                                        
                                            @if ($e_template->types_id === $e_type->id && $status)
                                                @php
                                                    $hasTemplate = true;
                                                @endphp
                                                <tr>
                                                    <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                                        {{$e_template->title}}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" class="btn-edit-email btn btn-ghost p-1" data-id="{{$e_template->id}}" data-bs-toggle="modal" data-bs-target="#editExampleEmailModal{{$e_template->id}}">
                                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                                height="18" />
                                                        </button>

                                                        {{-- Modal edit exam mail --}}
                                                        @include('crm.content.systemConfig.modal_edit_exam_email')

                                                        <button type="button" class="btn btn-ghost p-1"
                                                            data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                            data-ti-button-action="row-remove" data-ti-row-confirm="true" data-id="{{$e_template->id}}" data-bs-toggle="modal" data-bs-target="#deleteExampleEmailModal{{$e_template->id}}">
                                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                                                height="18" />
                                                        </button>

                                                        {{-- Modal delete exam mail --}}
                                                        @include('crm.content.systemConfig.modal_delete_exam_email')
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        {{-- @if (!$hasTemplate)
                                            <tr>
                                                <td colspan="2" class="text-center">Không có mẫu nào</td>
                                            </tr>
                                        @endif --}}
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Content-->

        @include('crm.content.systemConfig.modal_key_email_template')
    </div>
    <script type="module" src="/assets/crm/js/htecomJs/createTypeEmailExample.js"></script>
    <script type="module" src="/assets/crm/js/htecomJs/createEmailExample.js"></script>
    <script type="module" src="/assets/crm/js/htecomJs/editEmailExample.js"></script>
    <script type="module" src="/assets/crm/js/htecomJs/deleteEmailExample.js"></script>

    <script>
        $('table[data-class]').each(function () {
            var tableClass = '.' + $(this).data('class'); // Lấy class động từ data-class

            // Khởi tạo DataTable
            var tableExample_Email = new DataTable(tableClass, {
                layout: {
                    topStart: 'info',
                    bottom: 'paging',
                    bottomStart: null,
                    bottomEnd: null
                },
                dom: "lrtip"
            });
        });
    </script>
@endsection

