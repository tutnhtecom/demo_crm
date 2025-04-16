@extends('crm.layouts.layout')

@section('header', 'Quản lý thông báo')
@section('content')
    <div class="px-6">
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thông báo</li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <li class="breadcrumb-item text-primary">Quản lý nhóm</li>
                </ul>
            </div>

        </div>

        <div class="card">
            <div class="card-header p-4">
                <div
                    class="app-toolbar-wrapper d-flex flex-column flex-md-row flex-stack flex-wrap align-items-center w-100">
                    <h3 class="card-title text-dark fw-bolder m-md-0">Danh sách nhóm</h3>

                    <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-2 mb-3 mb-md-0">
                        <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                            <input type="hidden" />
                            <i
                                class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Input-->
                            <input type="text" id="search-input-group"
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
                        {{-- <div class="vr d-none d-md-block text-gray-400 mx-4"></div> --}}
                    </div>
                    <!--begin::Search & Sort-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->

            </div>
            <!--end::Toolbar-->
            <!--begin::Card Body-->
            <div class="card-body p-4 overflow-x-auto">
                <div class="row g-3">
                    <div class="col-12 col-md-12">
                        <div class="table-responsive position-relative border rounded-3 my-3">
                            <!--begin::Table-->
                            <table id="table_group"
                                class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-nowrap align-middle fs-5 text-center px-4" style="width:50px">ID</th>
                                        <th class="text-nowrap align-middle fs-5 text-start px-4">Danh sách các nhóm</th>
                                        <th class="text-nowrap align-middle fs-5 text-center px-4">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data_reverse =$data->reverse();
                                    @endphp
                                    @foreach ($data_reverse as $group)
                                        <tr>
                                            <td class="align-middle px-2 px-md-4 py-4 text-primary text-center">
                                                {{$group->id}}
                                            </td>
                                            <td class="align-middle px-2 px-md-4 py-4 text-primary">
                                                <a href="{{ route('crm.notification.groupsDetail', ['id' => $group->id]) }}">
                                                    {{$group->name}}
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('crm.notification.groupsDetail', ['id' => $group->id]) }}" type="button" class="btn btn-ghost p-1 crm_notification_groupsDetail">
                                                    <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                                        height="18" />
                                                </a>
                                                <button type="button" class="btn btn-ghost p-1"
                                                    data-ti-row-confirm-message="Xóa hồ sơ này?"
                                                    data-ti-button-action="row-remove" data-ti-row-confirm="true" data-bs-toggle="modal" data-bs-target="#deleteGroupModal{{$group->id}}">
                                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                                        height="18" />
                                                </button>

                                                @include('crm.content.notification.modal_delete_group')
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Card Body-->
        </div>
        <!--end::Content-->


    </div>

    <script type="module" src="/assets/crm/js/htecomJs/deleteGroup.js"></script>
@endsection
