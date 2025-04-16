<div class="modal fade" id="modal_add_transaction" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 justify-content-between">
                <!--begin::Modal title-->
                <div class="modal-title">
                    <h3 class="fs-3 fw-bold">Tạo mới giao dịch</h3>
                </div>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 pt-0 pb-15">
                <form id="transaction-form">
                    <!--begin::Body-->
                    <div class="card-body p-4">
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
                    </div>
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
        <div class="card-footer p-4 d-flex justify-content-end gap-3">
            <button id="transaction-btn-save" type="submit" class="btn btn-primary">Lưu giao dịch</button>
            {{-- <button type="button" class="btn btn-secondary">Hủy</button> --}}
        </div>
        <!--end::Actions-->
        </form>
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>