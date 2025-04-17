@extends('crm.layouts.layout')
@section('header', 'Quản lý sinh viên tiềm năng mới')

@section('content')
    <div class="px-6">
        <!--begin::App Breadcrumb-->
        <div class="app_breadcrumb d-flex align-items-center justify-content-between">
            <!--begin:Breadcrumb-->
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
                    <li class="breadcrumb-item text-primary">Sửa giao dịch</li>
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
                <div class="app-toolbar-wrapper d-flex flex-row flex-wrap align-items-center w-100">
                    <!--begin:back button-->
                    @if(isset($dataId->id))
                        <a href="{{ route('crm.lead.detail', ['id' => $dataId->id]) }}" class="btn btn-ghost btn-sm">
                            <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                        </a>
                    @else
                        <a href="/" class="btn btn-ghost btn-sm">
                            <img src="/assets/crm/media/svg/crm/chevron-left.svg" width="24" height="24" />
                        </a>
                    @endif
                    <!--end:back button-->
                    <!--begin::Title-->
                    <h3 class="card-title text-dark fw-bolder m-md-0">Chỉnh sửa giao dịch</h3>
                    <!--end::Title-->

                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar-->
            <form id="transaction_form_detail">
                <!--begin::Body-->
                <div class="card-body p-4">

                    <div class="row gx-3 pt-6">
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_name_wrapper">
                                <label for="modal_customer" class="form-label">Tên sinh viên <span
                                        class="text-danger">*</span></label>
                                <select id="tran_detail_name" name="transaction-name" aria-label="Chọn khách hàng"
                                    data-control="select2" data-placeholder="Chọn khách hàng" class="form-select" required>
                                    <option value="{{ $dataId->id }}" selected> {{ $dataId->full_name }} </option>
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_status_wrapper">
                                <label for="modal_transaction_status" class="form-label">Trạng thái giao dịch <span
                                        class="text-danger">*</span></label>
                                <select id="tran_detail_status" name="transaction-status"
                                    aria-label="Trạng thái giao dịch" data-control="select2"
                                    data-placeholder="Trạng thái giao dịch" class="form-select" required>
                                    @foreach ($dataFilter['transaction_status'] as $status)
                                        <option value="{{$status->id}}" {{$detailTran['data']['tran_status_id'] == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        {{-- <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_nameTran_wrapper">
                                <label for="modal_transaction_name" class="form-label">Tên giao dịch <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="tran_detail_nameTran" name="transaction-nameTran" value="{{$detailTran['data']['name']}}"
                                    aria-label="Tên giao dịch" placeholder="Nhập tên giao dịch" class="form-control"
                                    hidden />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div> --}}
                        <!--end::Col-->
                        <input type="text" id="tran_detail_nameTran" name="transaction-nameTran" value="{{$detailTran['data']['name']}}"
                                    aria-label="Tên giao dịch" placeholder="Nhập tên giao dịch" class="form-control"
                                    hidden />
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_type_wrapper">
                                <label for="modal_transaction_type" class="form-label">Loại giao dịch <span
                                        class="text-danger">*</span></label>
                                <select id="tran_detail_type" name="transaction-type"
                                    aria-label="Loại giao dịch" data-control="select2"
                                    data-placeholder="Loại giao dịch" class="form-select" required>
                                    @foreach ($dataFilter['transaction_types'] as $types)
                                        <option value="{{$types->id}}" {{$detailTran['data']['tran_types_id'] == $types->id ? 'selected' : ''}}>{{$types->name}}</option>
                                    @endforeach
                                </select>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_price_wrapper">
                                <label class="form-label" for="modal_transaction_amount">Giá trị giao dịch (VND) <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="transaction-price" class="form-control" value="{{ number_format($detailTran['data']['price'], 0, ',', '.') }}  "
                                    placeholder="Nhập số tiền" id="tran_detail_price" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <!--end::Col-->

                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6 transaction_dateTime_wrapper">
                            <label for="modal_transaction_date" class="form-label">Ngày giao dịch <span
                                    class="text-danger">*</span></label>
                            <div class="row gx-3 mb-6">
                                <div class="col-12 col-md-12">
                                    <input value="{{$detailTran['data']['tran_date']}}" name="modal_transaction_date" id="tran_detail_date" type="date"
                                        class="form-control" required />
                                </div>
                                {{-- <div class="col-12 col-md-6">
                                    <input value="{{ substr($detailTran['data']['tran_time'], 0, 5) }}" name="modal_transaction_time" id="tran_detail_time" type="time"
                                        class="form-control" required />
                                </div> --}}
                            </div>
                            <p class="error-input mt-1"></p>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-6">
                            <div class="mb-6 tran_detail_priceList_wrapper">
                                <label for="modal_transaction_invoid" class="form-label">Liên hệ hóa đơn</label>
                                <select id="tran_detail_priceList" name="modal_transaction_invoid"
                                    aria-label="Liên hệ hóa đơn" data-control="select2"
                                    data-placeholder="Chọn hóa đơn" placeholder="Chọn hóa đơn" class="form-select">

                                    @foreach ($dataId->price_lists as $priceLists)
                                        <option value="{{$priceLists->id}}" {{$detailTran['data']['price_lists_id'] == $priceLists->id ? 'selected' : ''}}>{{$priceLists->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-12 col-md-12">
                            <div class="mb-6 tran_detail_note_wrapper">
                                <label for="modal_transaction_note" class="form-label">Ghi chú</label>
                                <input type="text" id="tran_detail_note" name="modal_transaction_note" value="{{$detailTran['data']['note']}}"
                                    aria-label="Nhập ghi chú" data-placeholder="Nhập ghi chú"
                                    placeholder="Nhập ghi chú" class="form-control" />

                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Body-->
                <!--begin::Actions-->
                <div class="card-footer p-4 d-flex justify-content-end gap-3">
                    <button id="btn_tran_edit_save" type="submit" data-id="{{$detailTran['data']['id']}}" class="btn btn-primary">Lưu giao dịch</button>
                    {{-- <button type="button" class="btn btn-secondary">Hủy</button> --}}
                </div>
                <!--end::Actions-->
            </form>
        </div>
        <!--end::Content-->
    </div>

<script type="module" src="/assets/crm/js/htecomJs/editTransaction.js"></script>
@endsection
