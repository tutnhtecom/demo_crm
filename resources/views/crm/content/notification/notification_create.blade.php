<!DOCTYPE html>
@extends('crm.layouts.layout')

@section('header', 'Quản lý thông báo')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thông báo</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Tạo thông báo</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->
        </div>
        <!--end::App Breadcrumb-->
        <div class="row gx-3">
            <div class="col-12 col-md-5">
                <form id="notification_create_form">
                    <div class="card">
                        <div class="card-header px-4 my-0 py-0">
                            <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                                <div class="card-title text-dark fw-bolder m-md-0">
                                    Tạo thông báo
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <!-- <h4>Tạo thông báo</h4> -->
                            <div class="form-row">
                                <div class="form-group">
                                    <fieldset class="row">
                                        <legend class="col-4 m-0">
                                            <label class="form-label m-0">Danh sách người nhận <span
                                                    class="text-danger">*</span></label>
                                        </legend>
                                        
                                        <div class="col d-flex flex-row align-items-center gap-3 radio_type_send_noti mx-4">
                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input" type="radio" name="receiver_type"
                                                    id="candidate" value="0">
                                                <label class="text-base" for="candidate">
                                                    Thí sinh mới
                                                </label>
                                            </div>

                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input" type="radio" name="receiver_type"
                                                    id="student" value="1">
                                                <label class="text-base" for="student">
                                                    Sinh viên
                                                </label>
                                            </div>

                                            <div class="form-check form-check-sm mx-4 my-2">
                                                <input class="form-check-input " type="radio" name="receiver_type"
                                                    id="employees" value="2" checked>
                                                <label class="text-base" for="employees">
                                                    Nhân sự
                                                </label>
                                            </div>

                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input" type="radio" name="receiver_type"
                                                    id="group" value="3">
                                                <label class="text-base" for="group">
                                                    Nhóm
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="row gx-1">
                                        <div class="col-8 col-md-12 col-sm-12 create_noti_user_wrapper mb-3">
                                            <select id="create_noti_user" data-control="select2" style="width: 200px;"
                                                data-multi-checkboxes="true" data-select-all="true" class="form-select"
                                                data-placeholder="Chọn người nhận" data-label="Chọn người nhận" multiple data-placeholder-length="55">
                                            </select>   
                                            <p class="error-input mt-1"></p>                                        
                                        </div>
                                        <div class="col-4 col-md-12 col-sm-12">
                                            <button class="btn btn-primary text-nowrap btn_import_file_send_noti" type="button" id="button-addon2">
                                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                    viewBox="0 0 19 18" fill="none">
                                                    <path opacity="0.3"
                                                        d="M17 11.9998V11.2498C17 9.12852 16.9998 8.06819 16.3408 7.40918C15.6818 6.75017 14.6212 6.75018 12.4998 6.75018H6.49983C4.37851 6.75018 3.31785 6.75018 2.65884 7.40919C2 8.06802 2 9.12797 2 11.2482V11.2498V11.9998C2 14.1212 2 15.1818 2.65901 15.8408C3.31802 16.4998 4.37868 16.4998 6.5 16.4998H12.5H12.5C14.6213 16.4998 15.682 16.4998 16.341 15.8408C17 15.1818 17 14.1212 17 11.9998Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.50001 11.8125C9.81067 11.8125 10.0625 11.5607 10.0625 11.25L10.0625 3.02058L11.3229 4.49107C11.5251 4.72694 11.8802 4.75426 12.1161 4.55208C12.352 4.34991 12.3793 3.9948 12.1771 3.75893L9.92709 1.13393C9.82023 1.00925 9.66422 0.9375 9.50001 0.9375C9.3358 0.9375 9.17979 1.00925 9.07293 1.13393L6.82293 3.75893C6.62075 3.9948 6.64807 4.34991 6.88394 4.55208C7.11981 4.75426 7.47492 4.72694 7.67709 4.49107L8.93751 3.02058L8.93751 11.25C8.93751 11.5607 9.18935 11.8125 9.50001 11.8125Z"
                                                        fill="white" />
                                                </svg> --}}
                                                Danh sách người nhận
                                            </button>

                                        </div>
                                        <div class="col-12">
                                        <div class="custom-file-upload mt-3">
                                                <input id="file-upload" type="file" accept=".csv, .xlsx" />
                                                <p class="mt-4" style="margin-bottom:0;font-size:12px;"> Tải file mẫu: <a href="assets/file/mau_thong_bao.xlsx">FILE MẪU</a> </p>
                                                <label for="file-upload" class="custom-upload-btn mt-2">
                                                    <span class="upload-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                            viewBox="0 0 19 18" fill="none">
                                                            <path opacity="0.3"
                                                                d="M17 11.9998V11.2498C17 9.12852 16.9998 8.06819 16.3408 7.40918C15.6818 6.75017 14.6212 6.75018 12.4998 6.75018H6.49983C4.37851 6.75018 3.31785 6.75018 2.65884 7.40919C2 8.06802 2 9.12797 2 11.2482V11.2498V11.9998C2 14.1212 2 15.1818 2.65901 15.8408C3.31802 16.4998 4.37868 16.4998 6.5 16.4998H12.5H12.5C14.6213 16.4998 15.682 16.4998 16.341 15.8408C17 15.1818 17 14.1212 17 11.9998Z"
                                                                fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M9.50001 11.8125C9.81067 11.8125 10.0625 11.5607 10.0625 11.25L10.0625 3.02058L11.3229 4.49107C11.5251 4.72694 11.8802 4.75426 12.1161 4.55208C12.352 4.34991 12.3793 3.9948 12.1771 3.75893L9.92709 1.13393C9.82023 1.00925 9.66422 0.9375 9.50001 0.9375C9.3358 0.9375 9.17979 1.00925 9.07293 1.13393L6.82293 3.75893C6.62075 3.9948 6.64807 4.34991 6.88394 4.55208C7.11981 4.75426 7.47492 4.72694 7.67709 4.49107L8.93751 3.02058L8.93751 11.25C8.93751 11.5607 9.18935 11.8125 9.50001 11.8125Z"
                                                                fill="white" />
                                                        </svg>                                                            
                                                    </span> Tải tệp lên
                                                </label>
                                                <span id="file-name">Không có tệp nào được chọn</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-6">
                                <div class="form-group create_noti_title_wrapper">
                                    <label for="title" class="form-label">Tiêu đề <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="create_noti_title" name="title"
                                        placeholder="Nhập tiêu đề" />
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                            <div class="form-row mt-6">
                                <div class="form-group create_noti_content_wrapper">
                                    <label for="notification_content" class="form-label">Nội dung <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="create_noti_content" name="content" rows="5" placeholder="Nhập nội dung"></textarea>
                                    <p class="error-input mt-1"></p>
                                </div>
                            </div>
                            <div class="form-row mt-6">
                                <div class="form-group create_noti_send_type_wrapper">
                                    <label class="form-label">Gửi tới <span class="text-danger">*</span></label>
                                    <div class="d-flex flex-row align-items-center gap-3">
                                        <div class="form-check form-check-sm">
                                            <input class="form-check-input" type="radio" name="send_to_type"
                                                id="send_to_all" value="0" checked>
                                            <label class="text-base" for="send_to_all">
                                                Tất cả
                                            </label>
                                        </div>

                                        <div class="form-check form-check-sm">
                                            <input class="form-check-input" type="radio" name="send_to_type"
                                                id="send_to_mail" value="1">
                                            <label class="text-base" for="send_to_mail">
                                                Mail
                                            </label>
                                        </div>

                                        <div class="form-check form-check-sm system_radio_wrapper">
                                            <input class="form-check-input" type="radio" name="send_to_type"
                                                id="send_to_system" value="2" >
                                            <label class="text-base" for="send_to_system">
                                                Hệ thống
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Actions-->
                        <div class="flex-wrap gap-3contract_btn_create card-footer d-flex justify-content-around align-items-center">
                            <button id="create_noti_btn_submit" type="submit" value="submit" class="btn btn-primary min-w-150px">
                                Gửi
                            </button>
                            <button id="create_noti_btn_draft" type="submit" value="save"
                                class="btn btn-primary bg-primary bg-opacity-50 text-white min-w-150px">
                                Lưu nháp
                            </button>
                            <button type="reset" class="btn bg-gray-300 text-base min-w-150px">
                                Hủy
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-7">
                <!--begin::Content-->
                <div class="card">
                    <!--begin::Toolbar-->
                    <div class="card-header p-4">
                        <!--begin::Toolbar wrapper-->
                        <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                            <!--begin::Title-->
                            <h3 class="card-title text-dark fw-bolder m-md-0">Lịch sử thông báo</h3>
                            <!--end::Title-->
                            <!--begin::Search & Sort-->
                            <div class="d-flex align-items-center gap-2 gap-md-0 mx-auto ms-md-auto me-md-0 mb-3 mb-md-0">
                                <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                                {{-- <form class="w-100 position-relative mb-lg-0" autocomplete="off">
                                    <!--begin::Hidden input(Added to disable form autocomplete)-->
                                    <input type="hidden" />
                                    <!--end::Hidden input-->
                                    <!--begin::Icon-->
                                    <i
                                        class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>

                                    <input id="search_noti_table" type="text"
                                        class="search-input form-control form-control-sm border border-gray-300 rounded h-lg-40px ps-13"
                                        name="search" value="" placeholder="Tìm kiếm..." />

                                    <span
                                        class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
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
                                </form> --}}
                                <!--end::Form-->                              
                            </div>
                            <!--begin::Search & Sort-->
                        </div>
                        <!--end::Toolbar wrapper-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Body-->
                    <div class="card-body py-6 px-10">
                        <ul class="crm_tabs nav nav-tabs nav-small-tabs pb-3 tab_notification_table" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="latest-tab" data-bs-toggle="tab"
                                    data-bs-target="#latest" type="button" role="tab" aria-controls="latest"
                                    aria-selected="false">
                                    <span>Mới nhất</span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="send-tab" data-bs-toggle="tab" data-bs-target="#send"
                                    type="button" role="tab" aria-controls="send" aria-selected="true">
                                    <span>Đã gửi</span>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft"
                                    type="button" role="tab" aria-controls="draft" aria-selected="false">
                                    <span>Nháp</span>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Đánh sách mới nhất -->
                            @include('crm.content.notification.tabs.notification_lastest_tab')        
                            <!-- Danh sách đã gửi -->
                            @include('crm.content.notification.tabs.notification_send_tab')
                            <!-- Danh sách Nháp -->
                            @include('crm.content.notification.tabs.notification_draft_tab')
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Content-->
            </div>
        </div>

    </div>
@endsection

<script>
    var leads     = @json($data['leads']);
    var students  = @json($data['students']);
    var employees = @json($data['employees']);
    var group     = @json($data['group']);
</script>
