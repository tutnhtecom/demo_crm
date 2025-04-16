@extends('crm.layouts.layout')
@section('header', 'Quản lý thi sinh mới')

@section('content')
<div class="px-6">
    <!--begin::App Breadcrumb-->
    <div class="app_breadcrumb d-flex align-items-center justify-content-between">
        <!-- Đường dẫn web -->
        <div class="x-3 py-4">
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="/" class="text-gray-500">
                        <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Quản lý thí sinh mới</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Thí sinh Lead</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Chi tiết thông tin thí sinh</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-primary">Thêm giao dịch</li>
                <!--end::Item-->
            </ul>
        </div>
    </div>
    <!--end::App Breadcrumb-->

    <!--begin::Content-->
    <div class="card" mx-4>
        <!-- Tiêu đề giao dichj mới -->
        <div class="card-header p-4">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                <!--begin:back button-->
                <a href="{{ route('crm.lead.detail', ['id' => $dataId->id]) }}" class="btn btn-ghost btn-sm">
                    <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                </a>
                <!--end:back button-->
                <!--begin::Title-->
                <h3 class="card-title text-dark fw-bolder m-md-0">Giao dịch mới</h3>
                <!--end::Title-->

            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!-- Form thêm mới -->
        <form id="transaction-form">
            <!--begin::Body-->
            <div class="card-body p-4 mx-5">
                <div class="row gx-3 pt-6">
                    <!--begin::Col-->
                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-name-wrapper">
                            <label for="modal_customer" class="form-label">Tên sinh viên <span
                                    class="text-danger">*</span></label>
                            <select id="transaction-name" name="transaction-name" aria-label="Chọn khách hàng"
                                data-control="select2" data-placeholder="Chọn khách hàng" class="form-select" required>
                                <option value="{{ $dataId->id }}" selected> {{ $dataId->full_name }} </option>
                            </select>
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-status-wrapper">
                            <label for="modal_transaction_status" class="form-label">Trạng thái giao dịch <span
                                    class="text-danger">*</span></label>
                            <select id="transaction-status" name="transaction-status"
                                aria-label="Trạng thái giao dịch" data-control="select2"
                                data-placeholder="Trạng thái giao dịch" class="form-select" required>
                                @foreach ($dataFilter['transaction_status'] as $status)
                                <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!--end::Col-->

                    {{-- <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 academic_terms_id-wrapper">
                                <label for="academic_terms_id" class="form-label">Chọn niên khoá <span
                                        class="text-danger">*</span></label>
                                    @if (!empty($dataAcademicTerms))
                                        <select id="academic_terms" name="academic_terms" aria-label="Chọn Niên khoá"
                                            data-control="select2" data-placeholder="Chọn Niên khoá" class="form-select">
                                            <option value="-" selected> Chọn Niên khoá </option>
                                            @foreach($dataAcademicTerms as $k => $item)
                                                <option value="{{ $item['id'] }}" data-name="{{ $item['name'] }}"> {{ $item['name'] }} {{ !empty($item['from_year']) && !empty($item['to_year']) ? '('.$item['from_year'].'-'.$item['to_year'].')' : '' }} </option>
                                            @endforeach
                                        </select>
                                    @endif
                                 <p class="error-input mt-1"></p>
                        </div>
                    < /div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-12 col-md-6">
                        <div class="mb-6 academic_terms_id-wrapper">
                            <label for="academic_terms_id" class="form-label">Học kỳ <span
                                    class="text-danger">*</span></label>
                            <select id="semesterSelect" name="semesterSelect" aria-label="Chọn Học kỳ" disabled
                                data-placeholder="Chọn Học kỳ" class="form-select">
                                <option value="-" selected> Vui lòng chọn Niên khoá </option>
                            </select>
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!--end::Col--> --}}

                    <!--begin::Col-->
                    {{-- <div class="col-12 col-md-6">
                            <div class="mb-6 transaction-nameTran-wrapper">
                                <label for="modal_transaction_name" class="form-label">Tên giao dịch <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="transaction-nameTran" name="transaction-nameTran"
                                    aria-label="Tên giao dịch" placeholder="Nhập tên giao dịch" class="form-control"
                                    required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div> --}}
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-price-wrapper">
                            <label class="form-label" for="modal_transaction_amount">Giá trị giao dịch (VND) <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="transaction-price" class="form-control"
                                placeholder="Nhập số tiền" id="transaction-price" required />
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-type-wrapper">
                            <label for="modal_transaction_type" class="form-label">Loại giao dịch <span
                                    class="text-danger">*</span></label>
                            <select id="transaction-type" name="transaction-type"
                                aria-label="Loại giao dịch" data-control="select2"
                                data-placeholder="Loại giao dịch" class="form-select" required>
                                @foreach ($dataFilter['transaction_types'] as $types)
                                <option value="{{$types->id}}">{{$types->name}}</option>
                                @endforeach
                            </select>
                            <p class="error-input mt-1"></p>
                        </div>
                    </div>

                    <div class="col-12 transaction-dateTime-wrapper col-md-6">
                        <label for="modal_transaction_date" class="form-label">Ngày giao dịch <span
                                class="text-danger">*</span></label>
                        <div class="row gx-3 mb-6">
                            <div class="col-12 col-md-12">
                                <input name="modal_transaction_date" id="transaction_date" type="date"
                                    class="form-control" required />
                            </div>
                            {{-- <div class="col-12 col-md-6">
                                    <input name="modal_transaction_time" id="transaction_time" type="time"
                                        class="form-control"/>
                                </div> --}}
                        </div>
                        <p class="error-input mt-1"></p>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-priceList-wrapper">
                            <label for="modal_transaction_invoid" class="form-label">Liên hệ hóa đơn <span
                                    class="text-danger">*</span></label>
                            <select id="transaction-priceList" name="modal_transaction_invoid"
                                aria-label="Liên hệ hóa đơn" data-control="select2"
                                data-placeholder="Chọn hóa đơn" placeholder="Chọn hóa đơn" class="form-select">
                                @foreach ($dataId->price_lists as $priceLists)
                                <option value="{{$priceLists->id}}">{{$priceLists->title}}</option>
                                @endforeach
                            </select>
                            <p class="error-input mt-1"></p>
                        </div>

                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-tempMail-lead-wrapper">
                            <label for="modal_customer" class="form-label">Chọn mẫu mail</label>
                            <select id="transaction-tempMail-lead" name="transaction-tempMail-lead" class="form-select">
                                <option value="" disabled selected>Chọn mẫu mail</option>
                                @foreach ($resultTempEmail as $mail)
                                <option value="{{$mail['file_name']}}">{{$mail['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-6 transaction-note-wrapper">
                            <label for="modal_transaction_note" class="form-label">Ghi chú</label>
                            <input type="text" id="transaction-note" name="modal_transaction_note"
                                aria-label="Nhập ghi chú" data-placeholder="Nhập ghi chú"
                                placeholder="Nhập ghi chú" class="form-control" />

                        </div>
                    </div>
                    <!--end::Col-->
            </div>
    </div>
    <!--end::Body-->
    <!--begin::Actions-->
    <div class="card-footer p-4 gap-3 mx-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 mt-3">
                <input type="checkbox" name="auto_send_mail" id="auto_send_mail" class="form-check-input" style="border-radius: 3px; width:20px;height: 20px;">
                <span style="font-size: 13px;padding-left:4px;"><strong>Tắt tự động gửi mail</strong></span>
            </div>
            <div class="col-lg-6 col-md-6 d-flex flex-end">
                <button id="transaction-btn-save" type="submit" class="btn btn-primary">Lưu giao dịch</button>
                
            </div>
        </div>        
    </div>
    <!--end::Actions-->
    </form>
</div>
<!--end::Content-->
</div>
@endsection