<div class="modal fade" id="ti_modal_send_notification" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-950px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 justify-content-between">
                <!--begin::Modal title-->
                <div class="modal-title">
                    <h3 class="fs-3 fw-bold">Gửi thông báo</h3>
                </div>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary btn_close_modal" data-bs-dismiss="modal">
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
                <form id="send_noti_student_form" class="pt-5">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-6 send_noti_student_email_wrapper">
                                <label for="modal_account" class="form-label">Tài khoản <span class="text-danger">*</span></label>
                                <select id="send_noti_account" name="account" aria-label="Chọn tài khoản"
                                    data-control="select2" data-placeholder="Chọn tài khoản" class="form-select" multiple>
                                    <option value="all">Tất cả</option>
                                    @foreach($data as $item)
                                    <option value="{{ $item->email }}">{{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-6 send_noti_student_thread_wrapper">
                                <label for="modal_thread" class="form-label">Chủ đề</label>
                                <input type="text" class="form-control" placeholder="Nhập chủ đề" id="send_noti_student_thread" name="send_noti_thread">
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-6 send_noti_student_title_wrapper">
                                <label class="form-label" for="modal_title">Tiêu đề <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Nhập tiêu đề" id="send_noti_student_title">
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-6 send_noti_student_content_wrapper">
                                <label class="form-label" for="tiny">Nội dung <span
                                        class="text-danger">*</span></label>
                                <textarea class="send_noti_student_content" id="tiny"></textarea>
                                <p class="error-input mt-1"></p>
                            </div>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-between align-items-center mt-15 gap-2">
                        <div class="form-group">
                            <label class="form-label">Gửi tới <span class="text-danger">*</span></label>
                            <div class="d-flex flex-row align-items-center gap-3">
                                <div class="form-check form-check-sm">
                                    <input class="form-check-input" type="radio" name="send_noti_student_type" id="send_to_mail"
                                        value="1" checked>
                                    <label class="text-base" for="send_to_mail">
                                        Mail
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-center gap-2">
                            <div class="btn-send-noti-wrapper w-150px">
                                <button type="submit" id="send_noti_student_submit"
                                    class="btn btn-primary w-150px">Gửi</button>
                            </div>
                            <button type="reset" id="ti_modal_users_search_reset" data-bs-dismiss="modal"
                                class="btn bg-gray-300 me-3 w-150px">Cancel</button>
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
