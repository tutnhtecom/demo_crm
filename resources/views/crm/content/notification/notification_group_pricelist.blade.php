<!DOCTYPE html>
@extends('crm.layouts.layout')
@section('title', 'Quản lý thông báo')
@section('header', 'Quản lý thông báo')
@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
            <div class="x-3 py-4">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="/crm" class="text-gray-500">
                            <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thông báo</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-primary">Thông báo học phí</li>
                    <!--end::Item-->
                </ul>
            </div>
            <!--end:Breadcrumb-->
        </div>
        <!--end::App Breadcrumb-->
        <div class="row">
            <div class="col-12 col-md-8">
                <form id="noti_price_list">
                    <div class="card">
                        <div class="card-header p-4">
                            <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                                <div class="card-title text-dark fw-bolder m-md-0 w-100">                                    
                                    <div class="col-9"><span>Thông báo học phí</span></div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 noti_price_list_container mx-4">
                            <!-- Chọn Đối tượng cần tạo học phí -->
                            <div class="form-row">
                                <div class="form-group mb-4">
                                    <fieldset class="row">
                                        <legend class="col-2 m-0">
                                            <label class="form-label m-0">Danh sách người nhận <span class="text-danger">*</span></label>
                                        </legend>
                                        <div class="col-7 d-flex flex-row align-items-center gap-3">
                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input" type="radio" name="list_people" id="candidate_checkbox" value="0" checked>
                                                <label class="text-base" for="candidate"> Thí sinh mới </label>
                                            </div>

                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input" type="radio" name="list_people" id="group_checkbox" value="1">
                                                <label class="text-base" for="group_checkbox"> Nhóm</label>
                                            </div>
                                        </div>
                                        <div class="col-3 m-0 d-flex justify-content-end">
                                            <div class="form-check d-flex flex-row align-items-center gap-3">
                                                <input type="checkbox" name="modal_auto_send_mail" id="modal_auto_send_mail" 
                                                    class="form-check-input pt-1" style="border-radius: 3px; width:20px;height: 20px;">
                                                <span style="font-size: 13px;"><strong>Tắt tự động gửi mail</strong></span>
                                            </div>     
                                        </div>
                                    </fieldset>
                                </div>
                            </div>                            
                            <div class="row">
                                <!-- Họ và tên -->
                                <div class="col-6 col-md-6">
                                    <div class="mb-6">
                                        <label for="modal_thread" class="form-label">Họ và tên:</label>
                                        <select id="select_leads_price_list" name="price-name-lead" aria-label="Chọn khách hàng"
                                            data-control="select2" data-placeholder="Chọn khách hàng" class="form-select" data-multi-checkboxes="true" data-select-all="true" data-placeholder-length="140" multiple>
                                            @foreach ($data['leads'] as $lead)
                                                <option value="{{ $lead->id ?? null}}" data-id="{{ $lead->id }}"> {{ $lead->full_name ?? null}} </option>
                                            @endforeach
                                        </select>
                                        <select id="select_leads_price_list_group" name="price-name-lead" aria-label="Chọn khách hàng"
                                            data-control="select2" data-placeholder="Chọn khách hàng" class="form-select">
                                            @foreach ($data['group'] as $group)
                                                <option value="{{ $group->id ?? null}}" data-groupid="{{ $group->id }}"> {{ $group->name ?? null}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- // Chọn mẫu mail -->
                                <div class="col-6 col-md-6">
                                    <div class="mb-6">
                                        <label for="modal_thread" class="form-label">Chọn mẫu email</label>
                                        <select id="select_tempMail_price" name="" class="form-select">
                                            <option value="" disabled selected>Chọn mẫu email</option>
                                            @foreach ($resultTempEmail as $email)
                                                <option value="{{$email['file_name']}}">{{$email['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Chọn học kỳ                                 -->
                                <div class="col-6 col-md-6">
                                    <div class="mb-6 price-title-lead-wrapper">
                                        <label for="modal_thread" class="form-label">Học kỳ <span
                                            class="text-danger">*</span></label>
                                                <select id="semesterSelect" name="semesterSelect" aria-label="Chọn Học kỳ"
                                                     data-placeholder="Chọn Học kỳ" class="form-select">
                                                    @foreach ($dvlk_semesters as $semester)
                                                        @if($semester->types == 0)
                                                            <option value="{{$semester->id}}" data-name="{{$semester->note}}">{{$semester->note}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <!-- Nhập học phí -->
                                <div class="col-6 col-md-6">
                                    <div class="mb-6 noti_price_tuition_wrapper">
                                        <label class="form-label" for="modal_leaning_fee">Học phí (VND) <span
                                                class="text-danger">*</span></label>
                                            <input type="text" name="modal_leaning_fee" class="form-control"
                                            placeholder="Nhập học phí" id="noti_price_tuition" required />
                                        <p class="error-input mt-1"></p>
                                    </div>
                                </div>
                                <!-- Hạn nộp - Ngày bắt đầu nộp - Kết thúc nộp học phí-->
                                <div class="col-12 col-md-12">
                                    <div class="mb-6 noti_price_date_wrapper">
                                        <label class="form-label" for="modal_date_start">Hạn nộp <span
                                                class="text-danger">*</span></label>
                                        <div class="d-flex flex-stack">
                                            <input type="date" class="form-control price-date-start" id="noti_price_date_start" required />
                                            <i class="fas fa-arrow-right-arrow-left px-4"></i>
                                            <input type="date" class="form-control" id="noti_price_date_end" required />
                                        </div>
                                        <p class="error-input mt-1 error_from_date"></p>
                                        <p class="error-input mt-1 error_to_date"></p>
                                    </div>
                                </div>
                                <!-- Ghi chú -->
                                <div class="col-6 col-md-6 py-4 mb-3">
                                    <div class="mb-6 h-100 noti_price_note_wrapper">
                                        <label class="form-label" for="modal_note">Ghi chú</label>
                                        <textarea id="noti_price_note" rows="3" class="form-control w-100 h-100"></textarea>
                                    </div>
                                </div>
                                <!-- Tệp đính kèm -->
                                <div class="col-6 col-md-6 py-4">
                                    <div class="mb-6 h-100 noti_price_file_wrapper">
                                        <label class="form-label" for="modal_attachment">Tệp đính kèm</label>
                                        <div class="d-flex flex-column align-items-center justify-content-center rounded border border-gray-300 h-100 p-6" style="max-height: 93%;">
                                            <input class="form-control" type="file" id="noti_price_file" accept=".pdf" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end align-items-center my-2 pb-3 px-4 border-0" >
                            <div class="row">             
                                <div class="col-md-12" >                                    
                                    <button id="create_noti_btn_submit" type="submit" class="btn btn-primary min-w-150px">Gửi</button>
                                </div>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>


                </form>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                            <div class="card-title text-dark fw-bolder m-md-0 w-100">                                    
                                <div class="col-12"><span>Tải danh sách học phí từ file (xlsx, xls)</span></div>                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12 d-flex justify-content-center align-self-center" >
                            <button id="btn_import_leads" type="button"  class="btn btn-primary d-flex align-items-center gap-2 crm_notification_pricelist mx-2"
                                data-bs-toggle="modal" data-bs-target="#modal_import_price_list">
                                <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
                                <span class="d-none d-md-block">Nhập dữ liệu</span>
                            </button>                                                              
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script type="module" src="/assets/crm/js/htecomJs/import_price_list.js"></script>
    @include('crm.content.leads.modal.modal_import_price_list_for_leads')
@endsection
