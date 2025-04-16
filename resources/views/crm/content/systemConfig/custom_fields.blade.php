@extends('crm.layouts.layout')

@section('header', 'Cấu hình')
@section('content')
    <div class="px-6">
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Cấu hình hệ thống</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Trường tùy chỉnh</li>
                </ul>
            </div>

        </div>

        <div class="card">
            <div class="card-header p-4">
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100 justify-content-end">
                    <div class="d-flex justify-content-end">

                        <div class="d-flex md:d-block align-items-center gy-2 gap-1">
                            <button data-bs-toggle="modal" data-bs-target="#create_custom_field_modal"
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
                            @include('crm.content.systemConfig.modal_create_custom_field')
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
                        id="table_custom_field">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Trường tùy chỉnh</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Ngày tạo</th>
                                <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data)
                            @foreach ($data as $item)
                                <tr>
                                    <td class="align-middle px-2 px-md-4 py-4 text-center text-primary"> {{$item['name']}} </td>
                                    <td class="align-middle px-2 px-md-4 py-4 text-center"> {{\Carbon\Carbon::parse($item['created_at'])->format('d/m/Y')}} </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-ghost p-1" data-bs-toggle="modal" data-bs-target="#edit_custom_field_modal_{{$item['id']}}">
                                            <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                height="18" />
                                        </button>
                                        @include('crm.content.systemConfig.modal_edit_custom_field')
                                        <button type="button" class="btn btn-ghost p-1" data-bs-toggle="modal" data-bs-target="#delete_custom_field_modal_{{$item['id']}}">
                                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                                height="18" />
                                        </button>
                                        @include('crm.content.systemConfig.modal_delete_custom_field')
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script type="module" src="/assets/crm/js/htecomJs/createCustomField.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/editCustomField.js"></script>
<script type="module" src="/assets/crm/js/htecomJs/deleteCustomField.js"></script>
@endsection
