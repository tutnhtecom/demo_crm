<div class="modal fade" id="ti_modal_add_quota" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 justify-content-between">
                <!--begin::Modal title-->
                <div class="modal-title">
                    <h3 class="fs-3 fw-bold">Tạo học phí</h3>
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
            <div class="modal-body scroll-y mx-5 pt-0 pb-6">
                <form id="form-price-list" class="pt-5">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-6 price-tempMail-lead-wrapper">
                                <label for="modal_customer" class="form-label">Chọn mẫu mail</label>
                                <select id="price-tempMail-lead" name="price-tempMail-lead" class="form-select">
                                    <option value="" disabled selected>Chọn mẫu mail</option>
                                    @foreach ($resultTempEmail as $mail)
                                        <option value="{{$mail['file_name']}}">{{$mail['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 price-name-lead-wrapper">
                                <label for="modal_customer" class="form-label">Sinh viên <span
                                        class="text-danger">*</span></label>
                                <select id="price-name-lead" name="price-name-lead" aria-label="Chọn khách hàng"
                                    data-control="select2" data-placeholder="Chọn khách hàng" class="form-select">
                                    <option value="{{ $dataId->id ?? null}}" selected> {{ $dataId->full_name ?? null}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        {{-- <div class="col-12 col-md-6">
                            <div class="mb-6 price-title-lead-wrapper">
                                <label for="modal_thread" class="form-label">Niên khoá <span
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
                        </div> --}}
                        <div class="col-12 col-md-6">
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
                        <div class="col-12 col-md-6">
                            <div class="mb-6 price-tuition-lead-wrapper">
                                <label class="form-label" for="modal_leaning_fee">Học phí (VND) <span
                                        class="text-danger">*</span></label>
                                <!-- <input type="number" name="modal_leaning_fee" class="form-control"
                                    placeholder="Nhập học phí" id="price-tuition-lead" required /> -->
                                    <input type="text" name="modal_leaning_fee" class="form-control"
                                    placeholder="Nhập học phí" id="price-tuition-lead" required />
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-6 price-date-lead-wrapper">
                                <label class="form-label" for="modal_date_start">Hạn nộp <span class="text-danger">*</span></label>
                                <div class="d-flex flex-stack">
                                    <input type="date" class="form-control price-date-start" id="modal_date_start" required />
                                    <i class="fas fa-arrow-right-arrow-left px-4"></i>
                                    <input type="date" class="form-control" id="modal_date_end" required />
                                </div>
                                <p class="error-input mt-1 error_from_date"></p>
                                <p class="error-input mt-1 error_to_date"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 h-100 price-note-lead-wrapper">
                                <label class="form-label" for="modal_note">Ghi chú</label>
                                <textarea id="price-note-lead" rows="3" class="form-control w-100 h-100"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 h-100 price-file-lead-wrapper">
                                <label class="form-label" for="modal_attachment">Tệp đính kèm</label>
                                <div
                                    class="d-flex flex-column align-items-center justify-content-center rounded border border-gray-300 h-100 p-6">
                                    {{-- <span class="text-muted text-xs w-100 mb-3">Thêm tập tin: (Không bắt buộc), Các loại
                                        tệp được chấp nhận: .pdf</span> --}}
                                    <input class="form-control" type="file" id="price-file-lead" accept=".pdf" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="mt-15 gap-2">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mt-4">
                                 <input type="checkbox" name="auto_send_mail" id="auto_send_mail" class="form-check-input" style="border-radius: 3px; width:20px;height: 20px;">
                                 <span style="font-size: 13px;"><strong>Tắt tự động gửi mail</strong></span>
                            </div>
                            <div class="col-lg-6 col-md-6 d-flex flex-end">
                                <button type="submit" id="price-btn-send" class="btn btn-primary w-150px mx-4" data-email-tmp="TYPE_PRICE_LISTS" data-email-tmp-id="3" >Gửi</button>
                                <button type="reset" id="ti_modal_users_search_reset" data-bs-dismiss="modal"  class="btn bg-gray-300 me-3 w-150px">Hủy</button>
                            </div>
                        </div>
                        
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

